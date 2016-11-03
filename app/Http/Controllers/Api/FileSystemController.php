<?php

namespace App\Http\Controllers\Api;

use App\File;
use App\Services\Filesystems\FileShareService;
use App\Services\Filesystems\UserFilesystemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FileSystemController extends ApiController
{

    private $user;

    private $payload;

    public function __construct()
    {
        $this->user = auth('api')->user();
        $this->payload = auth('api')->payload();
    }

    /**
     * This method is a commander for all the specific vfs methods
     * there is a differenciation between mounts ( home / groups / shared )
     * because they has not the same behavior
     *
     * if an array is provided as response, json will be return
     *
     *
     * @param Request $request
     * @param $mount
     * @param $method
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function handleRequests(Request $request, $mount, $method)
    {

        $data = [];

        if ($mount === 'home') {

            $filesystemService = new UserFilesystemService();

            $filesystemService->initialize($this->user, $this->payload->sub);

            $data = $filesystemService->call($method, $request);

        } else if ($mount === 'groups') {
            abort(405, 'not available now');
        } else if ($mount === 'shared') {
            abort(405, 'not available now');
        }

        if (is_array($data)) {
            return response()->json($data);
        }
        return $data;
    }

    /**
     * Serves file with their mime types, this a static resource provider
     * Independent of filesystems
     *
     * A file token is needed to retrieve the file
     *
     * An access token need to be provided to ensure
     * the security if the file is not public
     *
     * There is a gate to check that the user is permitted to open the file
     * if the file is opened inside os.js or other app with bearer in request
     * the user will be resolved automatically
     *
     * if the app is open outside, the access token will resolve the user
     * and his permissions
     *
     * @param Request $request
     */
    public function serveFile(Request $request)
    {

        $file_token = $request->get('file_id');

        $access_token = $request->get('access_key');

        $file = File::where('uuid', $file_token)->first();

        if (!$file) {
            return abort(404, 'Not Found');
        }

        $fileShareService = new FileShareService();

        $fileShareService->initialize($file);

        if (!$fileShareService->can('read', $this->user ?: Cache::get($access_token))) {
            abort(403, 'Not Authorized');
        }

        if ($handle = fopen($file->full_path, "rb")) {
            $length = filesize($file->full_path);
            $etag = md5(serialize(fstat($handle)));
            header("Etag: {$etag}");
            header("Content-type: {$file->mime}; charset=utf-8");
            header("Content-length: {$length}");
            while (!feof($handle)) {
                print fread($handle, 1204 * 1024);
                ob_flush();
                flush();
            }
            fclose($handle);
            exit;
        }

        return abort(404, 'Not Found');
    }

}

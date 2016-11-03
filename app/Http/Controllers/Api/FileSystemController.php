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

        // TODO add time limited access token for sharing and etc
        // For now the token is one access, if the cache returns false
        // Need to search in a "access" table to see access of users on the files

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

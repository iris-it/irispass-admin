<?php

namespace App\Http\Controllers\Api;

use App\Services\UserFilesystemService;
use Illuminate\Http\Request;

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

        return response()->json($data);

    }


}

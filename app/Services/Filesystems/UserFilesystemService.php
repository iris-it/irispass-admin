<?php

namespace App\Services\Filesystems;


use App\File;
use App\User;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Plugin\GetWithMetadata;
use League\Flysystem\Plugin\ListWith;
use Webpatser\Uuid\Uuid;

class UserFilesystemService
{
    const DATE_FORMAT = 'Y-m-d\TH:i:s.Z\Z';

    private $user_container;

    private $filesystem;

    private $user_dir;

    private $user;

    public function initialize(User $user, $user_id)
    {
        $this->user_container = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, config('irispass.osjs.vfs_path')) . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR;

        $this->user_dir = $user_id;

        $this->user = $user;

        $adapter = new Local($this->user_container);

        $this->filesystem = new Filesystem($adapter);
        $this->filesystem->addPlugin(new ListWith);
        $this->filesystem->addPlugin(new GetWithMetadata);

        if ($this->checkExistence($this->user_dir) !== true && !is_dir($this->user_container . $this->user_dir)) {
            $this->filesystem->createDir($this->user_dir);
        }

    }

    public function call($method, Request $request)
    {
        return $this->{$method}($request);
    }

    public function scandir(Request $request)
    {
        $content = [];

        $relative_path = $this->user_dir . DIRECTORY_SEPARATOR . $request->get('rel');
        $virtual_path = $request->get('root') . $request->get('rel');

        foreach ($this->filesystem->listContents($relative_path) as $key => $file) {
            $content[] = $this->getFileData($file, $virtual_path);
        }

        return ['error' => false, 'result' => $content];
    }

    public function write(Request $request)
    {

        return;
    }

    public function read(Request $request)
    {

        logger($request->all());

        $file_path = $this->user_dir . DIRECTORY_SEPARATOR . $request->get('rel');

        $stream = $this->filesystem->readStream($file_path);

        $info = $this->filesystem->getWithMetadata($file_path, ['mimetype', 'size', 'timestamp']);

        $contents = stream_get_contents($stream);

        if (is_resource($stream)) {
            fclose($stream);
        }

        return $contents;
    }

    public function copy(Request $request)
    {
        return [];
    }

    public function move(Request $request)
    {
        return [];
    }

    public function unlink(Request $request)
    {
        return [];
    }


    public function mkdir(Request $request)
    {
        return [];
    }

    public function exists(Request $request)
    {
        return file_exists(self::_getRealPath($arguments['path']));
    }

    public function fileinfo(Request $request)
    {
        return [];
    }

    public function url(Request $request)
    {
        $virtual_path = $request->get('root') . $request->get('rel');

        $file = File::where('virtual_path', $virtual_path)->first();

        if (!$file) {
            $full_path = $this->user_container . $this->user_dir . DIRECTORY_SEPARATOR . $request->get('rel');

            $file = File::create([
                'uuid' => Uuid::generate(4)->string,
                'name' => $this->getFileName($full_path),
                'mime' => $this->getFileMime($full_path),
                'full_path' => $full_path,
                'virtual_path' => $virtual_path,
                'owner_id' => $this->user->sub,
                'users' => [],
                'groups' => [],
                'organizations' => [],
                'is_public' => false
            ]);
        }

        if ($file->is_public) {
            return env('APP_URL') . '/api/filesystem/file?file_id=' . $file->uuid;
        }

        $access_key = Uuid::generate(4)->string;

        Cache::put($access_key, $this->user->sub, config('irispass.file_token_lifetime', 60));

        return env('APP_URL') . '/api/filesystem/file?file_id=' . $file->uuid . '&access_key=' . $access_key;
    }

    public function upload(Request $request)
    {
        return [];
    }

    public function download(Request $request)
    {
        return [];
    }

    public function freeSpace(Request $request)
    {
        return [];
    }

    public function find(Request $request)
    {
        return [];
    }

    public function checkExistence($identifier)
    {
        $exists = false;

        $adapter = new Local($this->user_dir);

        $filesystem = new Filesystem($adapter);

        $contents = $filesystem->listContents('/');

        foreach ($contents as $directory) {
            if ($directory['basename'] == $identifier) {
                $exists = true;
                return $exists;
            }
        }

        return $exists;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////                       UTILS                      ////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function getFileData($file, $virtual_path)
    {

        $full_path = $this->user_container . $file['path'];

        $type = @is_dir($full_path) ? 'dir' : 'file';
        $mime = '';
        $size = 0;

        if ($type === 'file') {
            if (is_writable($full_path) || is_readable($full_path)) {
                $mime = $this->getFileMime($full_path);
                $size = filesize($full_path);
            }
        }

        return [
            'filename' => utf8_encode($file['basename']),
            'path' => utf8_encode($virtual_path . $file['basename']),
            'size' => $size ?: 0,
            'type' => $type,
            'mime' => $mime,
            'ctime' => $this->getFileCtime($full_path) ?: null,
            'mtime' => $this->getFileMtime($full_path) ?: null
        ];
    }

    public function getFileCtime($full_path)
    {
        if (($ctime = @filectime($full_path)) > 0) {
            return date(self::DATE_FORMAT, $ctime);
        }

        return null;
    }

    public function getFileMtime($full_path)
    {
        if (($mtime = @filemtime($full_path)) > 0) {
            return date(self::DATE_FORMAT, $mtime);
        }

        return null;
    }

    public function getFileMime($full_path)
    {
        if (is_string($full_path) && $full_path !== '' && is_file($full_path)) {
            if ($extension = pathinfo($full_path, PATHINFO_EXTENSION)) {
                $extension = strtolower($extension);
                $mime = config('mimes');
                if (isset($mime[$extension])) {
                    return $mime[$extension];
                }
            }
        }

        return null;
    }

    public function getFileName($full_path)
    {
        return basename($full_path);
    }


}
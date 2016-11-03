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


    /**
     * This function initialize the filesystem
     *
     * the user_container is the full qualified path to the users homes ( where users folders are stored)
     * the user_dir is the user home ( the user directory and his files inside )
     *
     * the checkExistence is used to check if a new user has his home directory or not
     * it will be created if not.
     *
     * @param User $user
     * @param $user_id
     */
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

    /**
     * This method is used to call specific VFS methods
     * There is a need to dynamically call the function
     * because we can apply many middleware like :
     * - create file objects if they not exist and retrieve 'em
     * - check if the user has rights to make an action like read or write
     *
     * @param $method
     * @param Request $request
     * @return mixed
     */
    public function call($method, Request $request)
    {
        //middleware ? on methods
        if (in_array($method, ['read', 'url', 'exists', 'fileinfo'])) {
            $file = $this->createOrGetFile($request, $this->user->sub);

            $this->checkUserReadPermissions($file);

            return $this->{$method}($request, $file);
        }

        if (in_array($method, ['write', 'mkdir'])) {
            return $this->{$method}($request);
        }

        return $this->{$method}($request);
    }

    /**
     * This method lists the content of a directory
     * and call a method to apply a layout for the response
     *
     * @param Request $request
     * @return array
     */
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

    /**
     * Open a file and write his content in the output
     * with the corrects header to emulate a real file
     *
     * @param Request $request
     * @param $file
     */
    public function read(Request $request, $file)
    {
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

        logger($request->all());

        return [];
    }

    /**
     * Check the existance of a file for a fully qualified path
     *
     * @param Request $request
     * @param $file
     * @return array
     */
    public function exists(Request $request, $file)
    {
        return ['status' => file_exists($file->full_path)];
    }

    /**
     * Get and return information on a file for a fully qualified path
     * @param Request $request
     * @param $file
     * @return array
     */
    public function fileinfo(Request $request, $file)
    {
        return [
            'filename' => $file->name,
            'path' => $file->virtual_path,
            'size' => filesize($file->full_path) ?: 0,
            'type' => 'file',
            'mime' => $file->mime,
            'ctime' => $this->getFileCtime($file->full_path) ?: null,
            'mtime' => $this->getFileMtime($file->full_path) ?: null
        ];
    }

    /**
     * This method generate an unique URL to a file
     * if the file is public, no access_token will be provided
     *
     * if the file is private, an access_token will be provided
     * to ensure the security of the file, the access token is
     * a key value with a random key and the user sub a value
     *
     * this method serves URL for the method FileSystemController@serveFile
     *
     * @param Request $request
     * @param $file
     * @return string
     */
    public function url(Request $request, $file)
    {
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


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////                       UTILS                      ////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * This method tries to find an file representation in the database
     * if not found it will be created and returned
     *
     * @param $request
     * @param $user_sub
     * @return \App\File
     */
    public function createOrGetFile($request, $user_sub)
    {
        $virtual_path = $request->get('root') . $request->get('rel');

        $full_path = $this->user_container . $this->user_dir . DIRECTORY_SEPARATOR . $request->get('rel');

        $file = File::where('virtual_path', $virtual_path)->first();

        if (!$file) {
            return File::create([
                'uuid' => Uuid::generate(4)->string,
                'name' => utf8_encode($this->getFileName($full_path)),
                'mime' => utf8_encode($this->getFileMime($full_path)),
                'full_path' => utf8_encode($full_path),
                'virtual_path' => utf8_encode($virtual_path),
                'owner_id' => utf8_encode($user_sub),
                'users' => [],
                'groups' => [],
                'organizations' => [],
                'is_public' => false
            ]);
        }

        return $file;
    }

    /**
     * Retrieve file information and layout the content
     * @param $file
     * @param $virtual_path
     * @return array
     */
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

    /**
     * Get created timestamp of a file
     *
     * @param $full_path
     * @return false|null|string
     */
    public function getFileCtime($full_path)
    {
        if (($ctime = @filectime($full_path)) > 0) {
            return date(self::DATE_FORMAT, $ctime);
        }

        return null;
    }

    /**
     * Get modified timestamp of a file
     *
     * @param $full_path
     * @return false|null|string
     */
    public function getFileMtime($full_path)
    {
        if (($mtime = @filemtime($full_path)) > 0) {
            return date(self::DATE_FORMAT, $mtime);
        }

        return null;
    }

    /**
     * Get the file mimetype based on his extension
     * this use a fully qualified path
     * all the mimes types are store in a config file mimes.php
     *
     * @param $full_path
     * @return null
     */
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

    /**
     * Returns the filename based on his fully qualified path
     *
     * @param $full_path
     * @return string
     */
    public function getFileName($full_path)
    {
        return basename($full_path);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////   Permissions     /////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Check user read permissions against a file
     *
     * @param $file
     */
    public function checkUserReadPermissions($file)
    {
        $fileShareService = new FileShareService();

        $fileShareService->initialize($file);

        if (!$fileShareService->can('read', $this->user)) {
            abort(403, 'Not Authorized');
        }
    }

    /**
     * Check user write permissions against a file
     *
     * @param $file
     */
    public function checkUserWritePermissions($file)
    {
        $fileShareService = new FileShareService();

        $fileShareService->initialize($file);

        if (!$fileShareService->can('write', $this->user)) {
            abort(403, 'Not Authorized');
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////      General      /////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Search the existance of the home directory of a given user based on his sub
     *
     * @param $identifier
     * @return bool
     */
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


}
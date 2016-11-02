<?php

namespace App\Services;


use App\User;
use ErrorException;
use Illuminate\Http\Request;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Plugin\GetWithMetadata;
use League\Flysystem\Plugin\ListWith;

class UserFilesystemService
{
    const DATE_FORMAT = 'Y-m-d\TH:i:s.Z\Z';

    private $user_container;

    private $filesystem;

    private $user_dir;

    public function initialize(User $user, $user_id)
    {
        $this->user_container = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, config('irispass.osjs.vfs_path')) . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR;

        $this->user_dir = $user_id;

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
        switch ($method) {

            case 'scandir':
                return $this->scandir($request);
                break;

            case 'write':
                return $this->write($request);
                break;

            case 'read':
                return $this->read($request);
                break;

            case 'copy':
                return $this->copy($request);
                break;

            case 'move':
                return $this->move($request);
                break;

            case 'unlink':
                return $this->unlink($request);
                break;

            case 'mkdir':
                return $this->mkdir($request);
                break;

            case 'exists':
                return $this->exists($request);
                break;

            case 'fileinfo':
                return $this->fileinfo($request);
                break;

            case 'url':
                return $this->url($request);
                break;

            case 'upload':
                return $this->upload($request);
                break;

            case 'download':
                return $this->download($request);
                break;

            case 'freeSpace':
                return $this->freeSpace($request);
                break;

            case 'find':
                return $this->find($request);
                break;
        }

        return [];
    }

    public function scandir(Request $request)
    {
        $content = [];

        $relative_path = $this->user_dir . DIRECTORY_SEPARATOR . $request->get('rel');

        $full_path = $this->user_container . $relative_path;

        $listing = $this->filesystem->listWith([
            'size',
            'timestamp'
        ], $relative_path, true);

        foreach ($listing as $key => $file) {
            $object = [];

            $mimetype = $this->getFileMime($full_path . $file['basename']);

            $object['filename'] = $file['basename'];
            $object['mime'] = (isset($mimetype)) ? $mimetype : null;
            $object['path'] = $request->get('root') . $request->get('rel') . $file['basename'];
            $object['size'] = (isset($file['size'])) ? $file['size'] : 0;
            $object['type'] = $file['type'];
            $object['ctime'] = date(self::DATE_FORMAT, $file['timestamp']);
            $object['mtime'] = null;

            $content[] = $object;
        }

        return ['error' => false, 'result' => $this->encodeData($content)];
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
        return [];
    }

    public function fileinfo(Request $request)
    {
        return [];
    }

    public function url(Request $request)
    {
        return [];
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

    public function getFileMime($file_name)
    {
        if (is_string($file_name) && $file_name !== '' && is_file($file_name)) {
            if ($extension = pathinfo($file_name, PATHINFO_EXTENSION)) {
                $extension = strtolower($extension);
                $mime = config('mimes');
                if (isset($mime[$extension])) {
                    return $mime[$extension];
                }
            }
        }

        return null;
    }

    public function encodeData($data)
    {
        if (is_array($data)) {
            array_walk_recursive($data, function (&$item, $key) {
                if (is_string($item)) {
                    if (!mb_detect_encoding($item, 'utf-8', true)) {
                        $item = utf8_encode($item);
                    }
                }
            });
        } else {
            $data = utf8_encode($data);
        }

        return $data;
    }

}
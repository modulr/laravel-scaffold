<?php namespace App\Http\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Image;

class Upload {

    protected $file;
    protected $meta;
    protected $allowedResize = [
            'image/jpg',
            'image/jpeg',
            'image/png',
            'image/gif',
        ];

    /**
     * [upload description]
     * @param  [file]   $file  [description]
     * @param  [string] $path  [description]
     * @return [obj]    $this  [description]
     */
    public function upload($file, $path)
    {
        $this->file = $file;

        $path = $this->file->store($path);

        $this->getMeta($path);

        return $this;
    }

    /**
     * [uploadTemp description]
     * @param  [file] $file [description]
     * @return [obj]  $this [description]
     */
    public function uploadTemp($file)
    {
        $this->file = $file;

        $path = $this->file->store('temp/'.Auth::id());

        $this->getMeta($path);

        return $this;
    }
    /**
     * [move description]
     * @param  [string] $from [path]
     * @param  [string] $to   [path]
     * @return [obj]    $this [description]
     */
    public function move($from, $to)
    {
        $this->getMeta($from);

        $to = $to.'/'.$this->meta['basename'];

        Storage::move($from, $to);

        $this->getMeta($to);

        return $this;
    }

    /**
     * [resize description]
     * @param  [integer] $width [pixels]
     * @param  [integer] $height [pixels]
     * @return [obj]    $this [description]
     */
    public function resize($width=null, $height=null)
    {
        if (in_array($this->meta['type'], $this->allowedResize)) {

            $file = Storage::get($this->meta['path']);

            $img = Image::make($file)
                        ->fit($width, $height, function ($constraint) {
                            //$constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->encode();

            $this->meta['size'] = strlen((string) $img);

            Storage::put($this->meta['path'], (string) $img);
        }

        return $this;
    }

    /**
     * [thumbnail description]
     * @param  [integer] $width [pixels]
     * @param  [integer] $height [pixels]
     * @return [obj]    $this [description]
     */
    public function thumbnail($width=null, $height=null)
    {
        if (in_array($this->meta['type'], $this->allowedResize)) {

            $file = Storage::get($this->meta['path']);

            $img = Image::make($file)
                        ->fit($width, $height)
                        // ->resize($width, $height, function ($constraint) {
                        //     $constraint->aspectRatio();
                        //     $constraint->upsize();
                        // })
                        // ->crop($width, $height)
                        ->encode();

            Storage::put($this->meta['dirname'].'/thumbnail_'.$this->meta['basename'], (string) $img);
        }

        return $this;
    }

    /**
     * [getData description]
     * @return [array] [description]
     */
    public function getData()
    {
        return $this->meta;
    }

    /**
     * [getMeta description]
     * @param  [string] $path   [description]
     * @return [obj]    $this   [description]
     */
    private function getMeta($path)
    {
        $this->meta = pathinfo($path);
        $this->meta['path'] = $path;

        if ($this->file) {
            $this->meta['name'] = $this->file->getClientOriginalName();
            $this->meta['type'] = $this->file->getClientMimeType();
            $this->meta['size'] = $this->file->getClientSize();
            $this->meta['isValid'] = $this->file->isValid();
            $this->meta['maxFileSize'] = $this->file->getMaxFilesize();
            $this->meta['error'] = $this->file->getError();
            $this->meta['errorMessage'] = $this->file->getErrorMessage();
        } else {
            $this->meta['type'] = Storage::mimeType($path);
            $this->meta['size'] = Storage::size($path);
            $this->meta['meta'] = Storage::getMetaData($path);
        }

        return $this;
    }
}

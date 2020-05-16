<?php

namespace Kusikusi\Models;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Mimey\MimeTypes;
use Kusikusi\Models\EntityModel;

class MediumModel extends EntityModel
{

    protected $contentFields = [ "title", "description"];
    protected $propertiesFields = [ "size", "lang", "format", "length", "exif", "width", "height" ];
    protected $defaultParent = 'media';

    protected function getTitleAsSlug($preset) {
        $filename = isset($this['title']) ? Str::slug($this['title']) : 'media';
        $fileformat = Config::get("media.presets.{$preset}.format", false) ??  (isset($this['format']) ? Str::slug($this['format']) : 'bin');
        return "{$filename}.{$fileformat}";
    }
    protected static function getProperties($file) {
        $typeOfFile = gettype($file) === 'object' ? Str::afterLast(get_class($file), '\\') : (gettype($file) === 'string' ? 'path' : 'unknown');
        if ($typeOfFile === 'UploadedFile') {
            $format = strtolower($file->getClientOriginalExtension() ? $file->getClientOriginalExtension() : $file->guessClientExtension());
            $mimeType = $file->getClientMimeType();
            $originalName = $file->getClientOriginalName();
            $size = $file->getSize();
        } else if ($typeOfFile === 'path') {
            $format = strtolower(Str::afterLast($file, '.'));
            $mimes = new MimeTypes;
            $mimeType =  $mimes->getMimeType($format);
            $originalName = Str::afterLast($file, '/');
            $size = null;
        } else {
            $format = 'bin';
            $mimeType = 'application/octet-stream';
            $originalName = 'file.bin';
            $size = null;
        }
        $format = $format == 'jpeg' ? 'jpg': $format;
        $properties = [
            'format' => $format,
            'mimeType' => $mimeType,
            'originalName' => $originalName,
            'size' => $size,
            'isWebImage' => array_search(strtolower($format), config('media.formats.webImages', ['jpeg', 'jpg', 'png', 'gif'])) !== false,
            'isImage' => array_search(strtolower($format), config('media.formats.images', ['jpeg', 'jpg', 'png', 'gif', 'tif', 'tiff', 'iff', 'bmp', 'psd'])) !== false,
            'isAudio' => array_search(strtolower($format), config('media.formats.audios', ['mp3', 'wav', 'aiff', 'aac', 'oga', 'pcm', 'flac'])) !== false,
            'isWebAudio' => array_search(strtolower($format), config('media.formats.webAudios', ['mp3', 'oga'])) !== false,
            'isVideo' => array_search(strtolower($format), config('media.formats.videos', ['mov', 'mp4', 'qt', 'avi', 'mpe', 'mpeg', 'ogg', 'm4p', 'm4v', 'flv', 'wmv'])) !== false,
            'isWebVideo' => array_search(strtolower($format), config('media.formats.webVideos', ['webm', 'mp4', 'ogg', 'm4p', 'm4v'])) !== false,
            'isDocument' => array_search(strtolower($format), config('media.formats.documents', ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'htm', 'html', 'txt', 'rtf', 'csv', 'pps', 'ppsx', 'odf', 'key', 'pages', 'numbers'])) !== false
        ];
        $properties['type'] = $properties['isImage'] ? 'image' : ($properties['isAudio'] ? 'audio' : ($properties['isVideo'] ? 'video' : ($properties['isDocument'] ? 'document' : 'file')));
        if ($properties['isImage']) {
            if ($typeOfFile === 'UploadedFile') {
                $image = Image::make($file->getRealPath());
            } else if ($typeOfFile === 'path') {
                $image = Image::make($file);
            }
            if ($image) {
                $properties['width'] = $image->width();
                $properties['height'] = $image->height();
                $properties['exif'] = $image->exif();
            }
        } else {
            $properties['exif'] = null;
            $properties['width'] = null;
            $properties['height'] = null;
        }
        return $properties;
    }

}

<?php

namespace Kusikusi\Models;

use App\Models\Medium;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Mimey\MimeTypes;
use Kusikusi\Models\EntityModel;
use Illuminate\Support\Facades\Storage;

class MediumModel extends EntityModel
{

    protected $contentFields = [ "title", "description"];
    protected $propertiesFields = [ "size", "lang", "format", "length", "exif", "width", "height" ];
    protected $defaultParent = 'media';

    protected function getTitleAsSlug($preset) {
        $filename = isset($this['title']) ? Str::slug($this['title']) : 'media';
        $fileformat = Arr::get(Medium::PRESETS, "{$preset}.format", (isset($this->properties['format']) ? Str::slug($this->properties['format']) : 'bin'));
        return "{$filename}.{$fileformat}";
    }
    protected function getUrl($preset) {
        if (isset($this->properties['format'])) {
            if ($this->properties['format'] === 'svg') {
                $preset = 'original';
            }
        }
        if ((isset($this->properties['isWebImage']) && $this->properties['isWebImage']) || $preset == 'original') {
            return "/media/$this->id/$preset/{$this->getTitleAsSlug($preset)}";
        }
        return null;
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
            'isWebImage' => array_search(strtolower($format), config('media.formats.webImages', ['jpeg', 'jpg', 'png', 'gif', 'svg'])) !== false,
            'isImage' => array_search(strtolower($format), config('media.formats.images', ['jpeg', 'jpg', 'png', 'gif', 'tif', 'tiff', 'iff', 'bmp', 'psd', 'svg'])) !== false,
            'isAudio' => array_search(strtolower($format), config('media.formats.audios', ['mp3', 'wav', 'aiff', 'aac', 'oga', 'pcm', 'flac'])) !== false,
            'isWebAudio' => array_search(strtolower($format), config('media.formats.webAudios', ['mp3', 'oga'])) !== false,
            'isVideo' => array_search(strtolower($format), config('media.formats.videos', ['mov', 'mp4', 'qt', 'avi', 'mpe', 'mpeg', 'ogg', 'm4p', 'm4v', 'flv', 'wmv'])) !== false,
            'isWebVideo' => array_search(strtolower($format), config('media.formats.webVideos', ['webm', 'mp4', 'ogg', 'm4p', 'm4v'])) !== false,
            'isDocument' => array_search(strtolower($format), config('media.formats.documents', ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'htm', 'html', 'txt', 'rtf', 'csv', 'pps', 'ppsx', 'odf', 'key', 'pages', 'numbers'])) !== false
        ];
        $properties['type'] = $properties['isImage'] ? 'image' : ($properties['isAudio'] ? 'audio' : ($properties['isVideo'] ? 'video' : ($properties['isDocument'] ? 'document' : 'file')));
        if ($properties['isImage'] && $format !== 'svg') {
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
    public static function clearStatic($entity_id = null) {
        $cleared = [];
        if ($entity_id) {
            if (Storage::disk('media_processed')->deleteDirectory($entity_id, true)) $cleared[] = $entity_id;
        } else {
            $directories = Storage::disk('media_processed')->directories(null, false);
            foreach ($directories as $directory) {
                $deleted = Storage::disk('media_processed')->deleteDirectory($directory, true);
                if ($deleted) $cleared[] = $directory;
            }
        }
        return $cleared;
    }
}

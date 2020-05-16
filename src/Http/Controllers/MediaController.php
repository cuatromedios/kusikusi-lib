<?php

namespace Kusikusi\Http\Controllers;

use App\Models\Entity;
use App\Models\Medium;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Gets a medium: Optimized using a preset if it is an image or the original one if not.
     *
     * @group Media
     * @urlParam entity_id required The id of the entity of type medium to get. Example: djr4sd7Gmd
     * @urlParam preset required A preset configured in config/media.php to process the image. Example: icon.
     * @return Response
     */
    public function get(Request $request, $entity_id, $preset, $friendly = NULL)
    {

        // TODO: Review if the user can read the media
        $entity = Entity::isPublished()->findOrFail($entity_id);
        // Paths
        $originalFilePath =   $entity_id . '/file.' . $entity->properties['format'];
        $presetSettings = Config::get('media.presets.' . $preset, NULL);
        // $publicFilePath = $entity_id . '/' .  $preset . '.' . $presetSettings['format'];
        $publicFilePath = Str::after($request->getPathInfo(), '/media');
        if ($exists = Storage::disk('media_processed')->exists($publicFilePath)) {
            return $this->getCachedImage($publicFilePath);
        }

        if (NULL === $presetSettings) {
            abort(404, "No media preset '$preset' found");
        }

        if (!$exists = Storage::disk('media_original')->exists($originalFilePath)) {
            abort(404, 'File for medium ' . $originalFilePath . ' not found');
        }

        $filedata = Storage::disk('media_original')->get($originalFilePath);
        if (array_search($entity->properties['format'], ['jpg', 'png', 'gif']) === FALSE) {
            return new Response(
                $filedata,  200,
                [
                    'Content-Type' => Storage::disk('media_original')->getMimeType($originalFilePath),
                    'Content-Length' => Storage::disk('media_original')->size($originalFilePath)
                ]
            );
        }

        // Set default values if not set
        data_fill($presetSettings, 'width', 256);  // int
        data_fill($presetSettings, 'height', 256); // int
        data_fill($presetSettings, 'scale', 'cover'); // contain | cover | fill
        data_fill($presetSettings, 'alignment', 'center'); // only if scale is 'cover' or 'contain' with background: top-left | top | top-right | left | center | right | bottom-left | bottom | bottom-right
        data_fill($presetSettings, 'background', 'crop'); // only if scale is 'contain': crop | #HEXCODE
        data_fill($presetSettings, 'quality', 80); // 0 - 100 for jpg | 1 - 8, (bits) for gif | 1 - 8, 24 (bits) for png
        data_fill($presetSettings, 'format', 'jpg'); // jpg | gif | png
        data_fill($presetSettings, 'effects', []); // ['colorize' => [50, 0, 0], 'grayscale' => [] ]


        // The fun
        $image = Image::make($filedata);
        if ($presetSettings['scale'] === 'cover') {
            $image->fit($presetSettings['width'], $presetSettings['height'], NULL, $presetSettings['alignment']);
        } elseif ($presetSettings['scale'] === 'fill') {
            $image->resize($presetSettings['width'], $presetSettings['height']);
        } elseif ($presetSettings['scale'] === 'contain') {
            $image->resize($presetSettings['width'], $presetSettings['height'], function ($constraint) {
                $constraint->aspectRatio();
            });
            $matches = preg_match('/#([a-f0-9]{3}){1,2}\b/i', $presetSettings['background'], $matches);
            if ($matches) {
                $image->resizeCanvas($presetSettings['width'], $presetSettings['height'], $presetSettings['alignment'], false, $presetSettings['background']);
            }
        }

        foreach ($presetSettings['effects'] as $key => $value) {
            $image->$key(...$value);
        }

        $image->encode($presetSettings['format'], $presetSettings['quality']);
        Storage::disk('media_processed')->put($publicFilePath, $image);

        return $this->getCachedImage($publicFilePath);
    }
    private function getCachedImage($publicFilePath) {
        $cachedImage = Storage::disk('media_processed')->get($publicFilePath);
        return new Response(
            $cachedImage,  200,
            [
                'Content-Type' => Storage::disk('media_processed')->getMimeType($publicFilePath),
                'Content-Length' => Storage::disk('media_processed')->size($publicFilePath)
            ]
        );
    }

    /**
     * Uploads a medium
     *
     * @group Media
     * @urlParam entity_id The id of the entity to upload a medium or file
     * @bodyParam file required The file to be uploaded
     * @bodyParam thumb optional An optional file to represent the media, for example a thumb of a video
     * @responseFile responses/entities.index.json
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request, $entity_id)
    {
        $entity = Entity::findOrFail($entity_id);
        function processFile($id, $function, UploadedFile $file)
        {
            $properties = Medium::getProperties($file);
            $storageFileName = $function . '.' . $properties['format'];
            Storage::disk('media_original')->putFileAs($id, $file, $storageFileName);
            Storage::disk('media_processed')->deleteDirectory($id);
            return $properties;
        }

        $properties = NULL;
        if ($request->hasFile('thumb') && $request->file('thumb')->isValid()) {
            $properties = processFile($entity_id, 'thumb', $request->file('thumb'));
        }
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $properties = processFile($entity_id, 'file', $request->file('file'));
            $entity['properties'] = array_merge($entity['properties'], $properties);
            $entity->save();
        }
        if ($properties === NULL) {
            return(JsonResponse::create(["error" => "No files found in the request or exceed server setting of file size"], 422));
        } else {
            return ($properties);
        }
    }
}

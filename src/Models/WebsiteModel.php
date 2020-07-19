<?php

namespace Kusikusi\Models;

use App\Models\Home;
use App\Models\Website;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Kusikusi\Models\EntityRelation;

class WebsiteModel extends EntityModel
{

    protected $contentFields = [ "title"];
    protected $propertiesFields = [ "theme_color", "background_color" ];

    protected static function boot()
    {
        parent::boot();
        self::saved(function ($entity) {
            self::recreateFavicons($entity);
        });
    }
    protected static function recreateFavicons($entity) {

        $faviconRelation = EntityRelation::select('relations.called_entity_id', 'entities.properties->format as format')
            ->where('caller_entity_id',$entity->id)
            ->where('kind', EntityRelation::RELATION_MEDIA)
            ->whereJsonContains('tags', 'favicon')
            ->leftJoin("entities", function ($join) {
                $join->on("relations.called_entity_id", "entities.id");
            })
            ->first();
        if ($faviconRelation) {
            $id = $faviconRelation->called_entity_id;
            $path =   $id . '/file.' . $faviconRelation->format;
            if (Storage::disk('media_original')->exists($path)) {

                $image = Image::canvas(192, 192)
                    ->insert(Image::make(storage_path("media/$path"))->resize(192, 192))
                    ->encode('png');
                Storage::disk('views_processed')->put("favicons/android-chrome-192x192.png", $image);

                $image = Image::canvas(512, 512)
                    ->insert(Image::make(storage_path("media/$path"))->resize(512, 512))
                    ->encode('png');
                Storage::disk('views_processed')->put("favicons/android-chrome-512x512.png", $image);

                $image = Image::canvas(180, 180, $entity->properties['background_color'])
                    ->insert(Image::make(storage_path("media/$path"))->resize(148, 148), 'center')
                    ->encode('png');
                Storage::disk('views_processed')->put("favicons/apple-touch-icon.png", $image);

                $image = Image::canvas(16, 16)
                    ->insert(Image::make(storage_path("media/$path"))->resize(16, 16))
                    ->encode('png');
                Storage::disk('views_processed')->put("favicons/favicon-16x16.png", $image);

                $image = Image::canvas(32, 32)
                    ->insert(Image::make(storage_path("media/$path"))->resize(32, 32))
                    ->encode('png');
                Storage::disk('views_processed')->put("favicons/favicon-32x32.png", $image);

                $image = Image::canvas(270, 270)
                    ->insert(Image::make(storage_path("media/$path"))->resize(126, 126), 'top', null, 50)
                    ->encode('png');
                Storage::disk('views_processed')->put("favicons/mstile-150x150.png", $image);

                $favicon = new \PHP_ICO(storage_path("media/$path"), [[48,48]]);
                $favicon->save_ico(sys_get_temp_dir()."/favicon.ico");
                Storage::disk('views_processed')->putFileAs("favicons", sys_get_temp_dir()."/favicon.ico", "favicon.ico");

                $favicon = new \PHP_ICO(storage_path("media/$path"), [[16,16]]);
                $favicon->save_ico(sys_get_temp_dir()."/favicon.ico");
                Storage::disk('views_processed')->putFileAs("", sys_get_temp_dir()."/favicon.ico", "favicon.ico");
            }
        }
        $socialRelation = EntityRelation::select('relations.called_entity_id', 'entities.properties->format as format')
            ->where('caller_entity_id',$entity->id)
            ->where('kind', EntityRelation::RELATION_MEDIA)
            ->whereJsonContains('tags', 'social')
            ->leftJoin("entities", function ($join) {
                $join->on("relations.called_entity_id", "entities.id");
            })
            ->first();
        if ($socialRelation) {
            $id = $socialRelation->called_entity_id;
            $path =   $id . '/file.' . $socialRelation->format;
            if (Storage::disk('media_original')->exists($path)) {
                $image = Image::canvas(1200, 1200, $entity->properties['background_color'])
                    ->insert(Image::make(storage_path("media/$path"))->fit(1200, 1200))
                    ->encode('png');
                Storage::disk('views_processed')->put("favicons/social.png", $image);
            }
        }
        $theme_color = isset($entity->properties['theme_color']) ? $entity->properties['theme_color'] : "#000000";
        $background_color = isset($entity->properties['theme_color']) ? $entity->properties['theme_color'] : "#ffffff";
        $browserconfig = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<browserconfig>
    <msapplication>
        <tile>
            <square150x150logo src=\"/favicons/mstile-150x150.png\"/>
            <TileColor>".strip_tags($theme_color)."</TileColor>
        </tile>
    </msapplication>
</browserconfig>
";
        $titleContent = EntityContent::select('text')
            ->where('entity_id', $entity->id)
            ->where('field', 'title')
            ->where('lang', config('cms.langs', [''])[0])
            ->first();
        $name = $titleContent ? $titleContent->text : '';
        Storage::disk('views_processed')->put("favicons/browserconfig.xml", $browserconfig);
        $webmanifest = [
            "name" => strip_tags($name),
            "short_name" => strip_tags($name),
            "icons" => [
                [
                    "src" => "/favicons/android-chrome-192x192.png",
                    "sizes" => "192x192",
                    "type" => "image/png"
                ],
                [
                    "src" => "/favicons/android-chrome-512x512.png",
                    "sizes" => "512x512",
                    "type" => "image/png"
                ]
            ],
            "theme_color" => $theme_color,
            "background_color" => $background_color,
            "display" => "standalone"
        ];
        Storage::disk('views_processed')->put("favicons/site.webmanifest", json_encode($webmanifest, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
    public static function clearStatic($entity_id = null) {
        if ($entity_id) {
            $routes = Route::where('entity_id', $entity_id)->get();
            foreach ($routes as $route) {
                Storage::disk('views_processed')->deleteDirectory($route->path, true);
                Storage::disk('views_processed')->delete($route->path.'.html');
                $cleared[] = $route->path;
            }
        } else {
            $directories = Storage::disk('views_processed')->directories(null, false);
            $files = Storage::disk('views_processed')->files(null, false);
            $cleared = [];
            foreach ($directories as $directory) {
                if (!in_array($directory, ['styles', 'js', 'favicons', 'media', 'images'])) {
                    Storage::disk('views_processed')->deleteDirectory($directory, true);
                    $cleared[] = $directory;
                }
            }
            foreach ($files as $file) {
                if (!in_array($file, ['robots.txt', 'favicon.ico', 'sitemap.xml'])) {
                    Storage::disk('views_processed')->delete($file);
                    $cleared[] = $file;
                }
            }
        }
        return $cleared;
    }
    public static function recreateStatic() {
        // TODO: Develop this method, should even recreate the LaravelMix assets
        WebsiteModel::clearStatic();
        MediumModel::clearStatic();
        Storage::disk('views_processed')->delete('favicon.ico');
        Storage::disk('views_processed')->deleteDirectory('favicons');
        $website = Website::find('website');
        WebsiteModel::recreateFavicons($website);
        return true;
    }
}

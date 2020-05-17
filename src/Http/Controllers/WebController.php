<?php

namespace Kusikusi\Http\Controllers;

use App\Http\Controllers\HtmlController;
use Illuminate\Http\Request;
use Kusikusi\Models\Route;
use Illuminate\Support\Facades\App;

class WebController extends Controller
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
     * Locates an entity based on the url, and returns the HTML view of that entity as a webpage
     *
     * @group Web
     * @param $request \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function any(Request $request)
    {
        $path = $request->path() == '/' ? '/' : '/' . $request->path();
        $originalExtension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $format = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if ($format === '') {
            $isDirectory = true;
            $format = 'html';
        } else {
            $isDirectory = false;
            $path = substr($path, 0, strrpos($path, "."));
        }
        $path = preg_replace('/\/index$/', '', $path);
        if ($path === '') $path = '/';
        $filename = strtolower(pathinfo($path, PATHINFO_FILENAME));

        // Search for the entity is being called by its url, ignore inactive and soft deleted.
        // TODO: Is there a better way using Laravel Query builder or native
        /* $langs = config('cms.langs', ['en']);
        $searchResult = EntityModel::select("id", "model")
            ->orWhere("properties->url", $url);
        foreach ($langs as $searchLang) {
            $searchResult->orWhere("properties->url->$searchLang", $url);
        }
        $searchResult = $searchResult->first();
        */
        $defaultLang = config('cms.langs', [''])[0];
        App::setLocale($defaultLang);
        $searchResult = Route::where('path', $path)->first();
        if (!$searchResult) {
            $request->lang = $defaultLang;
            $controller = new HtmlController();
            return ($controller->error($request, 404));
        }
        if ($searchResult->default === false) {
            $redirect = Route::where('entity_id', $searchResult->entity_id)
                ->where('lang', $searchResult->lang)
                ->where('default', true)
                ->first();
            if ($redirect) {
                return redirect($redirect->path . ($originalExtension !== '' ? '.'.$originalExtension : ''), 301);
            }
        }
        // Select an entity with its properties
        $lang = $searchResult->lang;
        App::setLocale($lang);
        $modelClassName = "App\\Models\\" . ucfirst($searchResult->entity_model);
        $entity = $modelClassName::select("*")
            ->where("id", $searchResult->entity_id)
            ->appendProperties()
            ->appendContents('*', $lang)
            ->appendRoute($lang)
            ->appendMedium('social')
            ->with('entities_related')
            ->with('routes');
        $entity=$entity->first();
        if (!$entity->isPublished()) {
            $controller = new HtmlController();
            return ($controller->error($request, 404));
        }
        $request->request->add(['lang' => $lang]);
        $model_name = $entity->model;
        $controllerClassName = "App\\Http\\Controllers\\" . ucfirst($format) . 'Controller';
        if(!class_exists($controllerClassName)) {
            $controller = new HtmlController;
            return ($controller->error($request, 404));
        }
        $controller = new $controllerClassName;
        if (method_exists($controller, $model_name)) {
            $view = $controller->$model_name($request, $entity, $lang);
            // $render = $view->render();
            // Storage::disk('html_processed')->put($request->getPathInfo() . ($isDirectory ? '/index.html' : ''), $render);
            return $view;
        } else {
            return ($controller->error($request, 501));
        }
    }
}

<?php

namespace Kusikusi\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class CmsController extends Controller
{

    /**
     * @api {get} apapi/cms/config Get the CMS configuration.
     * @apiDescription Returns an object with the configuration for the CMS frontend.
     * @apiGroup Cms 
     * 
     * @apiParamExample Example Request (JavaScript):
     *   const url = new URL(
     *       "http://127.0.0.1:8000/api/cms/config"
     *   );
     *   let headers = {
     *       "Content-Type": "application/json",
     *       "Accept": "application/json",
     *   };
     *   fetch(url, {
     *       method: "GET",
     *       headers: headers,
     *   })
     *       .then(response => response.json())
     *       .then(json => console.log(json));
     * @apiParamExample Example Request (PHP):
     *   $client = new \GuzzleHttp\Client();
     *   $response = $client->get(
     *       'http://127.0.0.1:8000/api/cms/config',
     *       [
     *           'headers' => [
     *               'Content-Type' => 'application/json',
     *               'Accept' => 'application/json',
     *           ],
     *       ]
     *   );
     *   $body = $response->getBody();
     *   print_r(json_decode((string) $body));
     * @apiSuccessExample {json} Response (example):
     *   {
     *       "langs": [
     *           "en_US",
     *           "es_ES"
     *       ],
     *       "page_size": 25,
     *       "token_expiration_in_seconds": 0,
     *       "short_id_length": 10,
     *       "models": {
     *           "home": {
     *               "icon": "home",
     *               "name": "models.home",
     *               "views": [
     *                   "home",
     *                   "home2"
     *               ],
     *               "form": [
     *                   {
     *                       "label": "contents.contents",
     *                       "components": [
     *                           {
     *                               "component": "nq-input",
     *                               "value": "contents.title",
     *                               "label": "contents.title",
     *                               "props": {
     *                                   "size": "xl"
     *                               }
     *                           },
     *                           {
     *                               "component": "html-editor",
     *                               "value": "contents.welcome",
     *                               "label": "contents.summary",
     *                               "props": {
     *                                   "type": "textarea"
     *                               }
     *                           },
     *                           {
     *                               "component": "slug",
     *                               "value": "contents.slug",
     *                               "label": "contents.slug"
     *                           },
     *                           {
     *                               "component": "nq-input",
     *                               "value": "view",
     *                               "label": "Vista"
     *                           }
     *                       ]
     *                   },
     *                   {
     *                       "label": "contents.children",
     *                       "components": [
     *                           {
     *                               "component": "children",
     *                               "props": {
     *                                   "models": [
     *                                       "section",
     *                                       "page"
     *                                   ],
     *                                   "order_by": "contents.title",
     *                                   "tags": [
     *                                       "menu",
     *                                       "footer"
     *                                   ]
     *                               }
     *                           }
     *                       ]
     *                   },
     *                   {
     *                       "label": "contents.media",
     *                       "components": [
     *                           {
     *                               "component": "media",
     *                               "props": {
     *                                   "allowed": [
     *                                       "*"
     *                                   ],
     *                                   "tags": [
     *                                       "hero",
     *                                       "og"
     *                                   ]
     *                               }
     *                           }
     *                       ]
     *                   }
     *               ]
     *           },
     *           "page": {
     *               "icon": "description",
     *               "name": "models.page",
     *               "form": [
     *                   {
     *                       "label": "contents.contents",
     *                       "components": [
     *                           {
     *                               "component": "nq-input",
     *                               "value": "contents.title",
     *                               "label": "contents.title"
     *                           },
     *                           {
     *                               "component": "nq-input",
     *                               "value": "contents.welcome",
     *                               "label": "content.summary"
     *                           },
     *                           {
     *                               "component": "slug",
     *                               "value": "contents.slug",
     *                               "label": "contents.slug"
     *                           }
     *                       ]
     *                   },
     *                   {
     *                       "label": "contents.media",
     *                       "components": [
     *                           {
     *                               "component": "media",
     *                               "props": {
     *                                   "allowed": [
     *                                       "webImages",
     *                                       "webVideos",
     *                                       "xhr"
     *                                   ],
     *                                   "tags": [
     *                                       "icon",
     *                                       "gallery"
     *                                   ]
     *                               }
     *                           }
     *                       ]
     *                   }
     *               ]
     *           },
     *           "section": {
     *               "icon": "folder",
     *               "name": "models.section",
     *               "form": [
     *                   {
     *                       "label": "contents.contents",
     *                       "components": [
     *                           {
     *                               "component": "nq-input",
     *                               "value": "contents.title",
     *                               "label": "contents.title"
     *                           },
     *                           {
     *                               "component": "nq-input",
     *                               "value": "contents.summary",
     *                               "label": "contents.summary"
     *                           },
     *                           {
     *                               "component": "nq-input",
     *                               "value": "contents.slug",
     *                               "label": "contents.slug"
     *                           }
     *                       ]
     *                   },
     *                   {
     *                       "label": "contents.children",
     *                       "components": [
     *                           {
     *                               "component": "children",
     *                               "props": {
     *                                   "models": [
     *                                       "page"
     *                                   ]
     *                               }
     *                           }
     *                       ]
     *                   }
     *               ]
     *           },
     *           "medium": {
     *               "icon": "insert_drive_file",
     *               "name": "models.medium",
     *               "form": [
     *                   {
     *                       "label": "contents.contents",
     *                       "components": [
     *                           {
     *                               "component": "nq-input",
     *                               "value": "contents.title",
     *                               "label": "contents.title"
     *                           }
     *                       ]
     *                   }
     *               ]
     *           }
     *       },
     *       "formats": {
     *           "webImages": [
     *               "jpeg",
     *               "jpg",
     *               "png",
     *               "gif"
     *           ],
     *           "images": [
     *               "jpeg",
     *               "jpg",
     *               "png",
     *               "gif",
     *               "tif",
     *               "tiff",
     *               "iff",
     *               "bmp",
     *               "psd"
     *           ],
     *           "audios": [
     *               "mp3",
     *               "wav",
     *               "aiff",
     *               "aac",
     *               "oga",
     *               "pcm",
     *               "flac"
     *           ],
     *           "webAudios": [
     *               "mp3",
     *               "oga"
     *           ],
     *           "videos": [
     *               "mov",
     *               "mp4",
     *               "qt",
     *               "avi",
     *               "mpe",
     *               "mpeg",
     *               "ogg",
     *               "m4p",
     *               "m4v",
     *               "flv",
     *               "wmv"
     *           ],
     *           "webVideos": [
     *               "webm",
     *               "mp4",
     *               "ogg",
     *               "m4p",
     *               "m4v"
     *           ],
     *           "documents": [
     *               "doc",
     *               "docx",
     *               "xls",
     *               "xlsx",
     *               "ppt",
     *               "pptx",
     *               "pdf",
     *               "htm",
     *               "html",
     *               "txt",
     *               "rtf",
     *               "csv",
     *               "pps",
     *               "ppsx",
     *               "odf",
     *               "key",
     *               "pages",
     *               "numbers"
     *           ]
     *       }
     *   }
     */
    public function showConfig(Request $request)
    {
        $cms = Config::get('cms', ["error" => "Configuration could not be loaded"]);
        $formats = Config::get('media.formats', []);
        return array_merge($cms, [ "formats" => $formats]);
    }
}

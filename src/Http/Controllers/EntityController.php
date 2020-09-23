<?php

namespace Kusikusi\Http\Controllers;

use Kusikusi\Models\EntityModel;
use App\Models\Medium;
use Kusikusi\Models\EntityRelation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Kusikusi\Models\WebsiteModel;

class EntityController extends Controller
{
    const ID_RULE = 'string|min:1|max:16|regex:/^[A-Za-z0-9_-]+$/';
    const ID_RULE_WITH_FILTER = 'string|min:1|max:40|regex:/^[A-Za-z0-9_-]+:?[a-z0-9]*$/';
    const MODEL_RULE = 'string|min:1|max:32|regex:/^[a-z0-9-]+$/';
    const TIMEZONED_DATE = 'nullable|date_format:Y-m-d\TH:i:sP|after_or_equal:1000-01-01T00:00:00-12:00|before_or_equal:9999-12-31T23:59:59-12:00';
    private $calledRelations = [];
    private $addedSelects = [];
    /**
     * @api {get} api/entities[/{model_name}] Get a collection of  entities.
     * @apiPermission Requires Authentication
     * @apiDescription Returns a paginated collection of entities, filtered by all set conditions.
     * @apiGroup Entity
     * 
     * @apiParam (URL Parameters) [model_name] If a model name is provided, the results will have the corresponding scope and special defined relations and accesosrs will be available.
     * @apiParam [select] A comma separated list of fields of the entity to include. It is possible to flat the properties json column using a dot syntax. Example: id,model,properties.price
     * @apiParam [order-by] A comma separated lis of fields to order by. Example: model,properties.price:desc,contents.title
     * @apiParam [of-model] (filter) The name of the model the entities should be. Example: page
     * @apiParam [only-published] (filter) Get only published, not deleted entities, true if not set. Example: true
     * @apiParam [child-of] (filter) The id or short id of the entity the result entities should be child of. Example: home
     * @apiParam [parent-of] (filter) The id or short id of the entity the result entities should be parent of (will return only one). Example: 8fguTpt5SB
     * @apiParam [ancestor-of] (filter) The id or short id of the entity the result entities should be ancestor of. Example: enKSUfUcZN
     * @apiParam [descendant-of] (filter) The id or short id of the entity the result entities should be descendant of. Example: xAaqz2RPyf
     * @apiParam [siblings-of] (filter) The id or short id of the entity the result entities should be siblings of. Example: _tuKwVy8Aa
     * @apiParam [related-by] (filter) The id or short id of the entity the result entities should have been called by using a relation. Can be added a filter to a kind of relation for example: theShortId:category. The ancestor kind of relations are discarted unless are explicity specified. Example: ElFYpgEvWS
     * @apiParam [relating] (filter) The id or short id of the entity the result entities should have been a caller of using a relation. Can be added a filder to a kind o relation for example: shortFotoId:medium to know the entities has caller that medium. The ancestor kind of relations are discarted unless are explicity specified. Example: enKSUfUcZN
     * @apiParam [media-of] (filter) The id or short id of the entity the result entities should have a media relation to. Example: enKSUfUcZN
     * @apiParam [with] A comma separated list of relationships should be included in the result. Example: media,contents,entities_related, entities_related.contents (nested relations)
     * @apiParam [per-page] The amount of entities per page the result should be the amount of entities on a single page. Example: 6
     * 
     * @apiParamExample Example Request (JavaScript):
     *  const url = new URL(
     *       "http://127.0.0.1:8000/api/entities[/expedita]"
     *   );
     *   let params = {
     *       "select": "id,model,properties.price",
     *       "order-by": "model,properties.price:desc,contents.title",
     *       "of-model": "page",
     *       "only-published": "true",
     *       "child-of": "home",
     *       "parent-of": "8fguTpt5SB",
     *       "ancestor-of": "enKSUfUcZN",
     *       "descendant-of": "xAaqz2RPyf",
     *       "siblings-of": "_tuKwVy8Aa",
     *       "related-by": "ElFYpgEvWS",
     *       "relating": "enKSUfUcZN",
     *       "media-of": "enKSUfUcZN",
     *       "with": "media,contents,entities_related, entities_related.contents (nested relations)",
     *       "per-page": "6",
     *   };
     *   Object.keys(params)
     *       .forEach(key => url.searchParams.append(key, params[key]));
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
     *     'http://127.0.0.1:8000/api/entities[/expedita]',
     *      [
     *          headers' => [
     *               'Content-Type' => 'application/json',
     *               'Accept' => 'application/json',
     *           ],
     *           'query' => [
     *               'select'=> 'id,model,properties.price',
     *               'order-by'=> 'model,properties.price:desc,contents.title',
     *               'of-model'=> 'page',
     *               'only-published'=> 'true',
     *               'child-of'=> 'home',
     *               'parent-of'=> '8fguTpt5SB',
     *               'ancestor-of'=> 'enKSUfUcZN',
     *               'descendant-of'=> 'xAaqz2RPyf',
     *               'siblings-of'=> '_tuKwVy8Aa',
     *               'related-by'=> 'ElFYpgEvWS',
     *               'relating'=> 'enKSUfUcZN',
     *               'media-of'=> 'enKSUfUcZN',
     *               'with'=> 'media,contents,entities_related, entities_related.contents (nested relations)',
     *               'per-page'=> '6',
     *           ],
     *       ]
     *   );
     *   $body = $response->getBody();
     *   print_r(json_decode((string) $body));
     * @apiSuccessExample {json} Response (example):
     *     {
     *       "current_page": 1,
     *       "data": [
     *          {
     *               "id": "35337182-7a0c-44c4-a11f-68cd9da930b2",
     *               "content": {
     *                   "body": {
     *                       "en_US": "Consequatur tempora deleniti ea cum totam. Qui quidem quis eius expedita atque officia incidunt."
     *                   },
     *                   "slug": {
     *                       "en_US": "mrs-karlie-torp"
     *                   },
     *                   "title": {
     *                       "en_US": "Felipa Haley PhD"
     *                   },
     *                   "summary": {
     *                       "en_US": "Railroad Inspector"
     *                   }
     *               },
     *               "model": "page",
     *               "kind": "ancestor",
     *              "position": 0,
     *               "depth": 1,
     *               "tags": null
     *           },
     *           {
     *               "id": "4cbbd1cd-3708-4ac2-8ff7-7261cd6fbe81",
     *               "content": {
     *                   "body": {
     *                       "en_US": "Voluptatem sed autem voluptas eum fuga amet neque. Odit accusantium nemo et architecto."
     *                   },
     *                   "slug": {
     *                       "en_US": "amely-koepp"
     *                   },
     *                   "title": {
     *                       "en_US": "Ashley D'Amore"
     *                   },
     *                   "summary": {
     *                       "en_US": "Homeland Security"
     *                   }
     *               },
     *               "model": "page",
     *               "kind": "ancestor",
     *               "position": 0,
     *               "depth": 1,
     *               "tags": null
     *           },
     *           {
     *               "id": "6d776ddf-b416-42c7-86cf-c665770c96ff",
     *               "content": {
     *                   "body": {
     *                       "en_US": "Error animi autem sunt et. Qui quia eos sunt sint dicta eligendi quasi. Ut quae aut facilis vel."
     *                   },
     *                   "slug": {
     *                       "en_US": "janis-jenkins-jr"
     *                   },
     *                   "title": {
     *                       "en_US": "Mr. Reagan Deckow I"
     *                   },
     *                   "summary": {
     *                       "en_US": "Pesticide Sprayer"
     *                   }
     *               },
     *               "model": "page",
     *               "kind": "ancestor",
     *               "position": 0,
     *               "depth": 1,
     *               "tags": null
     *           },
     *           {
     *               "id": "7d504be2-ca0f-4836-b6d2-f00c2dff209c",
     *               "content": {
     *                   "body": {
     *                       "en_US": "Consequatur deserunt non quo sint. Voluptas sint et aliquam qui."
     *                   },
     *                   "slug": {
     *                       "en_US": "mr-xavier-yundt-iv"
     *                   },
     *                   "title": {
     *                       "en_US": "Joyce Kohler MD"
     *                   },
     *                   "summary": {
     *                       "en_US": "Transportation Equipment Maintenance"
     *                   }
     *               },
     *               "model": "page",
     *               "kind": "ancestor",
     *               "position": 0,
     *               "depth": 1,
     *               "tags": null
     *           },
     *           {
     *               "id": "801892f7-8dcb-4fdc-a1fd-5251ceb6af09",
     *               "content": {
     *                   "body": {
     *                       "en_US": "Assumenda quaerat ipsam dolores ducimus itaque earum sit. Aut dolorem nisi et harum sunt molestiae."
     *                   },
     *                   "slug": {
     *                       "en_US": "ms-lauretta-rohan"
     *                   },
     *                   "title": {
     *                       "en_US": "Dr. Briana Bergstrom DVM"
     *                   },
     *                   "summary": {
     *                       "en_US": "Hotel Desk Clerk"
     *                   }
     *              },
     *               "model": "page",
     *               "kind": "ancestor",
     *               "position": 0,
     *               "depth": 1,
     *               "tags": null
     *           }
     *       ],
     *       "first_page_url": "http:\/\/127.0.0.1:8000\/api\/entities?relating=bee7a88a-459c-419a-9b3f-96ad3d3822b5%3Aancestor&page=1",
     *       "from": 1,
     *       "last_page": 1,
     *       "last_page_url": "http:\/\/127.0.0.1:8000\/api\/entities?relating=bee7a88a-459c-419a-9b3f-96ad3d3822b5%3Aancestor&page=1",
     *       "next_page_url": null,
     *       "path": "http:\/\/127.0.0.1:8000\/api\/entities",
     *       "per_page": 100,
     *       "prev_page_url": null,
     *       "to": 5,
     *       "total": 5
     *   }
     * 
     */
    public function index(Request $request, $model_name = null)
    {
        $this->validate($request, $this->queryParamsValidation());
        if ($model_name) {
            $modelClassName = "App\\Models\\".Str::studly(Str::singular($model_name));
            $entities = $modelClassName::query();
        } else {
            $modelClassName = "Kusikusi\\Models\\EntityModel";
            $entities = EntityModel::query();
        }
        $lang = $request->get('lang') ?? Config::get('cms.langs')[0] ?? '';
        // Add selects
        $entities = $this->addSelects($entities, $request, $lang, $modelClassName);
        // Add relations
        $entities = $this->addRelations($entities, $request);
        // Orders by
        $entities = $entities->when($request->get('order-by'), function ($q) use ($request) {
            $orders = explode(",", $request->get('order-by'));
            foreach ($orders as $order) {
                $parts = explode(":", last(explode(".", $order)));
                if (isset($parts[1])) {
                    return $q->orderBy($parts[0], $parts[1] === 'desc' ? $parts[1] : 'asc');
                } else {
                    return $q->orderBy($parts[0]);
                }
            }
        });
        // Filters
        $entities = $entities->when($request->get('of-model'), function ($q) use ($request) {
            return $q->ofModel($request->get('of-model'));
        })
            ->when($request->exists('only-published') && ($request->get('only-published') === 'true' || $request->get('only-published') === ''), function ($q) use ($request) {
                return $q->isPublished();
            })
            ->when($request->get('child-of'), function ($q) use ($request) {
                return $q->childOf($request->get('child-of'));
            })
            ->when($request->get('parent-of'), function ($q) use ($request) {
                return $q->parentOf($request->get('parent-of'));
            })
            ->when($request->get('ancestor-of'), function ($q) use ($request) {
                return $q->ancestorOf($request->get('ancestor-of'));
            })
            ->when($request->get('descendant-of'), function ($q) use ($request) {
                return $q->descendantOf($request->get('descendant-of'));
            })
            ->when($request->get('siblings-of'), function ($q) use ($request) {
                return $q->siblingsOf($request->get('siblings-of'));
            })
            ->when($request->get('related-by'), function ($q) use ($request) {
                $values = explode(":", $request->get('related-by'));
                if (isset($values[1])) {
                    return $q->relatedBy($values[0], $values[1]);
                } else {
                    return $q->relatedBy($values[0]);
                }

            })
            ->when($request->get('relating'), function ($q) use ($request) {
                $values = explode(":", $request->get('relating'));
                if (isset($values[1])) {
                    return $q->relating($values[0], $values[1]);
                } else {
                    return $q->relating($values[0]);
                }

            })
            ->when($request->get('media-of'), function ($q) use ($request) {
                return $q->mediaOf($request->get('media-of'));
            });

        $entities = $entities->paginate($request->get('per-page') ? intval($request->get('per-page')) : Config::get('cms.page_size', 100))
            ->withQueryString();
        return $entities;
    }

    /**
     * @api {get} api/entity/{entity_id} Retrieve the entity for the given ID.
     * @apiPermission Requires Authentication
     * @apiGroup Entity
     * 
     * @apiParam (URL Parameters) [entity_id] The id of the entity to show.
     * @apiParam [select] A comma separated list of fields of the entity to include. It is possible to flat the properties json column using a dot syntax. Example: id,model,properties.price
     * @apiParam [with] A comma separated list of relationships should be included in the result. Example: media,contents,entities_related, entities_related.contents (nested relations)
     * 
     * @apiParamExample Example Request (JavaScript):
     * const url = new URL(
     *      "http://127.0.0.1:8000/api/entity/corporis"
     *   );
     *   let params = {
     *       "select": "id,model,properties.price",
     *       "with": "media,contents,entities_related, entities_related.contents (nested relations)",
     *   };
     *   Object.keys(params)
     *       .forEach(key => url.searchParams.append(key, params[key]));
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
     *       'http://127.0.0.1:8000/api/entity/corporis',
     *       [
     *           'headers' => [
     *               'Content-Type' => 'application/json',
     *               'Accept' => 'application/json',
     *           ],
     *           'query' => [
     *               'select'=> 'id,model,properties.price',
     *               'with'=> 'media,contents,entities_related, entities_related.contents (nested relations)',
     *           ],
     *       ]
     *   );
     *   $body = $response->getBody();
     *   print_r(json_decode((string) $body));
     * @apiSuccessExample {json} Response (example):
     *   {
     *       "id": "DkESBOv-wT",
     *       "model": "page-m",
     *       "properties": {
     *           "prop1": "Z",
     *           "prop2": "Z"
     *       },
     *       "view": "yuyxo",
     *       "parent_entity_id": "home",
     *       "is_active": true,
     *       "created_by": null,
     *       "updated_by": null,
     *       "published_at": "2020-08-27 14:55:30",
     *       "unpublished_at": "9999-12-31 23:59:59",
     *       "version": 18,
     *       "version_tree": 0,
     *       "version_relations": 9,
     *       "version_full": 27,
     *       "created_at": "2020-04-20T19:36:58.000000Z",
     *       "updated_at": "2020-04-20T20:25:19.000000Z",
     *       "deleted_at": null
     *   }
     */
    public function show(Request $request, $entity_id)
    {
        $validator = Validator::make(get_defined_vars(),
            ['entity_id' => self::ID_RULE.'|exists:entities,id']
        );
        if ($validator->fails()) {
            return $validator->errors();
        }
        $entityFound = EntityModel::select('id', 'model')
            ->where('id', $entity_id)
            ->firstOrFail();
        $modelClassName = "App\\Models\\".Str::studly(Str::singular($entityFound->model));
        if(!class_exists('$modelClassName')) {
            $modelClassName = "Kusikusi\\Models\\EntityModel";
        }
        $entity = $modelClassName::select('id');
        $lang = $request->get('lang') ?? Config::get('cms.langs')[0] ?? '';
        $entity = $this->addSelects($entity, $request, $lang, $modelClassName);
        $entity = $this->addRelations($entity, $request);
        return $entity->findOrFail($entityFound->id);;
    }

    /**
     * 
     * @api {post} api/entity Creates a new entity.
     * @apiPermission Requires Authentication
     * @apiGroup Entity
     *
     * @apiParam {string} model required The model name. Example: page.
     * @apiParam {string} [view] The name of the view to use. Default: the same name of the model. Example: page
     * @apiParam {date} [published_at] A date time the entity should be published. Default: current date time. Example: 2020-02-02 12:00:00.
     * @apiParam {date} [unpublished_at] A date time the entity should be published. Default: 9999-12-31 23:59:59. Example: 2020-02-02 12:00:00.
     * @apiParam {string} [properties] An object with properties. Example: {"price": 200, "format": "jpg"}
     * @apiParam {string} [id] You can set your own ID, a maximum of 16, safe characters: A-Z, a-z, 0-9, _ and -. Default: autogenerated. Example: home
     * @apiParam {array} [contents] An array of contents to be created for the entity. Example: { "title": {"en_US": "The page M", "es_ES": "La página M"}, "slug": {"en_US": "page-m", "es_ES": "pagina-m"}}
     * @apiParam {array} [relations] An array of relations to be created for the entity. Example: "relations": [{"called_entity_id": "mf4gWE45pm","kind": "category","position": 2, "tags":["main"]}]
     * 
     * @apiParamExample Example Request (JavaScript):
     * const url = new URL(
     *       "http://127.0.0.1:8000/api/entity"
     *   );
     *   let headers = {
     *       "Content-Type": "application/json",
     *       "Accept": "application/json",
     *   };
     *   let body = {
     *       "model": "page.",
     *       "view": "page",
     *       "published_at": "2020-02-02 12:00:00.",
     *       "unpublished_at": "2020-02-02 12:00:00.",
     *       "properties": "{\"price\": 200, \"format\": \"jpg\"}",
     *       "id": "home",
     *       "contents": "{ \"title\": {\"en_US\": \"The page M\", \"es_ES\": \"La p\u00e1gina M\"}, \"slug\": {\"en_US\": \"page-m\", \"es_ES\": \"pagina-m\"}}",
     *       "relations": "\"relations\": [{\"called_entity_id\": \"mf4gWE45pm\",\"kind\": \"category\",\"position\": 2, \"tags\":[\"main\"]}]"
     *   }
     *   fetch(url, {
     *       method: "POST",
     *       headers: headers,
     *       body: body
     *   })
     *       .then(response => response.json())
     *       .then(json => console.log(json));
     * @apiParamExample Example Request (PHP):
     * $client = new \GuzzleHttp\Client();
     * $response = $client->post(
     *       'http://127.0.0.1:8000/api/entity',
     *       [
     *           'headers' => [
     *               'Content-Type' => 'application/json',
     *               'Accept' => 'application/json',
     *           ],
     *           'json' => [
     *               'model' => 'page.',
     *               'view' => 'page',
     *               'published_at' => '2020-02-02 12:00:00.',
     *               'unpublished_at' => '2020-02-02 12:00:00.',
     *               'properties' => '{"price": 200, "format": "jpg"}',
     *               'id' => 'home',
     *               'contents' => '{ "title": {"en_US": "The page M", "es_ES": "La página M"}, "slug": {"en_US": "page-m", "es_ES": "pagina-m"}}',
     *               'relations' => '"relations": [{"called_entity_id": "mf4gWE45pm","kind": "category","position": 2, "tags":["main"]}]',
     *           ],
     *       ]
     *   );
     * $body = $response->getBody();
     * print_r(json_decode((string) $body));
     * @apiSuccessExample {json} Response (example):
     * {
     *       "model": "page-m",
     *       "view": "page",
     *       "parent_entity_id": "home",
     *       "published_at": "2020-08-27T14:55:30",
     *       "properties": {
     *           "prop1": "b",
     *           "prop2": 1
     *       },
     *       "id": "DkESBOv-wT",
     *       "updated_at": "2020-04-20T19:36:58.000000Z",
     *       "created_at": "2020-04-20T19:36:58.000000Z"
     *   } 
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'model' => 'required|string|max:32',
            'view' => 'string|max:32',
            'id' => self::ID_RULE,
            'published_at' => self::TIMEZONED_DATE,
            'unpublished_at' => self::TIMEZONED_DATE,
            'is_active' => 'boolean'
        ]);
        $payload = $request->only('id', 'model', 'view', 'parent_entity_id', 'published_at', 'unpublished_at', 'properties', 'contents', 'entities_related', 'is_active');
        $modelClassName = "App\\Models\\".Str::studly(Str::singular($payload['model']));

        $entity = new $modelClassName($payload);
        $entity->save();
        switch ($entity->getCacheClearPolicy()) {
            case EntityModel::CACHE_POLICY_WEBSITE:
                WebsiteModel::clearStatic();
                break;
        }
        $createdEntity = EntityModel::with('contents')->find($entity->id);
        return($createdEntity);
    }

    /**
     * @api {post} api/entity/{caller_entity_id}/create_and_relate Creates a new entity with a relation.
     * @apiPermission Requires Authentication
     * @apiDescription Creates a new entity with a specific relation to another entity, the entity "id" and "caller_entity_id" should the same.
     * @apiGroup Entity
     *
     * @apiParam (URL Parameters) entity_caller_id required, The id of the entity to create or update a relation
     * @apiParam {string} model required, The model name. Example: home
     * @apiParam {string} kind required, The kind of relation to create or update. Example: medium | category
     * @apiParam {string} [view] The name of the view to use. Default: the same name of the model. Example: home
     * @apiParam {date} [published_at] A date time the entity should be published. Default: current date time. Example: 2020-02-02 12:00:00.
     * @apiParam {date} [unpublished_at] A date time the entity should be published. Default: 9999-12-31 23:59:59. Example: 2020-02-02 12:00:00.
     * @apiParam {string} [properties] An object with properties. Example: {"price": 200, "format": "jpg"}
     * @apiParam {array} [contents] An array of contents to be created for the entity. Example: { "title": {"en_US": "The page M", "es_ES": "La página M"}, "slug": {"en_US": "page-m", "es_ES": "pagina-m"}}
     * @apiParam {array} [relations] An array of relations to be created for the entity. Example: "relations": [{"called_entity_id": "mf4gWE45pm","kind": "category","position": 2, "tags":["main"]}]
     * @apiParam {array} [tags] An array of tags to add to the relation. Defaults to an empty array. Example: ["1", '2"].
     * @apiParam {integer} [position] The position of the relation. Example: 3.
     * @apiParam {integer} [depth] Yet another number value to use freely for the relation, used in ancestor type of relation to define the distance between an entity and other in the tree. Example 1.
     * 
     * @apiParamExample Example Request (JavaScript):
     * const url = new URL(
     *       "http://127.0.0.1:8000/api/entity/1/create_and_relate"
     *   );
     *   let headers = {
     *       "Content-Type": "application/json",
     *       "Accept": "application/json",
     *   };
     *   let body = {
     *       "model": "home",
     *       "kind": "medium | category",
     *       "view": "home",
     *       "published_at": "2020-02-02 12:00:00.",
     *       "unpublished_at": "2020-02-02 12:00:00.",
     *       "properties": "{\"price\": 200, \"format\": \"jpg\"}",
     *       "contents": "{ \"title\": {\"en_US\": \"The page M\", \"es_ES\": \"La p\u00e1gina M\"}, \"slug\": {\"en_US\": \"page-m\", \"es_ES\": \"pagina-m\"}}",
     *       "relations": "\"relations\": [{\"called_entity_id\": \"mf4gWE45pm\",\"kind\": \"category\",\"position\": 2, \"tags\":[\"main\"]}]",
     *       "tags": "[\"1\", '2\"].",
     *       "position": 3,
     *       "depth": 3
     *   }
     *   fetch(url, {
     *       method: "POST",
     *       headers: headers,
     *       body: body
     *   })
     *       .then(response => response.json())
     *       .then(json => console.log(json));
     * @apiParamExample Example Request (PHP):
     * $client = new \GuzzleHttp\Client();
     *  $response = $client->post(
     *       'http://127.0.0.1:8000/api/entity/1/create_and_relate',
     *       [
     *           'headers' => [
     *               'Content-Type' => 'application/json',
     *               'Accept' => 'application/json',
     *           ],
     *           'json' => [
     *               'model' => 'home',
     *               'kind' => 'medium | category',
     *               'view' => 'home',
     *               'published_at' => '2020-02-02 12:00:00.',
     *               'unpublished_at' => '2020-02-02 12:00:00.',
     *               'properties' => '{"price": 200, "format": "jpg"}',
     *               'contents' => '{ "title": {"en_US": "The page M", "es_ES": "La página M"}, "slug": {"en_US": "page-m", "es_ES": "pagina-m"}}',
     *               'relations' => '"relations": [{"called_entity_id": "mf4gWE45pm","kind": "category","position": 2, "tags":["main"]}]',
     *               'tags' => '["1", \'2"].',
     *               'position' => 3,
     *               'depth' => 3,
     *           ],
     *       ]
     *   );
     *   $body = $response->getBody();
     *   print_r(json_decode((string) $body));
     * @apiSuccessExample {json} Response (example):
     * {
     *       "id": "tEQxMPF8hs",
     *       "model": "medium",
     *       "properties": [],
     *       "view": "medium",
     *       "parent_entity_id": null,
     *       "is_active": true,
     *       "created_by": null,
     *       "updated_by": null,
     *       "published_at": "2020-05-09T00:17:54+00:00",
     *       "unpublished_at": null,
     *       "version": 1,
     *       "version_tree": 0,
     *       "version_relations": 0,
     *       "version_full": 1,
     *       "created_at": "2020-05-09T00:17:54+00:00",
     *       "updated_at": "2020-05-09T00:17:54+00:00",
     *       "deleted_at": null,
     *       "thumb": "\/media\/tEQxMPF8hs\/thumb\/media.jpg",
     *       "preview": "\/media\/tEQxMPF8hs\/preview\/media.jpg",
     *       "entities_relating": [
     *           {
     *               "id": "4dnK2CJspO",
     *               "model": "page",
     *               "properties": {
     *                   "exif": {
     *                       "COMPUTED": {
     *                           "html": "width=\"1280\" height=\"1102\"",
     *                           "Width": 1280,
     *                           "Height": 1102,
     *                           "IsColor": 1
     *                       },
     *                       "FileName": "phpovyCKl",
     *                       "FileSize": 82033,
     *                       "FileType": 2,
     *                       "MimeType": "image\/jpeg",
     *                       "FileDateTime": 1588959027,
     *                       "SectionsFound": ""
     *                   },
     *                   "size": 82033,
     *                   "type": "image",
     *                   "prop1": "Z",
     *                   "prop2": "Z",
     *                   "width": 1280,
     *                   "format": "jpg",
     *                   "height": 1102,
     *                   "isAudio": false,
     *                   "isImage": true,
     *                   "isVideo": false,
     *                   "mimeType": "image\/jpeg",
     *                   "isDocument": false,
     *                   "isWebAudio": false,
     *                   "isWebImage": true,
     *                   "isWebVideo": false,
     *                   "originalName": "3evient.jpeg"
     *               },
     *               "view": "yuyxo",
     *               "parent_entity_id": "0qtTYPQhm4",
     *               "is_active": true,
     *               "created_by": null,
     *               "updated_by": null,
     *               "published_at": "2020-05-07T12:50:49+00:00",
     *               "unpublished_at": null,
     *               "version": 67,
     *               "version_tree": 0,
     *               "version_relations": 46,
     *               "version_full": 113,
     *               "created_at": "2020-05-07T12:50:49+00:00",
     *               "updated_at": "2020-05-08T17:31:54+00:00",
     *               "deleted_at": null,
     *               "relation": {
     *                   "called_entity_id": "tEQxMPF8hs",
     *                   "caller_entity_id": "4dnK2CJspO",
     *                   "kind": "medium",
     *                   "position": 41,
     *                   "depth": 0,
     *                   "tags": []
     *               }
     *           }
     *       ]
     *   }
     */
    public function createAndAddRelation(Request $request, $caller_entity_id)
    {
        $this->validate($request, [
            'model' => 'required|string|max:32',
            'view' => 'string|max:32',
            'id' => self::ID_RULE,
            'published_at' => self::TIMEZONED_DATE,
            'unpublished_at' => self::TIMEZONED_DATE,
            'is_active' => 'boolean',
            'kind' => 'string|max:25|regex:/^[a-z0-9]+$/',
            'position' => 'integer',
            'tags.*' => 'string',
            'depth' => 'integer'
        ]);
        $validator = Validator::make(get_defined_vars(),
            ['caller_entity_id' => self::ID_RULE,
                'caller_entity_id' => 'exists:entities,id']);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $payload = $request->only('id','model', 'view', 'parent_entity_id', 'published_at', 'unpublished_at', 'properties', 'contents', 'entities_related', 'is_active');
        $entity = new EntityModel($payload);
        $entity->save();
        $relation_payload = $request->only('called_entity_id', 'kind', 'position', 'depth', 'tags');
        $relation_payload['caller_entity_id'] = $caller_entity_id;
        $relation_payload['called_entity_id'] = $entity->id;
        EntityModel::createRelation($relation_payload);
        if ($payload['model']) {
            $modelClassName = "App\\Models\\".Str::studly(Str::singular($payload['model']));
            $createdEntity = $modelClassName::select('*')->appendContents('title')->with('entities_relating')->find($entity->id);
        } else {
            $createdEntity = EntityModel::select('*')->appendContents('title')->with('entities_relating')->find($entity->id);

        }
        return($createdEntity);
    }

    /**
     * 
     * @api {patch} api/entity/{entity_id} Updates an entity.
     * @apiPermission Requires Authentication
     * @apiGroup Entity
     *
     * @apiParam (URL Parameters) [entity_id] The id of the entity to update
     * @apiParam {string}[ view] The name of the view to use. Default: the same name of the model. Example: page
     * @apiParam {date} [published_at] A date time the entity should be published. Default: current date time. Example: 2020-02-02 12:00:00.
     * @apiParam {date} [unpublished_at] A date time the entity should be published. Default: 9999-12-31 23:59:59. Example: 2020-02-02 12:00:00.
     * @apiParam {string} [properties] An object with properties. Example: {"price": 200, "format": "jpg"}
     * @apiParam {string} [id] You can set your own ID, a maximum of 16, safe characters: A-Z, a-z, 0-9, _ and -. Default: autogenerated. Example: home
     * @apiParam {array} [contents] An array of contents to be created for the entity. Example: { "title": {"en_US": "The page M", "es_ES": "La página M"}, "slug": {"en_US": "page-m", "es_ES": "pagina-m"}}
     * @apiParam {array} [relations] An array of relations to be created for the entity. Example: "relations": [{"called_entity_id": "mf4gWE45pm","kind": "category","position": 2, "tags":["main"]}]
     * 
     * @apiParamExample Example Request (JavaScript):
     * const url = new URL(
     *       "http://127.0.0.1:8000/api/entity/minus"
     *   );
     *   let headers = {
     *       "Content-Type": "application/json",
     *       "Accept": "application/json",
     *   };
     *   let body = {
     *       "view": "page",
     *       "published_at": "2020-02-02 12:00:00.",
     *       "unpublished_at": "2020-02-02 12:00:00.",
     *       "properties": "{\"price\": 200, \"format\": \"jpg\"}",
     *       "id": "home",
     *       "contents": "{ \"title\": {\"en_US\": \"The page M\", \"es_ES\": \"La p\u00e1gina M\"}, \"slug\": {\"en_US\": \"page-m\", \"es_ES\": \"pagina-m\"}}",
     *       "relations": "\"relations\": [{\"called_entity_id\": \"mf4gWE45pm\",\"kind\": \"category\",\"position\": 2, \"tags\":[\"main\"]}]"
     *   }
     *   fetch(url, {
     *       method: "PATCH",
     *       headers: headers,
     *       body: body
     *   })
     *       .then(response => response.json())
     *       .then(json => console.log(json));
     * @apiParamExample Example Request (PHP):
     * $client = new \GuzzleHttp\Client();
     * $response = $client->patch(
     *       'http://127.0.0.1:8000/api/entity/minus',
     *       [
     *           'headers' => [
     *               'Content-Type' => 'application/json',
     *               'Accept' => 'application/json',
     *           ],
     *           'json' => [
     *               'view' => 'page',
     *               'published_at' => '2020-02-02 12:00:00.',
     *               'unpublished_at' => '2020-02-02 12:00:00.',
     *               'properties' => '{"price": 200, "format": "jpg"}',
     *               'id' => 'home',
     *               'contents' => '{ "title": {"en_US": "The page M", "es_ES": "La página M"}, "slug": {"en_US": "page-m", "es_ES": "pagina-m"}}',
     *               'relations' => '"relations": [{"called_entity_id": "mf4gWE45pm","kind": "category","position": 2, "tags":["main"]}]',
     *           ],
     *       ]
     *   );
     *   $body = $response->getBody();
     *   print_r(json_decode((string) $body));
     * @apiSuccessExample {json} Response (example):
     * {
     *       "model": "page-m",
     *       "view": "page",
     *       "parent_entity_id": "home",
     *       "published_at": "2020-08-27T14:55:30",
     *       "properties": {
     *           "prop1": "b",
     *           "prop2": 1
     *       },
     *       "id": "DkESBOv-wT",
     *       "updated_at": "2020-04-20T19:36:58.000000Z",
     *       "created_at": "2020-04-20T19:36:58.000000Z"
     *   }
     */
    public function update(Request $request, $entity_id)
    {
        $this->validate($request, [
            'view' => 'string|max:32',
            'published_at' => self::TIMEZONED_DATE,
            'unpublished_at' => self::TIMEZONED_DATE,
            'is_active' => 'boolean'
        ]);
        $validator = Validator::make(get_defined_vars(),
            ['entity_id' => self::ID_RULE,
                'entity_id' => 'exists:entities,id']);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $payload = $request->only('id', 'model', 'view', 'parent_entity_id', 'published_at', 'unpublished_at', 'properties', 'contents', 'entities_related', 'is_active');
        if (isset($payload['model'])) {
            $modelClassName = "App\\Models\\".Str::studly(Str::singular($payload['model']));
            $entity = $modelClassName::find($entity_id);
        } else {
            $entity = EntityModel::find($entity_id);
        }
        $entity->fill($payload);
        $entity->save();
        switch ($entity->getCacheClearPolicy()) {
            case EntityModel::CACHE_POLICY_WEBSITE:
                WebsiteModel::clearStatic();
                break;
        }
        return($entity);
    }

    /**
     * @api {delete} api/entity/{entity_id} Deletes an entity.
     * @apiPermission Requires Authentication
     * @apiGroup Entity
     *
     * @apiParam (URL Parameters) [entity_id] The id of the entity to delete
     * 
     * @apiParamExample Example Request (JavaScript):
     * const url = new URL(
     *       "http://127.0.0.1:8000/api/entity/totam"
     *   );
     *   let headers = {
     *       "Content-Type": "application/json",
     *       "Accept": "application/json",
     *   };
     *   fetch(url, {
     *       method: "DELETE",
     *       headers: headers,
     *   })
     *       .then(response => response.json())
     *       .then(json => console.log(json));
     * @apiParamExample Example Request (PHP):
     * $client = new \GuzzleHttp\Client();
     *   $response = $client->delete(
     *       'http://127.0.0.1:8000/api/entity/totam',
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
     * {
     *       "id": "NiCJ5xKaIy",
     *       "deleted_at": "2020-04-20T21:19:27.000000Z"
     *   }
     */
    public function delete(Request $request, $entity_id)
    {
        $validator = Validator::make(get_defined_vars(),
            ['entity_id' => self::ID_RULE]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        EntityModel::where('id', $entity_id)->delete();
        $entity = EntityModel::select('id', 'deleted_at')->withTrashed()->find($entity_id);
        if ( $entity) {
            $entity->makeVisible('deleted_at');
        }
        return($entity);
    }

    /**
     * @api {post} api/entity/{caller_entity_id}/relation Creates or updates a relation.
     * @apiPermission Requires Authentication
     * @apiGroup Entity
     *
     * @apiParam (URL Parameters) entity_caller_id required, The id of the entity to create or update a relation
     * @apiParam {string} entity_called_id required, The id of the entity to relate. Example: s4FG56mkdRT5
     * @apiParam {string} kind required, The kind of relation to create or update. Example: medium | category
     * @apiParam {array} [tags] An array of tags to add to the relation. Defaults to an empty array. Example ["icon", 'gallery"].
     * @apiParam {integer} [position] The position of the relation. Example: 3.
     * @apiParam {integer} [depth] Yet another number value to use freely for the relation, used in ancestor type of relation to define the distance between an entity and other in the tree. Example 1.
     * 
     * @apiParamExample Example Request (JavaScript):
     * const url = new URL(
     *       "http://127.0.0.1:8000/api/entity/1/relation"
     *   );
     *   let headers = {
     *       "Content-Type": "application/json",
     *       "Accept": "application/json",
     *   };
     *   let body = {
     *       "entity_called_id": "s4FG56mkdRT5",
     *       "kind": "medium | category",
     *       "tags": [],
     *       "position": 3,
     *       "depth": 13
     *   }
     *   fetch(url, {
     *       method: "POST",
     *       headers: headers,
     *       body: body
     *   })
     *       .then(response => response.json())
     *       .then(json => console.log(json));
     * @apiParamExample Example Request (PHP):
     * $client = new \GuzzleHttp\Client();
     * $response = $client->post(
     *       'http://127.0.0.1:8000/api/entity/1/relation',
     *       [
     *           'headers' => [
     *               'Content-Type' => 'application/json',
     *               'Accept' => 'application/json',
     *           ],
     *           'json' => [
     *               'entity_called_id' => 's4FG56mkdRT5',
     *               'kind' => 'medium | category',
     *               'tags' => [],
     *               'position' => 3,
     *               'depth' => 13,
     *           ],
     *       ]
     *   );
     *   $body = $response->getBody();
     *   print_r(json_decode((string) $body));
     * @apiSuccessExample {json} Response (example): 
     * {
     *       "relation_id": "WZ3PnzvNP4",
     *       "caller_entity_id": "Z4bdjFSzn5",
     *       "called_entity_id": "DtPatk4FNG",
     *       "kind": "reltest",
     *       "position": 2,
     *       "depth": 3,
     *       "tags": [
     *           "icon"
     *       ],
     *       "created_at": "2020-04-23T15:01:32.000000Z",
     *       "updated_at": "2020-04-23T15:10:14.000000Z"
     *   }
     */
    public function createRelation(Request $request, $caller_entity_id)
    {
        $this->validate($request, [
            'called_entity_id' => 'required|'.self::ID_RULE,
            'kind' => 'required|string|max:25|regex:/^[a-z0-9]+$/',
            'position' => 'integer',
            'tags.*' => 'string',
            'depth' => 'integer'
        ]);
        $validator = Validator::make(get_defined_vars(),
            [
                'caller_entity_id' => self::ID_RULE
            ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $payload = $request->only( 'called_entity_id', 'kind', 'position', 'depth', 'tags');
        $payload['caller_entity_id'] = $caller_entity_id;
        EntityModel::createRelation($payload);
        $relation = EntityRelation::where('caller_entity_id', $payload['caller_entity_id'])
            ->where('called_entity_id', $payload['called_entity_id'])
            ->where('kind', $payload['kind'])
            ->firstOrFail()
            ->makeVisible('caller_entity_id', 'called_entity_id', 'created_at', 'updated_at');
        return($relation);
    }

    /**
     * @api {delete} api/entity/{caller_entity_id}/relation/{called_entity_id}/{kind} Deletes a relation if exists.
     * @apiPermission Requires Authentication
     * @apiGroup Entity
     * 
     * @apiParam (URL Parameters) entity_caller_id required, The id of the entity to create or update a relation
     * @apiParam (URL Parameters) {string} entity_called_id required, The id of the entity to relate. Example: s4FG56mkdRT5
     * @apiParam (URL Parameters) {string} kind required, The kind of relation to create or update. Example: medium | category
     * 
     * @apiParamExample Example Request (JavaScript):
     *   const url = new URL(
     *       "http://127.0.0.1:8000/api/entity/1/relation/1/medium | category"
     *   );
     *   let headers = {
     *       "Content-Type": "application/json",
     *       "Accept": "application/json",
     *   };
     *   fetch(url, {
     *       method: "DELETE",
     *       headers: headers,
     *   })
     *       .then(response => response.json())
     *       .then(json => console.log(json));
     * @apiParamExample Example Request (PHP):
     *   $client = new \GuzzleHttp\Client();
     *   $response = $client->delete(
     *       'http://127.0.0.1:8000/api/entity/1/relation/1/medium | category',
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
     * {
     *       "relation_id": "673KBPT778"
     *   }
     */
    public function deleteRelation(Request $request, $caller_entity_id, $called_entity_id, $kind)
    {
        $validator = Validator::make(get_defined_vars(),
            [
                'caller_entity_id' => self::ID_RULE,
                'called_entity_id' => self::ID_RULE,
                'kind' => 'required|string|max:25'
            ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $relation = EntityRelation::where('caller_entity_id', $caller_entity_id)
            ->where('called_entity_id', $called_entity_id)
            ->where('kind', $kind)
            ->first();
        if ($relation) {
            $relation_id = $relation ? $relation->relation_id : null;
            EntityRelation::where('relation_id', $relation_id)->delete();
            return(["relation_id" => $relation_id]);
        } else {
            return(JsonResponse::create(["error" => "Relation not found"], 404));
        }
    }

    /**
     * @api {patch} api/entities/relations/reorder Reorders an array of relations.
     * @apiPermission Requires Authentication
     * @apiDescription Receive an array of relation ids, and sets the individual position to its index in the array.
     * @apiGroup Entity
     * 
     * @apiParam {array} relation_ids required, An array of relation ids to reorder. Example ['s4FG56mkdRT5', 'FG56mkdRT5s3', '4FG56mkdRT5d']
     * 
     * @apiParamExample Example Request (JavaScript):
     *   const url = new URL(
     *       "http://127.0.0.1:8000/api/entities/relations/reorder"
     *   );
     *   let headers = {
     *       "Content-Type": "application/json",
     *       "Accept": "application/json",
     *   };
     *   let body = {
     *       "relation_ids": []
     *   }
     *   fetch(url, {
     *       method: "PATCH",
     *       headers: headers,
     *       body: body
     *   })
     *       .then(response => response.json())
     *       .then(json => console.log(json));
     * @apiParamExample Example Request (PHP):
     *   $client = new \GuzzleHttp\Client();
     *   $response = $client->patch(
     *       'http://127.0.0.1:8000/api/entities/relations/reorder',
     *       [
     *           'headers' => [
     *               'Content-Type' => 'application/json',
     *               'Accept' => 'application/json',
     *           ],
     *           'json' => [
     *               'relation_ids' => [],
     *           ],
     *       ]
     *   );
     *   $body = $response->getBody();
     *   print_r(json_decode((string) $body));
     * @apiSuccessExample {json} Response (example):
     *   {
     *       "relations": [
     *           {
     *               "relation_id": "JvE3WPG504",
     *               "position": 1
     *           },
     *           {
     *               "relation_id": "izMhhYpXA7",
     *               "position": 2
     *           }
     *       ]
     *   }
     */
    public function reorderRelations(Request $request)
    {
        $this->validate($request, [
            'relation_ids' => 'required',
            'relation_ids.*' => self::ID_RULE
        ]);
        for ($r = 0; $r < count($request['relation_ids']); $r++) {
            EntityRelation::where('relation_id', $request['relation_ids'][$r])
                ->update(['position' => ($r + 1)]);
        }
        return(["relations" =>EntityRelation::select('relation_id', 'position')->orderBy('position')->find($request['relation_ids'])]);
    }

    private function queryParamsValidation() {
        return [
            'child-of' => self::ID_RULE,
            'parent-of' => self::ID_RULE,
            'ancestor-of' => self::ID_RULE,
            'descendant-of' => self::ID_RULE,
            'siblings-of' => self::ID_RULE,
            'related-by' => self::ID_RULE_WITH_FILTER,
            'relating' => self::ID_RULE_WITH_FILTER,
            'media-of' => self::ID_RULE,
            'of-model' => self::MODEL_RULE,
            'model_name' => self::MODEL_RULE,
            'only-published' => 'in:true,false',
        ];
    }

    /**
     * Process the request to know for select query parameter and add the corresponding select statments
     *
     * @param $query
     * @param $request
     * @return mixed
     */
    private function addSelects($query, $request, $lang, $modelClassName) {
        // Selects
        $query->when(!$request->exists('select') && !$request->exists('order-by'), function ($q) use ($request) {
            return $q->select('entities.*');
        })
            ->when($request->get('select') || $request->get('order-by'), function ($q) use ($request, $lang, $modelClassName) {
                $selects = explode(',', $request->get('select'));
                $ordersBy = explode(',', $request->get('order-by'));
                foreach (array_merge($selects) as $select) {
                    $select = explode(":", $select)[0];
                    if (!in_array($select, $this->addedSelects)) {
                        $appendProperties = [];
                        $appendContents = [];
                        if (Str::startsWith( $select, 'properties.')) {
                            $appendProperties[] = Str::after($select, '.');
                        } else if (Str::startsWith( $select, 'contents.')) {
                            $contentsParts = $this->getParts($select);
                            foreach ($contentsParts['fields'] as $field) {
                                $appendContents[] = $field;
                            }
                        } else if ($select === "route") {
                            $q->appendRoute($lang);
                        } else if ($select === "contents") {
                            $modelInstance =  new $modelClassName();
                            $appendContents = array_merge($appendContents, $modelInstance->getContentFields()) ;
                        } else if (Str::startsWith( $select, 'medium')) {
                            $q->appendMedium(null, null, $lang);
                        } else if ($select) {
                            $q->addSelect($select);
                        }
                        if (count($appendProperties) > 0) {
                            $q->appendProperties($appendProperties);
                        }
                        if (count($appendContents) > 0) {
                            $q->appendContents($appendContents, $lang);
                        }
                        $this->addedSelects[] = $select;
                    }
                }
                return $q;
            });
        return $query;
    }

    /**
     * Process the request to know for relations query parameter and add the corresponding select statments
     *
     * @param $query
     * @param $request
     * @return mixed
     */
    private function addRelations($query, $request) {
        // Selects
        $query->when($request->get('with'), function ($q) use ($request) {
            $relations = explode(',', $request->get('with'));
            foreach ($relations as $relation) {
                $relationParts = $this->getParts($relation);
                if (!in_array($relation, $this->calledRelations)) {
                    if ($relationParts['relation'] === 'medium') {
                        $q->appendMedium($relationParts['param'], $relationParts['fields'], $request->lang);
                    } else {
                        $q->with($relationParts['relation']);
                    }
                    $this->calledRelations[] = $relationParts['relation'];
                };
            }
            return $q;
        });
        return $query;
    }

    /**
     * Get the parts of a item in the query
     */
    private function getParts($item) {
        $partsParam = explode(':', $item);
        $partsFields = explode('.', $partsParam[0]);
        $param = $partsParam[1] ?? null;
        $object = array_shift($partsFields);
        return [
            "relation" => $object,
            "fields" => $partsFields,
            "param" => $param
        ];
    }

}

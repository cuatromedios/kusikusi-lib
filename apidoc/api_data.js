define({ "api": [
  {
    "type": "get",
    "url": "apapi/cms/config",
    "title": "Get the CMS configuration.",
    "description": "<p>Returns an object with the configuration for the CMS frontend.</p>",
    "group": "Cms",
    "parameter": {
      "examples": [
        {
          "title": "Example Request (JavaScript):",
          "content": "const url = new URL(\n    \"http://127.0.0.1:8000/api/cms/config\"\n);\nlet headers = {\n    \"Content-Type\": \"application/json\",\n    \"Accept\": \"application/json\",\n};\nfetch(url, {\n    method: \"GET\",\n    headers: headers,\n})\n    .then(response => response.json())\n    .then(json => console.log(json));",
          "type": "json"
        },
        {
          "title": "Example Request (PHP):",
          "content": "$client = new \\GuzzleHttp\\Client();\n$response = $client->get(\n    'http://127.0.0.1:8000/api/cms/config',\n    [\n        'headers' => [\n            'Content-Type' => 'application/json',\n            'Accept' => 'application/json',\n        ],\n    ]\n);\n$body = $response->getBody();\nprint_r(json_decode((string) $body));",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Response (example):",
          "content": "{\n    \"langs\": [\n        \"en_US\",\n        \"es_ES\"\n    ],\n    \"page_size\": 25,\n    \"token_expiration_in_seconds\": 0,\n    \"short_id_length\": 10,\n    \"models\": {\n        \"home\": {\n            \"icon\": \"home\",\n            \"name\": \"models.home\",\n            \"views\": [\n                \"home\",\n                \"home2\"\n            ],\n            \"form\": [\n                {\n                    \"label\": \"contents.contents\",\n                    \"components\": [\n                        {\n                            \"component\": \"nq-input\",\n                            \"value\": \"contents.title\",\n                            \"label\": \"contents.title\",\n                            \"props\": {\n                                \"size\": \"xl\"\n                            }\n                        },\n                        {\n                            \"component\": \"html-editor\",\n                            \"value\": \"contents.welcome\",\n                            \"label\": \"contents.summary\",\n                            \"props\": {\n                                \"type\": \"textarea\"\n                            }\n                        },\n                        {\n                            \"component\": \"slug\",\n                            \"value\": \"contents.slug\",\n                            \"label\": \"contents.slug\"\n                        },\n                        {\n                            \"component\": \"nq-input\",\n                            \"value\": \"view\",\n                            \"label\": \"Vista\"\n                        }\n                    ]\n                },\n                {\n                    \"label\": \"contents.children\",\n                    \"components\": [\n                        {\n                            \"component\": \"children\",\n                            \"props\": {\n                                \"models\": [\n                                    \"section\",\n                                    \"page\"\n                                ],\n                                \"order_by\": \"contents.title\",\n                                \"tags\": [\n                                    \"menu\",\n                                    \"footer\"\n                                ]\n                            }\n                        }\n                    ]\n                },\n                {\n                    \"label\": \"contents.media\",\n                    \"components\": [\n                        {\n                            \"component\": \"media\",\n                            \"props\": {\n                                \"allowed\": [\n                                    \"*\"\n                                ],\n                                \"tags\": [\n                                    \"hero\",\n                                    \"og\"\n                                ]\n                            }\n                        }\n                    ]\n                }\n            ]\n        },\n        \"page\": {\n            \"icon\": \"description\",\n            \"name\": \"models.page\",\n            \"form\": [\n                {\n                    \"label\": \"contents.contents\",\n                    \"components\": [\n                        {\n                            \"component\": \"nq-input\",\n                            \"value\": \"contents.title\",\n                            \"label\": \"contents.title\"\n                        },\n                        {\n                            \"component\": \"nq-input\",\n                            \"value\": \"contents.welcome\",\n                            \"label\": \"content.summary\"\n                        },\n                        {\n                            \"component\": \"slug\",\n                            \"value\": \"contents.slug\",\n                            \"label\": \"contents.slug\"\n                        }\n                    ]\n                },\n                {\n                    \"label\": \"contents.media\",\n                    \"components\": [\n                        {\n                            \"component\": \"media\",\n                            \"props\": {\n                                \"allowed\": [\n                                    \"webImages\",\n                                    \"webVideos\",\n                                    \"xhr\"\n                                ],\n                                \"tags\": [\n                                    \"icon\",\n                                    \"gallery\"\n                                ]\n                            }\n                        }\n                    ]\n                }\n            ]\n        },\n        \"section\": {\n            \"icon\": \"folder\",\n            \"name\": \"models.section\",\n            \"form\": [\n                {\n                    \"label\": \"contents.contents\",\n                    \"components\": [\n                        {\n                            \"component\": \"nq-input\",\n                            \"value\": \"contents.title\",\n                            \"label\": \"contents.title\"\n                        },\n                        {\n                            \"component\": \"nq-input\",\n                            \"value\": \"contents.summary\",\n                            \"label\": \"contents.summary\"\n                        },\n                        {\n                            \"component\": \"nq-input\",\n                            \"value\": \"contents.slug\",\n                            \"label\": \"contents.slug\"\n                        }\n                    ]\n                },\n                {\n                    \"label\": \"contents.children\",\n                    \"components\": [\n                        {\n                            \"component\": \"children\",\n                            \"props\": {\n                                \"models\": [\n                                    \"page\"\n                                ]\n                            }\n                        }\n                    ]\n                }\n            ]\n        },\n        \"medium\": {\n            \"icon\": \"insert_drive_file\",\n            \"name\": \"models.medium\",\n            \"form\": [\n                {\n                    \"label\": \"contents.contents\",\n                    \"components\": [\n                        {\n                            \"component\": \"nq-input\",\n                            \"value\": \"contents.title\",\n                            \"label\": \"contents.title\"\n                        }\n                    ]\n                }\n            ]\n        }\n    },\n    \"formats\": {\n        \"webImages\": [\n            \"jpeg\",\n            \"jpg\",\n            \"png\",\n            \"gif\"\n        ],\n        \"images\": [\n            \"jpeg\",\n            \"jpg\",\n            \"png\",\n            \"gif\",\n            \"tif\",\n            \"tiff\",\n            \"iff\",\n            \"bmp\",\n            \"psd\"\n        ],\n        \"audios\": [\n            \"mp3\",\n            \"wav\",\n            \"aiff\",\n            \"aac\",\n            \"oga\",\n            \"pcm\",\n            \"flac\"\n        ],\n        \"webAudios\": [\n            \"mp3\",\n            \"oga\"\n        ],\n        \"videos\": [\n            \"mov\",\n            \"mp4\",\n            \"qt\",\n            \"avi\",\n            \"mpe\",\n            \"mpeg\",\n            \"ogg\",\n            \"m4p\",\n            \"m4v\",\n            \"flv\",\n            \"wmv\"\n        ],\n        \"webVideos\": [\n            \"webm\",\n            \"mp4\",\n            \"ogg\",\n            \"m4p\",\n            \"m4v\"\n        ],\n        \"documents\": [\n            \"doc\",\n            \"docx\",\n            \"xls\",\n            \"xlsx\",\n            \"ppt\",\n            \"pptx\",\n            \"pdf\",\n            \"htm\",\n            \"html\",\n            \"txt\",\n            \"rtf\",\n            \"csv\",\n            \"pps\",\n            \"ppsx\",\n            \"odf\",\n            \"key\",\n            \"pages\",\n            \"numbers\"\n        ]\n    }\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./src/Http/Controllers/CmsController.php",
    "groupTitle": "Cms",
    "name": "GetApapiCmsConfig"
  },
  {
    "type": "delete",
    "url": "api/entity/{caller_entity_id}/relation/{called_entity_id}/{kind}",
    "title": "Deletes a relation if exists.",
    "permission": [
      {
        "name": "Requires Authentication"
      }
    ],
    "group": "Entity",
    "parameter": {
      "fields": {
        "URL Parameters": [
          {
            "group": "URL Parameters",
            "optional": false,
            "field": "entity_caller_id",
            "description": "<p>required, The id of the entity to create or update a relation</p>"
          },
          {
            "group": "URL Parameters",
            "type": "string",
            "optional": false,
            "field": "entity_called_id",
            "description": "<p>required, The id of the entity to relate. Example: s4FG56mkdRT5</p>"
          },
          {
            "group": "URL Parameters",
            "type": "string",
            "optional": false,
            "field": "kind",
            "description": "<p>required, The kind of relation to create or update. Example: medium | category</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example Request (JavaScript):",
          "content": "const url = new URL(\n    \"http://127.0.0.1:8000/api/entity/1/relation/1/medium | category\"\n);\nlet headers = {\n    \"Content-Type\": \"application/json\",\n    \"Accept\": \"application/json\",\n};\nfetch(url, {\n    method: \"DELETE\",\n    headers: headers,\n})\n    .then(response => response.json())\n    .then(json => console.log(json));",
          "type": "json"
        },
        {
          "title": "Example Request (PHP):",
          "content": "$client = new \\GuzzleHttp\\Client();\n$response = $client->delete(\n    'http://127.0.0.1:8000/api/entity/1/relation/1/medium | category',\n    [\n        'headers' => [\n            'Content-Type' => 'application/json',\n            'Accept' => 'application/json',\n        ],\n    ]\n);\n$body = $response->getBody();\nprint_r(json_decode((string) $body));",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Response (example):",
          "content": "{\n      \"relation_id\": \"673KBPT778\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./src/Http/Controllers/EntityController.php",
    "groupTitle": "Entity",
    "name": "DeleteApiEntityCaller_entity_idRelationCalled_entity_idKind"
  },
  {
    "type": "delete",
    "url": "api/entity/{entity_id}",
    "title": "Deletes an entity.",
    "permission": [
      {
        "name": "Requires Authentication"
      }
    ],
    "group": "Entity",
    "parameter": {
      "fields": {
        "URL Parameters": [
          {
            "group": "URL Parameters",
            "optional": true,
            "field": "entity_id",
            "description": "<p>The id of the entity to delete</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example Request (JavaScript):",
          "content": "const url = new URL(\n      \"http://127.0.0.1:8000/api/entity/totam\"\n  );\n  let headers = {\n      \"Content-Type\": \"application/json\",\n      \"Accept\": \"application/json\",\n  };\n  fetch(url, {\n      method: \"DELETE\",\n      headers: headers,\n  })\n      .then(response => response.json())\n      .then(json => console.log(json));",
          "type": "json"
        },
        {
          "title": "Example Request (PHP):",
          "content": "$client = new \\GuzzleHttp\\Client();\n  $response = $client->delete(\n      'http://127.0.0.1:8000/api/entity/totam',\n      [\n          'headers' => [\n              'Content-Type' => 'application/json',\n              'Accept' => 'application/json',\n          ],\n      ]\n  );\n  $body = $response->getBody();\n  print_r(json_decode((string) $body));",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Response (example):",
          "content": "{\n      \"id\": \"NiCJ5xKaIy\",\n      \"deleted_at\": \"2020-04-20T21:19:27.000000Z\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./src/Http/Controllers/EntityController.php",
    "groupTitle": "Entity",
    "name": "DeleteApiEntityEntity_id"
  },
  {
    "type": "get",
    "url": "api/entities[/{model_name}]",
    "title": "Get a collection of  entities.",
    "permission": [
      {
        "name": "Requires Authentication"
      }
    ],
    "description": "<p>Returns a paginated collection of entities, filtered by all set conditions.</p>",
    "group": "Entity",
    "parameter": {
      "fields": {
        "URL Parameters": [
          {
            "group": "URL Parameters",
            "optional": true,
            "field": "model_name",
            "description": "<p>If a model name is provided, the results will have the corresponding scope and special defined relations and accesosrs will be available.</p>"
          }
        ],
        "Parameter": [
          {
            "group": "Parameter",
            "optional": true,
            "field": "select",
            "description": "<p>A comma separated list of fields of the entity to include. It is possible to flat the properties json column using a dot syntax. Example: id,model,properties.price</p>"
          },
          {
            "group": "Parameter",
            "optional": true,
            "field": "order-by",
            "description": "<p>A comma separated lis of fields to order by. Example: model,properties.price:desc,contents.title</p>"
          },
          {
            "group": "Parameter",
            "optional": true,
            "field": "of-model",
            "description": "<p>(filter) The name of the model the entities should be. Example: page</p>"
          },
          {
            "group": "Parameter",
            "optional": true,
            "field": "only-published",
            "description": "<p>(filter) Get only published, not deleted entities, true if not set. Example: true</p>"
          },
          {
            "group": "Parameter",
            "optional": true,
            "field": "child-of",
            "description": "<p>(filter) The id or short id of the entity the result entities should be child of. Example: home</p>"
          },
          {
            "group": "Parameter",
            "optional": true,
            "field": "parent-of",
            "description": "<p>(filter) The id or short id of the entity the result entities should be parent of (will return only one). Example: 8fguTpt5SB</p>"
          },
          {
            "group": "Parameter",
            "optional": true,
            "field": "ancestor-of",
            "description": "<p>(filter) The id or short id of the entity the result entities should be ancestor of. Example: enKSUfUcZN</p>"
          },
          {
            "group": "Parameter",
            "optional": true,
            "field": "descendant-of",
            "description": "<p>(filter) The id or short id of the entity the result entities should be descendant of. Example: xAaqz2RPyf</p>"
          },
          {
            "group": "Parameter",
            "optional": true,
            "field": "siblings-of",
            "description": "<p>(filter) The id or short id of the entity the result entities should be siblings of. Example: _tuKwVy8Aa</p>"
          },
          {
            "group": "Parameter",
            "optional": true,
            "field": "related-by",
            "description": "<p>(filter) The id or short id of the entity the result entities should have been called by using a relation. Can be added a filter to a kind of relation for example: theShortId:category. The ancestor kind of relations are discarted unless are explicity specified. Example: ElFYpgEvWS</p>"
          },
          {
            "group": "Parameter",
            "optional": true,
            "field": "relating",
            "description": "<p>(filter) The id or short id of the entity the result entities should have been a caller of using a relation. Can be added a filder to a kind o relation for example: shortFotoId:medium to know the entities has caller that medium. The ancestor kind of relations are discarted unless are explicity specified. Example: enKSUfUcZN</p>"
          },
          {
            "group": "Parameter",
            "optional": true,
            "field": "media-of",
            "description": "<p>(filter) The id or short id of the entity the result entities should have a media relation to. Example: enKSUfUcZN</p>"
          },
          {
            "group": "Parameter",
            "optional": true,
            "field": "with",
            "description": "<p>A comma separated list of relationships should be included in the result. Example: media,contents,entities_related, entities_related.contents (nested relations)</p>"
          },
          {
            "group": "Parameter",
            "optional": true,
            "field": "per-page",
            "description": "<p>The amount of entities per page the result should be the amount of entities on a single page. Example: 6</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example Request (JavaScript):",
          "content": "const url = new URL(\n     \"http://127.0.0.1:8000/api/entities[/expedita]\"\n );\n let params = {\n     \"select\": \"id,model,properties.price\",\n     \"order-by\": \"model,properties.price:desc,contents.title\",\n     \"of-model\": \"page\",\n     \"only-published\": \"true\",\n     \"child-of\": \"home\",\n     \"parent-of\": \"8fguTpt5SB\",\n     \"ancestor-of\": \"enKSUfUcZN\",\n     \"descendant-of\": \"xAaqz2RPyf\",\n     \"siblings-of\": \"_tuKwVy8Aa\",\n     \"related-by\": \"ElFYpgEvWS\",\n     \"relating\": \"enKSUfUcZN\",\n     \"media-of\": \"enKSUfUcZN\",\n     \"with\": \"media,contents,entities_related, entities_related.contents (nested relations)\",\n     \"per-page\": \"6\",\n };\n Object.keys(params)\n     .forEach(key => url.searchParams.append(key, params[key]));\n let headers = {\n     \"Content-Type\": \"application/json\",\n     \"Accept\": \"application/json\",\n };\n fetch(url, {\n     method: \"GET\",\n     headers: headers,\n })\n     .then(response => response.json())\n     .then(json => console.log(json));",
          "type": "json"
        },
        {
          "title": "Example Request (PHP):",
          "content": "$client = new \\GuzzleHttp\\Client();\n$response = $client->get(\n  'http://127.0.0.1:8000/api/entities[/expedita]',\n   [\n       headers' => [\n            'Content-Type' => 'application/json',\n            'Accept' => 'application/json',\n        ],\n        'query' => [\n            'select'=> 'id,model,properties.price',\n            'order-by'=> 'model,properties.price:desc,contents.title',\n            'of-model'=> 'page',\n            'only-published'=> 'true',\n            'child-of'=> 'home',\n            'parent-of'=> '8fguTpt5SB',\n            'ancestor-of'=> 'enKSUfUcZN',\n            'descendant-of'=> 'xAaqz2RPyf',\n            'siblings-of'=> '_tuKwVy8Aa',\n            'related-by'=> 'ElFYpgEvWS',\n            'relating'=> 'enKSUfUcZN',\n            'media-of'=> 'enKSUfUcZN',\n            'with'=> 'media,contents,entities_related, entities_related.contents (nested relations)',\n            'per-page'=> '6',\n        ],\n    ]\n);\n$body = $response->getBody();\nprint_r(json_decode((string) $body));",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Response (example):",
          "content": "  {\n    \"current_page\": 1,\n    \"data\": [\n       {\n            \"id\": \"35337182-7a0c-44c4-a11f-68cd9da930b2\",\n            \"content\": {\n                \"body\": {\n                    \"en_US\": \"Consequatur tempora deleniti ea cum totam. Qui quidem quis eius expedita atque officia incidunt.\"\n                },\n                \"slug\": {\n                    \"en_US\": \"mrs-karlie-torp\"\n                },\n                \"title\": {\n                    \"en_US\": \"Felipa Haley PhD\"\n                },\n                \"summary\": {\n                    \"en_US\": \"Railroad Inspector\"\n                }\n            },\n            \"model\": \"page\",\n            \"kind\": \"ancestor\",\n           \"position\": 0,\n            \"depth\": 1,\n            \"tags\": null\n        },\n        {\n            \"id\": \"4cbbd1cd-3708-4ac2-8ff7-7261cd6fbe81\",\n            \"content\": {\n                \"body\": {\n                    \"en_US\": \"Voluptatem sed autem voluptas eum fuga amet neque. Odit accusantium nemo et architecto.\"\n                },\n                \"slug\": {\n                    \"en_US\": \"amely-koepp\"\n                },\n                \"title\": {\n                    \"en_US\": \"Ashley D'Amore\"\n                },\n                \"summary\": {\n                    \"en_US\": \"Homeland Security\"\n                }\n            },\n            \"model\": \"page\",\n            \"kind\": \"ancestor\",\n            \"position\": 0,\n            \"depth\": 1,\n            \"tags\": null\n        },\n        {\n            \"id\": \"6d776ddf-b416-42c7-86cf-c665770c96ff\",\n            \"content\": {\n                \"body\": {\n                    \"en_US\": \"Error animi autem sunt et. Qui quia eos sunt sint dicta eligendi quasi. Ut quae aut facilis vel.\"\n                },\n                \"slug\": {\n                    \"en_US\": \"janis-jenkins-jr\"\n                },\n                \"title\": {\n                    \"en_US\": \"Mr. Reagan Deckow I\"\n                },\n                \"summary\": {\n                    \"en_US\": \"Pesticide Sprayer\"\n                }\n            },\n            \"model\": \"page\",\n            \"kind\": \"ancestor\",\n            \"position\": 0,\n            \"depth\": 1,\n            \"tags\": null\n        },\n        {\n            \"id\": \"7d504be2-ca0f-4836-b6d2-f00c2dff209c\",\n            \"content\": {\n                \"body\": {\n                    \"en_US\": \"Consequatur deserunt non quo sint. Voluptas sint et aliquam qui.\"\n                },\n                \"slug\": {\n                    \"en_US\": \"mr-xavier-yundt-iv\"\n                },\n                \"title\": {\n                    \"en_US\": \"Joyce Kohler MD\"\n                },\n                \"summary\": {\n                    \"en_US\": \"Transportation Equipment Maintenance\"\n                }\n            },\n            \"model\": \"page\",\n            \"kind\": \"ancestor\",\n            \"position\": 0,\n            \"depth\": 1,\n            \"tags\": null\n        },\n        {\n            \"id\": \"801892f7-8dcb-4fdc-a1fd-5251ceb6af09\",\n            \"content\": {\n                \"body\": {\n                    \"en_US\": \"Assumenda quaerat ipsam dolores ducimus itaque earum sit. Aut dolorem nisi et harum sunt molestiae.\"\n                },\n                \"slug\": {\n                    \"en_US\": \"ms-lauretta-rohan\"\n                },\n                \"title\": {\n                    \"en_US\": \"Dr. Briana Bergstrom DVM\"\n                },\n                \"summary\": {\n                    \"en_US\": \"Hotel Desk Clerk\"\n                }\n           },\n            \"model\": \"page\",\n            \"kind\": \"ancestor\",\n            \"position\": 0,\n            \"depth\": 1,\n            \"tags\": null\n        }\n    ],\n    \"first_page_url\": \"http:\\/\\/127.0.0.1:8000\\/api\\/entities?relating=bee7a88a-459c-419a-9b3f-96ad3d3822b5%3Aancestor&page=1\",\n    \"from\": 1,\n    \"last_page\": 1,\n    \"last_page_url\": \"http:\\/\\/127.0.0.1:8000\\/api\\/entities?relating=bee7a88a-459c-419a-9b3f-96ad3d3822b5%3Aancestor&page=1\",\n    \"next_page_url\": null,\n    \"path\": \"http:\\/\\/127.0.0.1:8000\\/api\\/entities\",\n    \"per_page\": 100,\n    \"prev_page_url\": null,\n    \"to\": 5,\n    \"total\": 5\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./src/Http/Controllers/EntityController.php",
    "groupTitle": "Entity",
    "name": "GetApiEntitiesModel_name"
  },
  {
    "type": "get",
    "url": "api/entity/{entity_id}",
    "title": "Retrieve the entity for the given ID.",
    "permission": [
      {
        "name": "Requires Authentication"
      }
    ],
    "group": "Entity",
    "parameter": {
      "fields": {
        "URL Parameters": [
          {
            "group": "URL Parameters",
            "optional": true,
            "field": "entity_id",
            "description": "<p>The id of the entity to show.</p>"
          }
        ],
        "Parameter": [
          {
            "group": "Parameter",
            "optional": true,
            "field": "select",
            "description": "<p>A comma separated list of fields of the entity to include. It is possible to flat the properties json column using a dot syntax. Example: id,model,properties.price</p>"
          },
          {
            "group": "Parameter",
            "optional": true,
            "field": "with",
            "description": "<p>A comma separated list of relationships should be included in the result. Example: media,contents,entities_related, entities_related.contents (nested relations)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example Request (JavaScript):",
          "content": "const url = new URL(\n     \"http://127.0.0.1:8000/api/entity/corporis\"\n  );\n  let params = {\n      \"select\": \"id,model,properties.price\",\n      \"with\": \"media,contents,entities_related, entities_related.contents (nested relations)\",\n  };\n  Object.keys(params)\n      .forEach(key => url.searchParams.append(key, params[key]));\n  let headers = {\n      \"Content-Type\": \"application/json\",\n      \"Accept\": \"application/json\",\n  };\n  fetch(url, {\n      method: \"GET\",\n      headers: headers,\n  })\n      .then(response => response.json())\n      .then(json => console.log(json));",
          "type": "json"
        },
        {
          "title": "Example Request (PHP): ",
          "content": "$client = new \\GuzzleHttp\\Client();\n$response = $client->get(\n    'http://127.0.0.1:8000/api/entity/corporis',\n    [\n        'headers' => [\n            'Content-Type' => 'application/json',\n            'Accept' => 'application/json',\n        ],\n        'query' => [\n            'select'=> 'id,model,properties.price',\n            'with'=> 'media,contents,entities_related, entities_related.contents (nested relations)',\n        ],\n    ]\n);\n$body = $response->getBody();\nprint_r(json_decode((string) $body));",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Response (example):",
          "content": "{\n    \"id\": \"DkESBOv-wT\",\n    \"model\": \"page-m\",\n    \"properties\": {\n        \"prop1\": \"Z\",\n        \"prop2\": \"Z\"\n    },\n    \"view\": \"yuyxo\",\n    \"parent_entity_id\": \"home\",\n    \"is_active\": true,\n    \"created_by\": null,\n    \"updated_by\": null,\n    \"published_at\": \"2020-08-27 14:55:30\",\n    \"unpublished_at\": \"9999-12-31 23:59:59\",\n    \"version\": 18,\n    \"version_tree\": 0,\n    \"version_relations\": 9,\n    \"version_full\": 27,\n    \"created_at\": \"2020-04-20T19:36:58.000000Z\",\n    \"updated_at\": \"2020-04-20T20:25:19.000000Z\",\n    \"deleted_at\": null\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./src/Http/Controllers/EntityController.php",
    "groupTitle": "Entity",
    "name": "GetApiEntityEntity_id"
  },
  {
    "type": "patch",
    "url": "api/entities/relations/reorder",
    "title": "Reorders an array of relations.",
    "permission": [
      {
        "name": "Requires Authentication"
      }
    ],
    "description": "<p>Receive an array of relation ids, and sets the individual position to its index in the array.</p>",
    "group": "Entity",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "array",
            "optional": false,
            "field": "relation_ids",
            "description": "<p>required, An array of relation ids to reorder. Example ['s4FG56mkdRT5', 'FG56mkdRT5s3', '4FG56mkdRT5d']</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example Request (JavaScript):",
          "content": "const url = new URL(\n    \"http://127.0.0.1:8000/api/entities/relations/reorder\"\n);\nlet headers = {\n    \"Content-Type\": \"application/json\",\n    \"Accept\": \"application/json\",\n};\nlet body = {\n    \"relation_ids\": []\n}\nfetch(url, {\n    method: \"PATCH\",\n    headers: headers,\n    body: body\n})\n    .then(response => response.json())\n    .then(json => console.log(json));",
          "type": "json"
        },
        {
          "title": "Example Request (PHP):",
          "content": "$client = new \\GuzzleHttp\\Client();\n$response = $client->patch(\n    'http://127.0.0.1:8000/api/entities/relations/reorder',\n    [\n        'headers' => [\n            'Content-Type' => 'application/json',\n            'Accept' => 'application/json',\n        ],\n        'json' => [\n            'relation_ids' => [],\n        ],\n    ]\n);\n$body = $response->getBody();\nprint_r(json_decode((string) $body));",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Response (example):",
          "content": "{\n    \"relations\": [\n        {\n            \"relation_id\": \"JvE3WPG504\",\n            \"position\": 1\n        },\n        {\n            \"relation_id\": \"izMhhYpXA7\",\n            \"position\": 2\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./src/Http/Controllers/EntityController.php",
    "groupTitle": "Entity",
    "name": "PatchApiEntitiesRelationsReorder"
  },
  {
    "type": "patch",
    "url": "api/entity/{entity_id}",
    "title": "Updates an entity.",
    "permission": [
      {
        "name": "Requires Authentication"
      }
    ],
    "group": "Entity",
    "parameter": {
      "fields": {
        "URL Parameters": [
          {
            "group": "URL Parameters",
            "optional": true,
            "field": "entity_id",
            "description": "<p>The id of the entity to update</p>"
          }
        ],
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "view",
            "description": "<p>The name of the view to use. Default: the same name of the model. Example: page</p>"
          },
          {
            "group": "Parameter",
            "type": "date",
            "optional": true,
            "field": "published_at",
            "description": "<p>A date time the entity should be published. Default: current date time. Example: 2020-02-02 12:00:00.</p>"
          },
          {
            "group": "Parameter",
            "type": "date",
            "optional": true,
            "field": "unpublished_at",
            "description": "<p>A date time the entity should be published. Default: 9999-12-31 23:59:59. Example: 2020-02-02 12:00:00.</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "properties",
            "description": "<p>An object with properties. Example: {&quot;price&quot;: 200, &quot;format&quot;: &quot;jpg&quot;}</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "id",
            "description": "<p>You can set your own ID, a maximum of 16, safe characters: A-Z, a-z, 0-9, _ and -. Default: autogenerated. Example: home</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": true,
            "field": "contents",
            "description": "<p>An array of contents to be created for the entity. Example: { &quot;title&quot;: {&quot;en_US&quot;: &quot;The page M&quot;, &quot;es_ES&quot;: &quot;La página M&quot;}, &quot;slug&quot;: {&quot;en_US&quot;: &quot;page-m&quot;, &quot;es_ES&quot;: &quot;pagina-m&quot;}}</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": true,
            "field": "relations",
            "description": "<p>An array of relations to be created for the entity. Example: &quot;relations&quot;: [{&quot;called_entity_id&quot;: &quot;mf4gWE45pm&quot;,&quot;kind&quot;: &quot;category&quot;,&quot;position&quot;: 2, &quot;tags&quot;:[&quot;main&quot;]}]</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example Request (JavaScript):",
          "content": "const url = new URL(\n      \"http://127.0.0.1:8000/api/entity/minus\"\n  );\n  let headers = {\n      \"Content-Type\": \"application/json\",\n      \"Accept\": \"application/json\",\n  };\n  let body = {\n      \"view\": \"page\",\n      \"published_at\": \"2020-02-02 12:00:00.\",\n      \"unpublished_at\": \"2020-02-02 12:00:00.\",\n      \"properties\": \"{\\\"price\\\": 200, \\\"format\\\": \\\"jpg\\\"}\",\n      \"id\": \"home\",\n      \"contents\": \"{ \\\"title\\\": {\\\"en_US\\\": \\\"The page M\\\", \\\"es_ES\\\": \\\"La p\\u00e1gina M\\\"}, \\\"slug\\\": {\\\"en_US\\\": \\\"page-m\\\", \\\"es_ES\\\": \\\"pagina-m\\\"}}\",\n      \"relations\": \"\\\"relations\\\": [{\\\"called_entity_id\\\": \\\"mf4gWE45pm\\\",\\\"kind\\\": \\\"category\\\",\\\"position\\\": 2, \\\"tags\\\":[\\\"main\\\"]}]\"\n  }\n  fetch(url, {\n      method: \"PATCH\",\n      headers: headers,\n      body: body\n  })\n      .then(response => response.json())\n      .then(json => console.log(json));",
          "type": "json"
        },
        {
          "title": "Example Request (PHP):",
          "content": "$client = new \\GuzzleHttp\\Client();\n$response = $client->patch(\n      'http://127.0.0.1:8000/api/entity/minus',\n      [\n          'headers' => [\n              'Content-Type' => 'application/json',\n              'Accept' => 'application/json',\n          ],\n          'json' => [\n              'view' => 'page',\n              'published_at' => '2020-02-02 12:00:00.',\n              'unpublished_at' => '2020-02-02 12:00:00.',\n              'properties' => '{\"price\": 200, \"format\": \"jpg\"}',\n              'id' => 'home',\n              'contents' => '{ \"title\": {\"en_US\": \"The page M\", \"es_ES\": \"La página M\"}, \"slug\": {\"en_US\": \"page-m\", \"es_ES\": \"pagina-m\"}}',\n              'relations' => '\"relations\": [{\"called_entity_id\": \"mf4gWE45pm\",\"kind\": \"category\",\"position\": 2, \"tags\":[\"main\"]}]',\n          ],\n      ]\n  );\n  $body = $response->getBody();\n  print_r(json_decode((string) $body));",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Response (example):",
          "content": "{\n      \"model\": \"page-m\",\n      \"view\": \"page\",\n      \"parent_entity_id\": \"home\",\n      \"published_at\": \"2020-08-27T14:55:30\",\n      \"properties\": {\n          \"prop1\": \"b\",\n          \"prop2\": 1\n      },\n      \"id\": \"DkESBOv-wT\",\n      \"updated_at\": \"2020-04-20T19:36:58.000000Z\",\n      \"created_at\": \"2020-04-20T19:36:58.000000Z\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./src/Http/Controllers/EntityController.php",
    "groupTitle": "Entity",
    "name": "PatchApiEntityEntity_id"
  },
  {
    "type": "post",
    "url": "api/entity",
    "title": "Creates a new entity.",
    "permission": [
      {
        "name": "Requires Authentication"
      }
    ],
    "group": "Entity",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "model",
            "description": "<p>required The model name. Example: page.</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "view",
            "description": "<p>The name of the view to use. Default: the same name of the model. Example: page</p>"
          },
          {
            "group": "Parameter",
            "type": "date",
            "optional": true,
            "field": "published_at",
            "description": "<p>A date time the entity should be published. Default: current date time. Example: 2020-02-02 12:00:00.</p>"
          },
          {
            "group": "Parameter",
            "type": "date",
            "optional": true,
            "field": "unpublished_at",
            "description": "<p>A date time the entity should be published. Default: 9999-12-31 23:59:59. Example: 2020-02-02 12:00:00.</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "properties",
            "description": "<p>An object with properties. Example: {&quot;price&quot;: 200, &quot;format&quot;: &quot;jpg&quot;}</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "id",
            "description": "<p>You can set your own ID, a maximum of 16, safe characters: A-Z, a-z, 0-9, _ and -. Default: autogenerated. Example: home</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": true,
            "field": "contents",
            "description": "<p>An array of contents to be created for the entity. Example: { &quot;title&quot;: {&quot;en_US&quot;: &quot;The page M&quot;, &quot;es_ES&quot;: &quot;La página M&quot;}, &quot;slug&quot;: {&quot;en_US&quot;: &quot;page-m&quot;, &quot;es_ES&quot;: &quot;pagina-m&quot;}}</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": true,
            "field": "relations",
            "description": "<p>An array of relations to be created for the entity. Example: &quot;relations&quot;: [{&quot;called_entity_id&quot;: &quot;mf4gWE45pm&quot;,&quot;kind&quot;: &quot;category&quot;,&quot;position&quot;: 2, &quot;tags&quot;:[&quot;main&quot;]}]</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example Request (JavaScript):",
          "content": "const url = new URL(\n      \"http://127.0.0.1:8000/api/entity\"\n  );\n  let headers = {\n      \"Content-Type\": \"application/json\",\n      \"Accept\": \"application/json\",\n  };\n  let body = {\n      \"model\": \"page.\",\n      \"view\": \"page\",\n      \"published_at\": \"2020-02-02 12:00:00.\",\n      \"unpublished_at\": \"2020-02-02 12:00:00.\",\n      \"properties\": \"{\\\"price\\\": 200, \\\"format\\\": \\\"jpg\\\"}\",\n      \"id\": \"home\",\n      \"contents\": \"{ \\\"title\\\": {\\\"en_US\\\": \\\"The page M\\\", \\\"es_ES\\\": \\\"La p\\u00e1gina M\\\"}, \\\"slug\\\": {\\\"en_US\\\": \\\"page-m\\\", \\\"es_ES\\\": \\\"pagina-m\\\"}}\",\n      \"relations\": \"\\\"relations\\\": [{\\\"called_entity_id\\\": \\\"mf4gWE45pm\\\",\\\"kind\\\": \\\"category\\\",\\\"position\\\": 2, \\\"tags\\\":[\\\"main\\\"]}]\"\n  }\n  fetch(url, {\n      method: \"POST\",\n      headers: headers,\n      body: body\n  })\n      .then(response => response.json())\n      .then(json => console.log(json));",
          "type": "json"
        },
        {
          "title": "Example Request (PHP):",
          "content": "$client = new \\GuzzleHttp\\Client();\n$response = $client->post(\n      'http://127.0.0.1:8000/api/entity',\n      [\n          'headers' => [\n              'Content-Type' => 'application/json',\n              'Accept' => 'application/json',\n          ],\n          'json' => [\n              'model' => 'page.',\n              'view' => 'page',\n              'published_at' => '2020-02-02 12:00:00.',\n              'unpublished_at' => '2020-02-02 12:00:00.',\n              'properties' => '{\"price\": 200, \"format\": \"jpg\"}',\n              'id' => 'home',\n              'contents' => '{ \"title\": {\"en_US\": \"The page M\", \"es_ES\": \"La página M\"}, \"slug\": {\"en_US\": \"page-m\", \"es_ES\": \"pagina-m\"}}',\n              'relations' => '\"relations\": [{\"called_entity_id\": \"mf4gWE45pm\",\"kind\": \"category\",\"position\": 2, \"tags\":[\"main\"]}]',\n          ],\n      ]\n  );\n$body = $response->getBody();\nprint_r(json_decode((string) $body));",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Response (example):",
          "content": "{\n      \"model\": \"page-m\",\n      \"view\": \"page\",\n      \"parent_entity_id\": \"home\",\n      \"published_at\": \"2020-08-27T14:55:30\",\n      \"properties\": {\n          \"prop1\": \"b\",\n          \"prop2\": 1\n      },\n      \"id\": \"DkESBOv-wT\",\n      \"updated_at\": \"2020-04-20T19:36:58.000000Z\",\n      \"created_at\": \"2020-04-20T19:36:58.000000Z\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./src/Http/Controllers/EntityController.php",
    "groupTitle": "Entity",
    "name": "PostApiEntity"
  },
  {
    "type": "post",
    "url": "api/entity/{caller_entity_id}/create_and_relate",
    "title": "Creates a new entity with a relation.",
    "permission": [
      {
        "name": "Requires Authentication"
      }
    ],
    "description": "<p>Creates a new entity with a specific relation to another entity, the entity &quot;id&quot; and &quot;caller_entity_id&quot; should the same.</p>",
    "group": "Entity",
    "parameter": {
      "fields": {
        "URL Parameters": [
          {
            "group": "URL Parameters",
            "optional": false,
            "field": "entity_caller_id",
            "description": "<p>required, The id of the entity to create or update a relation</p>"
          }
        ],
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "model",
            "description": "<p>required, The model name. Example: home</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "kind",
            "description": "<p>required, The kind of relation to create or update. Example: medium | category</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "view",
            "description": "<p>The name of the view to use. Default: the same name of the model. Example: home</p>"
          },
          {
            "group": "Parameter",
            "type": "date",
            "optional": true,
            "field": "published_at",
            "description": "<p>A date time the entity should be published. Default: current date time. Example: 2020-02-02 12:00:00.</p>"
          },
          {
            "group": "Parameter",
            "type": "date",
            "optional": true,
            "field": "unpublished_at",
            "description": "<p>A date time the entity should be published. Default: 9999-12-31 23:59:59. Example: 2020-02-02 12:00:00.</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "properties",
            "description": "<p>An object with properties. Example: {&quot;price&quot;: 200, &quot;format&quot;: &quot;jpg&quot;}</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": true,
            "field": "contents",
            "description": "<p>An array of contents to be created for the entity. Example: { &quot;title&quot;: {&quot;en_US&quot;: &quot;The page M&quot;, &quot;es_ES&quot;: &quot;La página M&quot;}, &quot;slug&quot;: {&quot;en_US&quot;: &quot;page-m&quot;, &quot;es_ES&quot;: &quot;pagina-m&quot;}}</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": true,
            "field": "relations",
            "description": "<p>An array of relations to be created for the entity. Example: &quot;relations&quot;: [{&quot;called_entity_id&quot;: &quot;mf4gWE45pm&quot;,&quot;kind&quot;: &quot;category&quot;,&quot;position&quot;: 2, &quot;tags&quot;:[&quot;main&quot;]}]</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": true,
            "field": "tags",
            "description": "<p>An array of tags to add to the relation. Defaults to an empty array. Example: [&quot;1&quot;, '2&quot;].</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "position",
            "description": "<p>The position of the relation. Example: 3.</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "depth",
            "description": "<p>Yet another number value to use freely for the relation, used in ancestor type of relation to define the distance between an entity and other in the tree. Example 1.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example Request (JavaScript):",
          "content": "const url = new URL(\n      \"http://127.0.0.1:8000/api/entity/1/create_and_relate\"\n  );\n  let headers = {\n      \"Content-Type\": \"application/json\",\n      \"Accept\": \"application/json\",\n  };\n  let body = {\n      \"model\": \"home\",\n      \"kind\": \"medium | category\",\n      \"view\": \"home\",\n      \"published_at\": \"2020-02-02 12:00:00.\",\n      \"unpublished_at\": \"2020-02-02 12:00:00.\",\n      \"properties\": \"{\\\"price\\\": 200, \\\"format\\\": \\\"jpg\\\"}\",\n      \"contents\": \"{ \\\"title\\\": {\\\"en_US\\\": \\\"The page M\\\", \\\"es_ES\\\": \\\"La p\\u00e1gina M\\\"}, \\\"slug\\\": {\\\"en_US\\\": \\\"page-m\\\", \\\"es_ES\\\": \\\"pagina-m\\\"}}\",\n      \"relations\": \"\\\"relations\\\": [{\\\"called_entity_id\\\": \\\"mf4gWE45pm\\\",\\\"kind\\\": \\\"category\\\",\\\"position\\\": 2, \\\"tags\\\":[\\\"main\\\"]}]\",\n      \"tags\": \"[\\\"1\\\", '2\\\"].\",\n      \"position\": 3,\n      \"depth\": 3\n  }\n  fetch(url, {\n      method: \"POST\",\n      headers: headers,\n      body: body\n  })\n      .then(response => response.json())\n      .then(json => console.log(json));",
          "type": "json"
        },
        {
          "title": "Example Request (PHP):",
          "content": "$client = new \\GuzzleHttp\\Client();\n $response = $client->post(\n      'http://127.0.0.1:8000/api/entity/1/create_and_relate',\n      [\n          'headers' => [\n              'Content-Type' => 'application/json',\n              'Accept' => 'application/json',\n          ],\n          'json' => [\n              'model' => 'home',\n              'kind' => 'medium | category',\n              'view' => 'home',\n              'published_at' => '2020-02-02 12:00:00.',\n              'unpublished_at' => '2020-02-02 12:00:00.',\n              'properties' => '{\"price\": 200, \"format\": \"jpg\"}',\n              'contents' => '{ \"title\": {\"en_US\": \"The page M\", \"es_ES\": \"La página M\"}, \"slug\": {\"en_US\": \"page-m\", \"es_ES\": \"pagina-m\"}}',\n              'relations' => '\"relations\": [{\"called_entity_id\": \"mf4gWE45pm\",\"kind\": \"category\",\"position\": 2, \"tags\":[\"main\"]}]',\n              'tags' => '[\"1\", \\'2\"].',\n              'position' => 3,\n              'depth' => 3,\n          ],\n      ]\n  );\n  $body = $response->getBody();\n  print_r(json_decode((string) $body));",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Response (example):",
          "content": "{\n      \"id\": \"tEQxMPF8hs\",\n      \"model\": \"medium\",\n      \"properties\": [],\n      \"view\": \"medium\",\n      \"parent_entity_id\": null,\n      \"is_active\": true,\n      \"created_by\": null,\n      \"updated_by\": null,\n      \"published_at\": \"2020-05-09T00:17:54+00:00\",\n      \"unpublished_at\": null,\n      \"version\": 1,\n      \"version_tree\": 0,\n      \"version_relations\": 0,\n      \"version_full\": 1,\n      \"created_at\": \"2020-05-09T00:17:54+00:00\",\n      \"updated_at\": \"2020-05-09T00:17:54+00:00\",\n      \"deleted_at\": null,\n      \"thumb\": \"\\/media\\/tEQxMPF8hs\\/thumb\\/media.jpg\",\n      \"preview\": \"\\/media\\/tEQxMPF8hs\\/preview\\/media.jpg\",\n      \"entities_relating\": [\n          {\n              \"id\": \"4dnK2CJspO\",\n              \"model\": \"page\",\n              \"properties\": {\n                  \"exif\": {\n                      \"COMPUTED\": {\n                          \"html\": \"width=\\\"1280\\\" height=\\\"1102\\\"\",\n                          \"Width\": 1280,\n                          \"Height\": 1102,\n                          \"IsColor\": 1\n                      },\n                      \"FileName\": \"phpovyCKl\",\n                      \"FileSize\": 82033,\n                      \"FileType\": 2,\n                      \"MimeType\": \"image\\/jpeg\",\n                      \"FileDateTime\": 1588959027,\n                      \"SectionsFound\": \"\"\n                  },\n                  \"size\": 82033,\n                  \"type\": \"image\",\n                  \"prop1\": \"Z\",\n                  \"prop2\": \"Z\",\n                  \"width\": 1280,\n                  \"format\": \"jpg\",\n                  \"height\": 1102,\n                  \"isAudio\": false,\n                  \"isImage\": true,\n                  \"isVideo\": false,\n                  \"mimeType\": \"image\\/jpeg\",\n                  \"isDocument\": false,\n                  \"isWebAudio\": false,\n                  \"isWebImage\": true,\n                  \"isWebVideo\": false,\n                  \"originalName\": \"3evient.jpeg\"\n              },\n              \"view\": \"yuyxo\",\n              \"parent_entity_id\": \"0qtTYPQhm4\",\n              \"is_active\": true,\n              \"created_by\": null,\n              \"updated_by\": null,\n              \"published_at\": \"2020-05-07T12:50:49+00:00\",\n              \"unpublished_at\": null,\n              \"version\": 67,\n              \"version_tree\": 0,\n              \"version_relations\": 46,\n              \"version_full\": 113,\n              \"created_at\": \"2020-05-07T12:50:49+00:00\",\n              \"updated_at\": \"2020-05-08T17:31:54+00:00\",\n              \"deleted_at\": null,\n              \"relation\": {\n                  \"called_entity_id\": \"tEQxMPF8hs\",\n                  \"caller_entity_id\": \"4dnK2CJspO\",\n                  \"kind\": \"medium\",\n                  \"position\": 41,\n                  \"depth\": 0,\n                  \"tags\": []\n              }\n          }\n      ]\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./src/Http/Controllers/EntityController.php",
    "groupTitle": "Entity",
    "name": "PostApiEntityCaller_entity_idCreate_and_relate"
  },
  {
    "type": "post",
    "url": "api/entity/{caller_entity_id}/relation",
    "title": "Creates or updates a relation.",
    "permission": [
      {
        "name": "Requires Authentication"
      }
    ],
    "group": "Entity",
    "parameter": {
      "fields": {
        "URL Parameters": [
          {
            "group": "URL Parameters",
            "optional": false,
            "field": "entity_caller_id",
            "description": "<p>required, The id of the entity to create or update a relation</p>"
          }
        ],
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "entity_called_id",
            "description": "<p>required, The id of the entity to relate. Example: s4FG56mkdRT5</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "kind",
            "description": "<p>required, The kind of relation to create or update. Example: medium | category</p>"
          },
          {
            "group": "Parameter",
            "type": "array",
            "optional": true,
            "field": "tags",
            "description": "<p>An array of tags to add to the relation. Defaults to an empty array. Example [&quot;icon&quot;, 'gallery&quot;].</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "position",
            "description": "<p>The position of the relation. Example: 3.</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "depth",
            "description": "<p>Yet another number value to use freely for the relation, used in ancestor type of relation to define the distance between an entity and other in the tree. Example 1.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example Request (JavaScript):",
          "content": "const url = new URL(\n      \"http://127.0.0.1:8000/api/entity/1/relation\"\n  );\n  let headers = {\n      \"Content-Type\": \"application/json\",\n      \"Accept\": \"application/json\",\n  };\n  let body = {\n      \"entity_called_id\": \"s4FG56mkdRT5\",\n      \"kind\": \"medium | category\",\n      \"tags\": [],\n      \"position\": 3,\n      \"depth\": 13\n  }\n  fetch(url, {\n      method: \"POST\",\n      headers: headers,\n      body: body\n  })\n      .then(response => response.json())\n      .then(json => console.log(json));",
          "type": "json"
        },
        {
          "title": "Example Request (PHP):",
          "content": "$client = new \\GuzzleHttp\\Client();\n$response = $client->post(\n      'http://127.0.0.1:8000/api/entity/1/relation',\n      [\n          'headers' => [\n              'Content-Type' => 'application/json',\n              'Accept' => 'application/json',\n          ],\n          'json' => [\n              'entity_called_id' => 's4FG56mkdRT5',\n              'kind' => 'medium | category',\n              'tags' => [],\n              'position' => 3,\n              'depth' => 13,\n          ],\n      ]\n  );\n  $body = $response->getBody();\n  print_r(json_decode((string) $body));",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Response (example): ",
          "content": "{\n      \"relation_id\": \"WZ3PnzvNP4\",\n      \"caller_entity_id\": \"Z4bdjFSzn5\",\n      \"called_entity_id\": \"DtPatk4FNG\",\n      \"kind\": \"reltest\",\n      \"position\": 2,\n      \"depth\": 3,\n      \"tags\": [\n          \"icon\"\n      ],\n      \"created_at\": \"2020-04-23T15:01:32.000000Z\",\n      \"updated_at\": \"2020-04-23T15:10:14.000000Z\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./src/Http/Controllers/EntityController.php",
    "groupTitle": "Entity",
    "name": "PostApiEntityCaller_entity_idRelation"
  },
  {
    "type": "get",
    "url": "media/{entity_id}/{preset}[/{friendly}]",
    "title": "Gets a medium.",
    "description": "<p>Optimized using a preset if it is an image or the original one if not.</p>",
    "group": "Media",
    "parameter": {
      "fields": {
        "URL Parameters": [
          {
            "group": "URL Parameters",
            "optional": false,
            "field": "entity_id",
            "description": "<p>required, The id of the entity of type medium to get. Example: djr4sd7Gmd</p>"
          },
          {
            "group": "URL Parameters",
            "optional": false,
            "field": "preset",
            "description": "<p>required, A preset configured in config/media.php to process the image. Example: icon.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example Request (JavaScript):",
          "content": "const url = new URL(\n    \"http://127.0.0.1:8000/media/djr4sd7Gmd/icon.[/1]\"\n);\nlet headers = {\n    \"Content-Type\": \"application/json\",\n    \"Accept\": \"application/json\",\n};\nfetch(url, {\n    method: \"GET\",\n    headers: headers,\n})\n    .then(response => response.json())\n    .then(json => console.log(json));",
          "type": "json"
        },
        {
          "title": "Example Request (PHP):",
          "content": "$client = new \\GuzzleHttp\\Client();\n$response = $client->get(\n    'http://127.0.0.1:8000/media/djr4sd7Gmd/icon.[/1]',\n    [\n        'headers' => [\n            'Content-Type' => 'application/json',\n            'Accept' => 'application/json',\n        ],\n    ]\n);\n$body = $response->getBody();\nprint_r(json_decode((string) $body));",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Response (example):",
          "content": "null",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./src/Http/Controllers/MediaController.php",
    "groupTitle": "Media",
    "name": "GetMediaEntity_idPresetFriendly"
  },
  {
    "type": "post",
    "url": "api/medium/{entity_id}/upload",
    "title": "Uploads a medium.",
    "permission": [
      {
        "name": "Requires Authentication"
      }
    ],
    "group": "Media",
    "parameter": {
      "fields": {
        "URL Parameters": [
          {
            "group": "URL Parameters",
            "optional": true,
            "field": "entity_id",
            "description": "<p>The id of the entity to upload a medium or file</p>"
          }
        ],
        "Parameter": [
          {
            "group": "Parameter",
            "optional": false,
            "field": "file",
            "description": "<p>required, The file to be uploaded</p>"
          },
          {
            "group": "Parameter",
            "optional": true,
            "field": "thumb",
            "description": "<p>An optional file to represent the media, for example a thumb of a video</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "./src/Http/Controllers/MediaController.php",
    "groupTitle": "Media",
    "name": "PostApiMediumEntity_idUpload"
  },
  {
    "type": "get",
    "url": "api/user/me",
    "title": "Returns the current logged user.",
    "group": "User",
    "parameter": {
      "examples": [
        {
          "title": "Example Request (JavaScript):",
          "content": "const url = new URL(\n    \"http://127.0.0.1:8000/api/user/me\"\n);\nlet headers = {\n    \"Content-Type\": \"application/json\",\n    \"Accept\": \"application/json\",\n};\nfetch(url, {\n    method: \"GET\",\n    headers: headers,\n})\n    .then(response => response.json())\n    .then(json => console.log(json));",
          "type": "json"
        },
        {
          "title": "Example Request (PHP):",
          "content": "\n$client = new \\GuzzleHttp\\Client();\n$response = $client->get(\n    'http://127.0.0.1:8000/api/user/me',\n    [\n        'headers' => [\n            'Content-Type' => 'application/json',\n            'Accept' => 'application/json',\n        ],\n    ]\n);\n$body = $response->getBody();\nprint_r(json_decode((string) $body));",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Response (example): ",
          "content": "{\n    \"error\": \"Unauthorized\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./src/Http/Controllers/UserController.php",
    "groupTitle": "User",
    "name": "GetApiUserMe"
  },
  {
    "type": "post",
    "url": "api/user/login",
    "title": "Authenticate a user.",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>required</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>required</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Example Request (JavaScript):",
          "content": "const url = new URL(\n    \"http://127.0.0.1:8000/api/user/login\"\n);\nlet headers = {\n    \"Content-Type\": \"application/json\",\n    \"Accept\": \"application/json\",\n};\nlet body = {\n    \"email\": \"laudantium\",\n    \"password\": \"dignissimos\"\n}\nfetch(url, {\n    method: \"POST\",\n    headers: headers,\n    body: body\n})\n    .then(response => response.json())\n    .then(json => console.log(json));",
          "type": "json"
        },
        {
          "title": "Example Request (PHP):",
          "content": "$client = new \\GuzzleHttp\\Client();\n$response = $client->post(\n    'http://127.0.0.1:8000/api/user/login',\n    [\n        'headers' => [\n            'Content-Type' => 'application/json',\n            'Accept' => 'application/json',\n        ],\n        'json' => [\n            'email' => 'laudantium',\n            'password' => 'dignissimos',\n        ],\n    ]\n);\n$body = $response->getBody();\nprint_r(json_decode((string) $body));",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Response (example):",
          "content": "{\n    \"token\": \"JDJ5JDEwJEcwRlFrQmxEM04uQnNXMTNjWE5wME9QYncuZ2ZnUGZlQzJ3SUpsZFhIMUl6MXZ0TVprb2RD\",\n    \"user\": {\n        \"id\": \"8M1KRk1kLe\",\n        \"email\": \"admin@example.com\",\n        \"name\": \"Administrator\",\n        \"profile\": \"admin\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./src/Http/Controllers/UserController.php",
    "groupTitle": "User",
    "name": "PostApiUserLogin"
  },
  {
    "type": "get",
    "url": "{path:.*}",
    "title": "Locates an entity based on the url, and returns the HTML view of that entity as a webpage.",
    "group": "Web",
    "version": "0.0.0",
    "filename": "./src/Http/Controllers/WebController.php",
    "groupTitle": "Web",
    "name": "GetPath"
  }
] });

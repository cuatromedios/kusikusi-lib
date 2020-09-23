define({ "api": [
  {
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "varname1",
            "description": "<p>No type.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "varname2",
            "description": "<p>With type.</p>"
          }
        ]
      }
    },
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "./apidoc/main.js",
    "group": "/Users/david/Documents/kusikusi-submodules/kusikusi-lib/apidoc/main.js",
    "groupTitle": "/Users/david/Documents/kusikusi-submodules/kusikusi-lib/apidoc/main.js",
    "name": ""
  },
  {
    "type": "get",
    "url": "api/entities[/{model_name}]",
    "title": "Get a collection of  entities.",
    "permission": [
      {
        "name": "Requires Aurhorization"
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
        "name": "Requires Aurhorization"
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
      }
    },
    "version": "0.0.0",
    "filename": "./src/Http/Controllers/EntityController.php",
    "groupTitle": "Entity",
    "name": "GetApiEntityEntity_id"
  }
] });

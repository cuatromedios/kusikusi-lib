<?php

namespace  Kusikusi\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Kusikusi\Models\User;

class UserController extends Controller
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
     * @api {post} api/user/login Authenticate a user.
     * @apiGroup User
     * 
     * @apiParam {string} email required
     * @apiParam {string} password required
     * 
     * @apiParamExample Example Request (JavaScript):
     *   const url = new URL(
     *       "http://127.0.0.1:8000/api/user/login"
     *   );
     *   let headers = {
     *       "Content-Type": "application/json",
     *       "Accept": "application/json",
     *   };
     *   let body = {
     *       "email": "laudantium",
     *       "password": "dignissimos"
     *   }
     *   fetch(url, {
     *       method: "POST",
     *       headers: headers,
     *       body: body
     *   })
     *       .then(response => response.json())
     *       .then(json => console.log(json)); 
     * @apiParamExample Example Request (PHP):
     *   $client = new \GuzzleHttp\Client();
     *   $response = $client->post(
     *       'http://127.0.0.1:8000/api/user/login',
     *       [
     *           'headers' => [
     *               'Content-Type' => 'application/json',
     *               'Accept' => 'application/json',
     *           ],
     *           'json' => [
     *               'email' => 'laudantium',
     *               'password' => 'dignissimos',
     *           ],
     *       ]
     *   );
     *   $body = $response->getBody();
     *   print_r(json_decode((string) $body)); 
     * @apiSuccessExample {json} Response (example):
     *   {
     *       "token": "JDJ5JDEwJEcwRlFrQmxEM04uQnNXMTNjWE5wME9QYncuZ2ZnUGZlQzJ3SUpsZFhIMUl6MXZ0TVprb2RD",
     *       "user": {
     *           "id": "8M1KRk1kLe",
     *           "email": "admin@example.com",
     *           "name": "Administrator",
     *           "profile": "admin"
     *       }
     *   }
     */
    public function authenticate(Request $request)
    {
        $this->validate($request, [
            "email" => "required|string",
            "password" => "required|string"
        ], Config::get('validation.messages'));
        $authResult = User::authenticate($request->input('email'), $request->input('password'), $request->ip(), true);
        if ($authResult !== FALSE) {
            return $authResult;
        } else {
            return response()->json(['error' => 'Unauthorized'], 401 );
        }
    }

    /**
     * @api {get} api/user/me Returns the current logged user.
     * @apiGroup User
     * 
     * @apiParamExample Example Request (JavaScript):
     *   const url = new URL(
     *       "http://127.0.0.1:8000/api/user/me"
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
     *
     *   $client = new \GuzzleHttp\Client();
     *   $response = $client->get(
     *       'http://127.0.0.1:8000/api/user/me',
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
     *       "error": "Unauthorized"
     *   }
     */
    public function showMe()
    {
        $user = User::find(Auth::user()->id);
        return $user;
    }

    /**
     * Display the permissions for the given entity.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function getPermissions($id)
    {
        try {
            if (\Auth::user()['profile'] == 'admin') {
                $permissionResult = Permission::getPermissions($id);
                Activity::add(\Auth::user()['id'], $id, AuthServiceProvider::READ_ENTITY, TRUE, 'getPermissions', "{}");
                return (new ApiResponse($permissionResult, TRUE))->response();
            } else {
                Activity::add(\Auth::user()['id'], $id, AuthServiceProvider::READ_ENTITY, FALSE, 'getPermissions', json_encode(["error" => ApiResponse::TEXT_FORBIDDEN]));
                return (new ApiResponse(NULL, FALSE, ApiResponse::TEXT_FORBIDDEN, ApiResponse::STATUS_FORBIDDEN))->response();
            }
        } catch (\Exception $e) {
            $exceptionDetails = ExceptionDetails::filter($e);
            Activity::add(\Auth::user()['id'], $id, AuthServiceProvider::READ_ENTITY, FALSE, 'getPermissions', json_encode(["error" => $exceptionDetails['info']]));
            return (new ApiResponse(NULL, FALSE, $exceptionDetails['info'], $exceptionDetails['info']['code']))->response();
        }
    }
}

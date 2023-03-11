<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Exception;
use Session;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

// Helper
use App\Helpers\CommonFunction;

// Model
use App\Models\Users;

class AuthController extends Controller {

    protected $controller;

    public function __construct(Controller $controller) {
        $this->controller = $controller;
    }

    public function userLogin(Request $request) {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                                'email'     => 'required|email|max:60',
                                'password'  => 'required|max:30',
                            ]);

            if ($validator->fails()) {
                $response = [
                    'status'        => false,
                    'status_code'   => 201,
                    'message'       => $validator->messages()->first(),
                    'data'          => [],
                    'request_data'  => $request->all()
                ];
                return $this->controller->sendResponse($response);
            }
            else{

                    $email = $request->input('email');
                    $password = $request->input('password');


                    $userdata = Users::where('email', $email)->first();


                    if($userdata)
                    {
                        if(Hash::check($password, $userdata->password)){
                        $response = [
                                    'status'        => true,
                                    'status_code'   => 200,
                                    'message'       => "you are logged in",
                                    'data'          => [
                                        "userdata"  => $userdata,
                                        "token"     => "TOEKN_1234"
                                    ],
                                    'request_data'  => $request->all()
                                ];
                                return $this->controller->sendResponse($response);

                    } else {
                        $response = [
                                        'status'        => true,
                                        'status_code'   => 200,
                                        'message'       => "wrong credentials",
                                        'data'          => [],
                                        'request_data'  => $request->all()
                                    ];
                                    return $this->controller->sendResponse($response);
                    }
                }
                else{
                    $response = [
                        'status'        => true,
                        'status_code'   => 200,
                        'message'       => "You are not registered",
                        'data'          => [],
                        'request_data'  => $request->all()
                    ];
                    return $this->controller->sendResponse($response);
                }
                }
        } catch (Exception $ex) {
            $response = [
                'status'        => false,
                'status_code'   => 201,
                'message'       => $ex->getMessage(),
                'data'          => [],
                'request_data'  => $request->all()
            ];
            return $this->controller->sendResponse($response);
        }
    }

    public function userRegister(Request $request) {
        try {
            $customMessage = [
                'email.required' => 'Email is required.',
                'password.required' => 'password is required'
            ];
            /* data validation */
            $validator = Validator::make($request->all(), [
                                'first_name'    => 'required|string|max:60',
                                'last_name'     => 'required|string|max:60',
                                'email'         => 'required|email|unique:users,email|max:60',
                                'password'      => 'required|min:6|max:20'
                            ], $customMessage);

            if ($validator->fails()) :
                $response = [
                    'status'        => false,
                    'status_code'   => 201,
                    'message'       => $validator->messages()->first(),
                    'data'          => [],
                    'request_data'  => $request->all()
                ];
                return $this->controller->sendResponse($response);
            else:
                $users = new Users;
                $users->first_name = $request->first_name;
                $users->last_name = $request->last_name;
                $users->email    = strtolower($request->input('email'));
                $users->password = Hash::make($request->password);

                $users->save();

                $response = [
                    'status'        => true,
                    'status_code'   => 200,
                    'message'       => "Successfully register.",
                    'data'          => ["user_id" =>  $users->id
                                          ],
                    'request_data'  => $request->all()
                ];

            endif;
            return $this->controller->sendResponse($response);
        } catch (Exception $ex) {
            $response = [
                'status'        => false,
                'status_code'   => 201,
                'message'       => $ex->getMessage(),
                'data'          => [],
                'request_data'  => $request->all()
            ];
            return $this->controller->sendResponse($response);
        }
    }


}

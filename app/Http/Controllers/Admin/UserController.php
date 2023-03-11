<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Encryption\DecryptException;
use Exception;
use Session;
use Carbon\Carbon;

// Helper
use App\Helpers\CommonFunction;

// Model
use App\Models\User;
use App\Models\Status;
use App\Models\UserRoles;
use App\Models\Produce;

class UserController extends Controller {

    private $responceData = [];

    public function __construct() {
        $this->responceData['searchKeyword'] = "";
    }
    
    public function userList(Request $request) {
        try {
            $query = User::with([
                                'getRoles',
                                'getStatus'
                            ])
                            ->where('id', '!=', Auth::guard('admin')->user()->id)
                            ->where('id', '!=', 2);

            // for search
            if(isset($request->search_keyword)):
                $keyword = $request->search_keyword;
                $query = $query->where('tags', 'LIKE', "%$keyword%");
                $this->responceData['searchKeyword'] = $request->search_keyword;
            endif;

            $this->responceData['listData'] = $query->orderBy('id', 'desc')->paginate(env('PAGINATE'));
            
            return view('admin.user-management.list', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/admin/dashboard');
        }
    }

    public function userCreate(Request $request) {
        try {
            $this->responceData['userRoles'] = UserRoles::where('status', 1)->get();
            $this->responceData['statusList'] = Status::get();

            return view('admin.user-management.add', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/admin/dashboard');
        }
    }

    public function userCreateProcess(Request $request) {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                                'first_name'    => 'required|string|max:60',
                                'last_name'     => 'required|string|max:60',
                                'email'         => 'required|email|unique:tk_users,email|max:60',
                                'phone'         => 'required|numeric|unique:tk_users,phone',
                                'user_type'     => 'required|integer|exists:tk_user_roles,id',
                                'status'        => 'required|integer|exists:tk_status,status_code',
                                'password'      => 'required|confirmed|min:6|max:20',
                            ]);

            if ($validator->fails()) :
                return redirect()->back()->withErrors($validator)->withInput();
            else:
                $user = new User;
                $user->first_name   = ucfirst(strtolower($request->first_name));
                $user->last_name    = ucfirst(strtolower($request->last_name));
                $user->email        = strtolower($request->email);
                $user->phone        = $request->phone;


                // create slug
                $slug = CommonFunction::createSlug($request->first_name . ' ' . $request->last_name . CommonFunction::generateRandomNumber(20));
                $user->slug = $slug;

                $user->user_type    = $request->user_type;
                $user->status       = $request->status;
                $user->password     = Hash::make($request->password);
                $user->save();

                // updating slug
                $slug = CommonFunction::createSlug($request->first_name . ' ' . $request->last_name);
                $userExists = User::where('slug', $slug)
                                ->where('id', '!=', $user->id)
                                ->exists();
                $slug = $userExists ? $slug . '-' . $user->id : $slug;
                User::where('id', $user->id)
                    ->update([
                        "slug" => $slug
                    ]);

                $request->session()->flash('success', 'Successfully created.');
                return redirect('admin/user-management');
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/admin/dashboard');
        }
    }

    public function userEdit($slug, Request $request) {
        try {
            $this->responceData['userRoles'] = UserRoles::where('status', 1)->get();

            $exists = User::whereNotIn('id', [1, 2])
                        ->where('slug', $slug)
                        ->exists();

            if($exists):
                $this->responceData['user'] = User::with([
                                                        'getRoles',
                                                        'getStatus'
                                                    ])
                                                    ->where('id', '!=', Auth::guard('admin')->user()->id)
                                                    ->where('slug', $slug)
                                                    ->first();
                $this->responceData['statusList'] = Status::get();
            
                return view('admin.user-management.edit', $this->responceData);
            else:
                $request->session()->flash('error', 'Invalid request.');
                return redirect('admin/user-management');
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/admin/dashboard');
        }
    }

    public function userEditProcess(Request $request) {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                                'slug'          => 'required|exists:tk_users,slug|max:60',
                                'first_name'    => 'required|string|max:60',
                                'last_name'     => 'required|string|max:60',
                                'user_type'     => 'required|integer|exists:tk_user_roles,id',
                                'status'        => 'required|integer|exists:tk_status,status_code',
                            ]);

            if ($validator->fails()) :
                return redirect()->back()->withErrors($validator)->withInput();
            else:
                $user = User::where('slug', $request->slug)->first();

                $user->first_name   = ucfirst(strtolower($request->first_name));
                $user->last_name    = ucfirst(strtolower($request->last_name));

                // create slug
                $slug = CommonFunction::createSlug($request->first_name . ' ' . $request->last_name . CommonFunction::generateRandomNumber(20));
                $user->slug = $slug;

                $user->user_type    = $request->user_type;
                $user->status       = $request->status;
                $user->password     = Hash::make($request->password);
                $user->save();

                // updating slug
                $slug = CommonFunction::createSlug($request->first_name . ' ' . $request->last_name);
                $userExists = User::where('slug', $slug)
                                ->where('id', '!=', $user->id)
                                ->exists();
                $slug = $userExists ? $slug . '-' . $user->id : $slug;
                User::where('id', $user->id)
                    ->update([
                        "slug" => $slug
                    ]);

                $request->session()->flash('success', 'Successfully updated.');
                return redirect('admin/user-management');
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/admin/dashboard');
        }
    }

    public function userDelete($slug, Request $request) {
        try {
            $user =User::Where('slug',$slug)->first();
            $produce=Produce::Where('created_by',$user->id)->first();

            if ($produce)
            {
                $request->session()->flash('error', 'User Cannot be deleted, this user has assigned Produce. Please remove all the produces and try again.');
                return redirect()->back();
            }
            else
            {
                $user->delete();
                $request->session()->flash('success', 'User successfully deleted.');
                return redirect()->back();
            }
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/dashboard');
        }
    }
    
    public function userChangeStatus($slug, Request $request) {
        try {
            $user = User::whereNotIn('id', [1, 2, 3, 4, 5, 6])
                        ->where('slug', $slug)
                        ->first();

            if($user != null):
                $user->status = !$user->status;
                $user->save();

                $request->session()->flash('success', 'Successfully updated.');
                return redirect()->back();
            else:
                $request->session()->flash('error', 'Invalid request.');
                return redirect('admin/user-management');
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/dashboard');
        }
    }
    
}

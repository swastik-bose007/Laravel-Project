<?php

namespace App\Http\Controllers\Bazarmandi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Encryption\DecryptException;
use DateTime;
use Exception;
use Session;
use Carbon\Carbon;

use Mail;
use App\Mail\Admin\ForgotPassword;

// Helper
use App\Helpers\CommonFunction;

// Model
use App\Models\User;

class AuthController extends Controller {

    private $responceData = [];

    public function __construct() {
    }

    public function login(Request $request) {
        try {
            return view('bazarmandi.auth.login', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/');
        }
    }
    
    public function loginProcess(Request $request) {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                        'email'     => 'required|email|max:60',
                        'password'  => 'required|max:30',
            ]);

            if ($validator->fails()) :
                return redirect()->back()->withErrors($validator)->withInput();
            else :
                /* request data collection */
                $email = $request->input('email');
                $password = $request->input('password');

                $userExists = User::where('email', $email)->where('status', 1)->exists();

                if ($userExists == 0):
                    $request->session()->flash('warning', 'Invalid email or Password.');
                    return redirect('bazarmandi/login')->withInput();
                else:
                    $user = User::where('email', $email)->first();
                    
                    /* login porocess */
                    if (Auth::guard('bazarmandi')->attempt(['email' => $email, 'password' => $password, 'status' => 1, 'user_type' => 7])) :
                        $request->session()->flash('success', 'Welcome ' . Auth::guard('bazarmandi')->user()->first_name . ' ' . Auth::guard('bazarmandi')->user()->last_name . '.');
                        return redirect('bazarmandi/dashboard');
                    else:
                        $request->session()->flash('error', 'Email or Password is not valid.');
                        return redirect('bazarmandi/login')->withInput();
                    endif;
                endif;
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect()->back();
        }
    }
    
    public function forgotPassword(Request $request) {
        try {
            return view('bazarmandi.auth.forgot-password', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/bazarmandi');
        }
    }
    
    public function forgotPasswordProcess(Request $request) {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                        'email'     => 'required|email|max:60'
            ]);

            if ($validator->fails()) :
                return redirect()->back()->withErrors($validator)->withInput();
            else:
                $email = $request->input('email');

                $count = User::where('email', $email)->where('status', 1)->count();
                if ($count == 0):
                    $request->session()->flash('error', 'Invalid request.');
                    return redirect('bazarmandi/forgot-password');
                else:
                    Mail::to($request->email)->send(new ForgotPassword());
                    $request->session()->flash('success', 'Reset link sent to your email address.');
                    return redirect('bazarmandi/login');
                endif;
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/');
        }
    }
    
    public function logout(Request $request) {
        try {
            Auth::guard('bazarmandi')->logout();
            
            $request->session()->flash('success', 'Successfully Logout.');
            return redirect('bazarmandi/login');
        } catch (Exception $ex) {
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/bazarmandi');
        }
    }
    
    public function register(Request $request) {
        try {
            return view('bazarmandi.auth.register', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/bazarmandi');
        }
    }
    
    public function registerProcess(Request $request) {
        $str=$request->bazar_mandi_name;
        $arr=explode(" ", $str,2);
        $countarr= count($arr);
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                            'bazar_mandi_name'    => 'required|string|max:20|min:2',
                            'bazar_mandi_type' => 'required|string',
                            'registered_store_attendant_first_name' => 'required|string|max:40|min:2',
                            'registered_store_attendant_first_name' => 'required|string|max:40|min:2',
                            'registered_store_attendant_adhar_no' => 'required|string|max:12|min:12|unique:tk_users,registered_store_attendant_adhar_no',
                            'registered_store_attendant_phone' => 'required|numeric|unique:tk_users,registered_store_attendant_phone',
                            'area'          => 'required|string|max:20',
                            'district'      => 'required|string|max:20',
                            'pincode'       => 'required|string|max:6|min:6',
                            'email'         => 'required|email|unique:tk_users,email|max:60',
                            'password'      => 'required|confirmed|min:6|max:18'
                        ]);

            if ($validator->fails()) :
                return redirect()->back()->withErrors($validator)->withInput();
            else :
                //For storing Name
                $user = new User;
                    switch ($countarr){
                        case 1:
                            $user->first_name       = ucfirst(strtolower($arr[0]));
                            $user->last_name        = 'Bazar Mandi';
                        break;

                        case 2:
                            $user->first_name       = ucfirst(strtolower($arr[0]));
                            $user->last_name        = ucfirst(strtolower($arr[1]));
                        break;

                        default:
                            return redirect()->back()->withErrors($validator)->withInput();
                }
                //For storing Bazar Mandi Name
                switch ($countarr){
                        case 1:
                            $user->bazar_mandi_name = ucfirst(strtolower($user->first_name))." "."Bazar Mandi";
                        break;

                        case 2:
                            $user->bazar_mandi_name = ucfirst(strtolower($user->first_name))." ".ucfirst(strtolower($user->last_name));
                        break;

                        default:
                            return redirect()->back()->withErrors($validator)->withInput();
                }
                $user->bazar_mandi_type = $request->bazar_mandi_type;
                $user->registered_store_attendant_first_name = $request->registered_store_attendant_first_name;
                $user->registered_store_attendant_last_name = $request->registered_store_attendant_last_name;
                $user->registered_store_attendant_adhar_no = $request->registered_store_attendant_adhar_no;
                $user->registered_store_attendant_phone = $request->registered_store_attendant_phone;
                $user->area             = $request->area;
                $user->district         = $request->district;
                $user->pincode          = $request->pincode;
                $user->email            = strtolower($request->email);
                $user->password         = Hash::make($request->password);
                $user->slug             = CommonFunction::createSlug($request->first_name . ' ' . CommonFunction::generateRandomNumber(20));
                $user->user_type        = 7;
                $user->status           = 1;

                 // update search tag
                switch ($countarr){
                        case 1:
                        $user->tags   = strtolower($user->first_name) . ',' . strtolower($user->last_name) . ',' . strtolower($request->email).','. $request->registered_store_attendant_phone.','. strtolower($user->first_name).' '.strtolower($user->last_name);
                        break;

                        case 2:
                        $user->tags   = strtolower($user->first_name) . ',' . strtolower($user->last_name) . ',' . strtolower($request->email).','. $request->registered_store_attendant_phone.','. strtolower($user->first_name).' '.strtolower($user->last_name);
                        break;

                        default:
                            return redirect()->back()->withErrors($validator)->withInput();
                }
                $user->save();

                // create slug
                $slug = CommonFunction::createSlug($request->first_name . $request->last_name);
                $count = User::where('slug', $slug)->where('id', '!=', $user->id)->count();
                $slug = ($count > 0) ? $slug . '-' . $user->id : $slug;
                User::where('id', $user->id)->update([
                    'slug' => $slug
                ]);

                $request->session()->flash('success', 'Successfully Register.');
            return redirect('bazarmandi/login');
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
    
}

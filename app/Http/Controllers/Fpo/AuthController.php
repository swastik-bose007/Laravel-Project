<?php

namespace App\Http\Controllers\Fpo;

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
            return view('fpo.auth.login', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/fpo');
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
                    return redirect('fpo/login')->withInput();
                else:
                    $user = User::where('email', $email)->first();
                    
                    /* login porocess */
                    if (Auth::guard('fpo')->attempt(['email' => $email, 'password' => $password, 'status' => 1, 'user_type' => 4])) :
                        $request->session()->flash('success', 'Welcome ' . Auth::guard('fpo')->user()->first_name . ' ' . Auth::guard('fpo')->user()->last_name . '.');
                        return redirect('fpo/dashboard');
                    else:
                        $request->session()->flash('error', 'Email or Password is not valid.');
                        return redirect('fpo/login')->withInput();
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
            return view('fpo.auth.forgot-password', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/');
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
                    return redirect('fpo/forgot-password');
                else:
                    Mail::to($request->email)->send(new ForgotPassword());
                    $request->session()->flash('success', 'Reset link sent to your email address.');
                    return redirect('fpo/login');
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
            Auth::guard('fpo')->logout();
            
            $request->session()->flash('success', 'Successfully Logout.');
            return redirect('fpo/login');
        } catch (Exception $ex) {
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/');
        }
    }
    
    public function register(Request $request) {
        try {
            return view('fpo.auth.register', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/fpo');
        }
    }
    
    public function registerProcess(Request $request) {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                            'first_name'    => 'required|string|max:20|min:2',
                            'last_name'     => 'required|string|max:20|min:2',
                            'cin_no'      => 'required|string|max:21|min:21|unique:tk_users,cin_no',
                            'pan_no'        => 'required|string|max:10|min:10|unique:tk_users,pan_no',
                            'registration_no' => 'required|string|max:21|min:21|unique:tk_users,registration_no',
                            'area'          => 'required|string|max:20',
                            'district'      => 'required|string|max:20',
                            'pincode'       => 'required|string|max:6|min:6',
                            'phone_no'      => 'required|numeric|unique:tk_users,phone',
                            'email'         => 'required|email|unique:tk_users,email|max:60',
                            'password'      => 'required|confirmed|min:6|max:18'
                        ]);

            if ($validator->fails()) :
                return redirect()->back()->withErrors($validator)->withInput();
            else :
                $user = new User;
                $user->first_name       = ucfirst(strtolower($request->first_name));
                $user->last_name        = ucfirst(strtolower($request->last_name));
                $user->cin_no           = $request->cin_no;
                $user->pan_no           = $request->pan_no;
                $user->registration_no  = $request->registration_no;
                $user->area             = $request->area;
                $user->district         = $request->district;
                $user->pincode          = $request->pincode;
                $user->phone            = $request->phone_no;
                $user->email            = strtolower($request->email);
                $user->password         = Hash::make($request->password);
                $user->slug             = CommonFunction::createSlug($request->first_name . ' ' . CommonFunction::generateRandomNumber(20));
                $user->user_type        = 4;
                $user->status           = 1;

                 // update search tag
                $user->tags   = strtolower($request->first_name . ',' . strtolower($request->last_name) . ',' . strtolower($request->email).','. $request->phone_no.','. strtolower($request->first_name).' '.strtolower($request->last_name));

                $user->save();

                // create slug
                $slug = CommonFunction::createSlug($request->first_name . $request->last_name);
                $count = User::where('slug', $slug)->where('id', '!=', $user->id)->count();
                $slug = ($count > 0) ? $slug . '-' . $user->id : $slug;
                User::where('id', $user->id)->update([
                    'slug' => $slug
                ]);

                $request->session()->flash('success', 'Successfully Register.');
            return redirect('fpo/login');
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
    
}

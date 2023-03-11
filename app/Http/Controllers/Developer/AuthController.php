<?php

namespace App\Http\Controllers\Developer;

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
            return view('developer.auth.login', $this->responceData);
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

                $count = User::where('email', $email)->where('status', 1)->count();
                if ($count == 0):
                    $request->session()->flash('warning', 'Invalid email or Password.');
                    return redirect('developer/login')->withInput();
                else:
                    $user = User::where('email', $email)->first();
                    
                    /* login porocess */
                    if (Auth::guard('developer')->attempt(['email' => $email, 'password' => $password, 'status' => 1])) :
                        $request->session()->flash('success', 'Welcome ' . Auth::guard('admin')->user()->first_name . ' ' . Auth::guard('admin')->user()->last_name . '.');
                        return redirect('developer/dashboard');
                    else:
                        $request->session()->flash('error', 'Email or Password is not valid.');
                        return redirect('developer/login')->withInput();
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
            return view('developer.auth.forgot-password', $this->responceData);
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

                $count = TBUser::where('email', $email)->where('status', 1)->count();
                if ($count == 0):
                    $request->session()->flash('error', 'Invalid request.');
                    return redirect('developer/forgot-password');
                else:
                    Mail::to($request->email)->send(new ForgotPassword());
                    $request->session()->flash('success', 'Reset link sent to your email address.');
                    return redirect('developer/login');
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
            Auth::guard('developer')->logout();
            
            $request->session()->flash('success', 'Successfully Logout.');
            return redirect('developer/login');
        } catch (Exception $ex) {
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/');
        }
    }
    
    public function register(Request $request) {
        try {
            return view('developer.auth.login', $this->responceData);
        } catch (Exception $ex) {
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/');
        }
    }
    
}

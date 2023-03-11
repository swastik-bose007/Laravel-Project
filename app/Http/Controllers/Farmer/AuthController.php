<?php

namespace App\Http\Controllers\Farmer;

use App\Helpers\CommonFunction;
use App\Http\Controllers\Controller;
use App\Mail\Admin\ForgotPassword;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;


// Model
use Session;

class AuthController extends Controller
{

    private $responceData = [];

    public function __construct()
    {
    }

    public function login(Request $request)
    {
        try {
            return view('farmer.auth.login', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/farmer');
        }
    }

    public function loginProcess(Request $request)
    {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:60',
                'password' => 'required|max:30',
            ]);

            if ($validator->fails()):
                return redirect()->back()->withErrors($validator)->withInput();
            else:
                /* request data collection */
                $email = $request->input('email');
                $password = $request->input('password');

                $userExists = User::where('email', $email)->where('status', 1)->exists();

                if ($userExists == 0):
                    $request->session()->flash('warning', 'Invalid email or Password.');
                    return redirect('farmer/login')->withInput();
                else:
                    $user = User::where('email', $email)->first();

                    /* login porocess */
                    if (Auth::guard('farmer')->attempt(['email' => $email, 'password' => $password, 'status' => 1, 'user_type' => 3])):
                        $request->session()->flash('success', 'Welcome ' . Auth::guard('farmer')->user()->first_name . ' ' . Auth::guard('admin')->user()->last_name . '.');
                        return redirect('farmer/dashboard');
                    else:
                        $request->session()->flash('error', 'Email or Password is not valid.');
                        return redirect('farmer/login')->withInput();
                    endif;
                endif;
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect()->back();
        }
    }

    public function forgotPassword(Request $request)
    {
        try {
            return view('farmer.auth.forgot-password', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/farmer');
        }
    }

    public function forgotPasswordProcess(Request $request)
    {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:60',
            ]);

            if ($validator->fails()):
                return redirect()->back()->withErrors($validator)->withInput();
            else:
                $email = $request->input('email');

                $count = User::where('email', $email)->where('status', 1)->count();
                if ($count == 0):
                    $request->session()->flash('error', 'Invalid request.');
                    return redirect('farmer/forgot-password');
                else:
                    Mail::to($request->email)->send(new ForgotPassword());
                    $request->session()->flash('success', 'Reset link sent to your email address.');
                    return redirect('farmer/login');
                endif;
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/');
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::guard('farmer')->logout();

            $request->session()->flash('success', 'Successfully Logout.');
            return redirect('farmer/login');
        } catch (Exception $ex) {
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/farmer');
        }
    }

    public function register(Request $request)
    {
        try {
            return view('farmer.auth.register', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/farmer');
        }
    }

    public function registerProcess(Request $request)
    {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:20|min:2',
                'last_name' => 'required|string|max:20|min:2',
                'adhar_no' => 'required|string|max:12|min:12|unique:tk_users,adhar_no',
                'pan_no' => 'required|string|max:10|min:10|unique:tk_users,pan_no',
                'area' => 'required|string|max:20',
                'district' => 'required|string|max:20',
                'pincode' => 'required|string|max:6|min:6',
                'phone_no' => 'required|numeric|unique:tk_users,phone',
                'email' => 'required|email|unique:tk_users,email|max:60',
                'password' => 'required|confirmed|min:6|max:18',
            ]);

            if ($validator->fails()):
                return redirect()->back()->withErrors($validator)->withInput();
            else:
                $user = new User;
                $user->first_name = ucfirst(strtolower($request->first_name));
                $user->last_name = ucfirst(strtolower($request->last_name));
                $user->adhar_no = $request->adhar_no;
                $user->pan_no = $request->pan_no;
                $user->area = $request->area;
                $user->district = $request->district;
                $user->pincode = $request->pincode;
                $user->phone = $request->phone_no;
                $user->email = strtolower($request->email);
                $user->password = Hash::make($request->password);
                $user->slug = CommonFunction::createSlug($request->first_name . ' ' . CommonFunction::generateRandomNumber(20));
                $user->user_type = 3;
                $user->status = 1;

                // update search tag
                $user->tags = strtolower($request->first_name) . ',' . strtolower($request->last_name) . ',' . strtolower($request->email).','. $request->phone_no.','. strtolower($request->first_name).' '.strtolower($request->last_name);

                $user->save();

                // create slug
                $slug = CommonFunction::createSlug($request->first_name . $request->last_name);
                $count = User::where('slug', $slug)->where('id', '!=', $user->id)->count();
                $slug = ($count > 0) ? $slug . '-' . $user->id : $slug;
                User::where('id', $user->id)->update([
                    'slug' => $slug,
                ]);
                
                $request->session()->flash('success', 'Successfully Register.');
                return redirect('farmer/login');
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

}

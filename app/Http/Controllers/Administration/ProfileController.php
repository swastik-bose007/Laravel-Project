<?php

namespace App\Http\Controllers\Administration;

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
use App\Models\Produce;
use App\Models\ProfileImage;

class ProfileController extends Controller {

    private $responceData = [];

    public function __construct() {
    }
    
    public function index(Request $request) {
        $this->responceData['produceCount'] = Produce::where('created_by', Auth::guard('administration')->user()->id)->count();

        return view('administration.profile.edit', $this->responceData);
    }

    public function profileUpdate(Request $request) {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                            'first_name'    => 'required|string|max:20|min:2',
                            'last_name'     => 'required|string|max:20|min:2',
                            'phone_no'      => 'required|numeric'
                        ]);

            if ($validator->fails()) :
                return redirect()->back()->withErrors($validator)->withInput();
            else :
                $phoneNumberExsist = User::where('id', '!=', Auth::guard('administration')->user()->id)
                    ->where('phone', $request->phone_no)
                    ->exists();
                if($phoneNumberExsist):
                    $request->session()->flash('error', 'Phone number already used.');
                    return redirect()->back();
                else:
                    $user = Auth::guard('administration')->user();
                    $user->first_name       = ucfirst(strtolower($request->first_name));
                    $user->last_name        = ucfirst(strtolower($request->last_name));
                    $user->phone            = $request->phone_no;
                    $user->slug             = CommonFunction::createSlug($request->first_name . ' ' . CommonFunction::generateRandomNumber(20));
                    
                     // update search tag
                    $user->tags   = strtolower($request->first_name . ', ' . $request->last_name . ', ' . $request->email);

                    $user->save();

                    // create slug
                    $slug = CommonFunction::createSlug($request->first_name . $request->last_name);
                    $count = User::where('slug', $slug)->where('id', '!=', $user->id)->count();
                    $slug = ($count > 0) ? $slug . '-' . $user->id : $slug;
                    User::where('id', $user->id)->update([
                        'slug' => $slug
                    ]);

                    $request->session()->flash('success', 'Successfully Updated.');
                    return redirect()->back();
                endif;
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function changePassword(Request $request) {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                            'current_password'  => 'required|min:6|max:18',
                            'password'          => 'required|confirmed|min:6|max:18'
                        ]);

            if ($validator->fails()) :
                return redirect()->back()->withErrors($validator)->withInput();
            else :
                if (!(Hash::check($request->current_password, Auth::guard('administration')->user()->password))) :
                    // The passwords matches
                    $request->session()->flash('error', "Your current password does not matches with the password.");
                    return redirect()->back();
                endif;


                if(strcmp($request->current_password, $request->password) == 0){
                    // Current password and new password same
                    $request->session()->flash('error', "New Password cannot be same as your current password.");
                    return redirect()->back();
                }

                //Change Password
                $user = Auth::guard('administration')->user();
                $user->password = Hash::make($request->password);
                $user->save();

                $request->session()->flash('success', 'Password change successfully.');
                return redirect()->back();
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
    
    public function profileImageUpdate($slug,Request $request) {
        try {

            $this->responceData['userId']= $slug;
            $this->responceData['profileImage']= ProfileImage::where('user_id', Auth::guard('administration')->user()->id)->get();

            return view('administration.profile.profile-image-add', $this->responceData);
            
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function profileImageUpdateProcess(Request $request) {
        try {

            //Storing Photos
                if ($request->hasfile('add_photo'))
                    {
                    $file=$request->add_photo;
                    $profileImage=new ProfileImage;
                    $randomNumber = random_int(100000, 999999);
                    $extension=$file->getClientOriginalExtension();
                    $filename=time().'-image-'.$randomNumber.'.'.$extension;
                    $path='public/upload/profile';
                    $file->move('public/upload/profile', $filename);
                    $profileImage->user_id    = $request->userId;;
                    $profileImage->profile_image_url  = $path.'/'.$filename;
                    $profileImage->save();
                    }
                else
                    {
                    $request->session()->flash('error', 'No File Found');
                    return redirect()->back();
                    }

            $request->session()->flash('success', 'Successfully Updated.');
                    return redirect()->back();

        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect()->back();
        }
    }

    public function setProfilePicture($slug, Request $request) {
        try {
            $user=User::where('id', Auth::guard('administration')->user()->id)->get();
            $profileImage=ProfileImage::where('id',$slug)->get();

            $user[0]->profile_picture_url = $profileImage[0]->profile_image_url;
            $user[0]->save();

            $request->session()->flash('success', 'Successfully Updated.');
                    return redirect('administration/profile');
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect()->back();
        }
    }
    public function setDemoProfilePicture(Request $request) {
        try {
            $user=User::where('id', Auth::guard('administration')->user()->id)->get();

            $user[0]->profile_picture_url = "public/upload/profile/demo-user.jpg";
            $user[0]->save();

            $request->session()->flash('success', 'Successfully Updated.');
                    return redirect('administration/profile');
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect()->back();
        }
    }

     public function deleteProfilePicture($id,Request $request) {

        $image=ProfileImage::where('id',$id)->get();
        $user=User::where('id', Auth::guard('administration')->user()->id)->get();
        $profilePicture=User::where('id', Auth::guard('administration')->user()->id)->get("profile_picture_url");


        $imageExists=count(ProfileImage::where('user_id',Auth::guard('administration')->user()->id)->get());


        if($profilePicture[0]->profile_picture_url == $image[0]->profile_image_url)

            {
            $image[0]->delete();

            $user[0]->profile_picture_url = "public/upload/profile/demo-user.jpg";
            $user[0]->save();

            $request->session()->flash('success', 'Image successfully deleted.');
                    return redirect()->back();
            }
        else
        {
        if($imageExists != 1)
        {
            if($image){
                $image[0]->delete();
                $request->session()->flash('success', 'Image successfully deleted.');
                    return redirect()->back();
                }
            else
                {
                    $request->session()->flash('error', 'Invalid request.');
                    return redirect()->back();
                }
        }
        else
        {
            $image[0]->delete();

            $user[0]->profile_picture_url = "public/upload/profile/demo-user.jpg";
            $user[0]->save();

            $request->session()->flash('success', 'Image successfully deleted.');
                    return redirect()->back();
        }
        }
        
    }
}

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
use App\Models\Category;
use App\Models\Image;
use App\Models\MediaLibrary;
class MediaController extends Controller {

    private $responceData = [];

    public function __construct() {
    }
    
    public function mediaLibraryList(Request $request) {
        try {
            $this->responceData['mediaList'] = MediaLibrary::where('created_by',Auth::guard('admin')->user()->id)
                                                ->orderBy('id', 'desc')
                                                ->paginate(env('PAGINATE'));
            $this->responceData['userId'] =User::where('id',Auth::guard('admin')->user()->id)->get('id');

            return view('admin.media.list', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/dashboard');
        }
    }

    public function mediaLibraryCreate($slug, Request $request) {
        try {

            $this->responceData['userId']=$slug;

            return view('admin.media.add', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/media/');
        }
    }

    public function mediaLibraryCreateProcess(Request $request) {
        try {
               $MediaLibrary = new MediaLibrary;
                    //Storing Files
                    if ($request->hasfile('add_files')) {
                    
                        foreach($request->file('add_files') as $key=>$file)
                        {
                        $randomNumber = random_int(100000, 999999);
                        $extension=$file->getClientOriginalExtension();

                            if($extension ==='mp4'||$extension === 'mov'||$extension ==='wmv'||$extension ==='avi'||$extension ==='webm'||$extension ==='mkv'||$extension ==='jpg'||$extension ==='jpeg'||$extension ==='png'||$extension ==='gif')
                            {
                            $filename=time().'-file-'.$randomNumber.'.'.$extension;
                            $path='public/upload/gallary';
                            $file->move('public/upload/gallary', $filename);
                            $insert[$key]['created_by']    = $request->userId;
                            $insert[$key]['type']          = $extension;
                            $insert[$key]['media_url']     = $path.'/'.$filename;
                            }
                            else
                            {
                                $request->session()->flash('error', '.'.$extension.' extension not accepted');
                            return redirect('admin/media/create/'.$request->userId);
                            }                            
                            }
                            MediaLibrary::insert($insert);
                            $request->session()->flash('success', 'Successfully created.');
                            return redirect('admin/media/');
                            }
                    else
                    {
                       $request->session()->flash('error', 'Please select atleast one file to continue');
                        return redirect('admin/media/create/'.$request->userId); 
                    }
         } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/media');
        }
    }


    public function mediaLibraryDelete($slug, Request $request) {
        try {
            $deleteFlag = MediaLibrary::where('id', $slug)->delete();

            if($deleteFlag != null):
                $request->session()->flash('success', 'Successfully deleted.');
                return redirect()->back();
            else:
                $request->session()->flash('error', 'Invalid request.');
                return redirect()->back();
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/media');
        }
    }

}

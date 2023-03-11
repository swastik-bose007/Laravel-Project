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
use App\Models\ProduceName;
use App\Models\Category;
use App\Models\Image;

class ProduceNameController extends Controller {

    private $responceData = [];

    public function __construct() {
        $this->responceData['searchKeyword'] = "";
    }
    
    public function produceNameList(Request $request) {
        try {
            $query = ProduceName::with([
                                        'getProduce',
                                        'getProduce.getStatus',
                                        'getCreator.getRoles',
                                        'getCreator.getStatus',
                                        'getStatus',
                                        'getImage'
                                    ]);

            // for search
            if(isset($request->search_keyword)):
                $keyword = $request->search_keyword;
                $query = $query->where('tags', 'LIKE', "%$keyword%");
                $this->responceData['searchKeyword'] = $request->search_keyword;
            endif;

            $this->responceData['listData'] = $query->orderBy('id', 'desc')->paginate(env('PAGINATE'));

            return view('admin.produce-name.list', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/dashboard');
        }
    }

    public function produceNameCreate(Request $request) {
        try {
            $this->responceData['statusList'] = Status::get();
            $this->responceData['categoryList'] = Category::where('status', 1)
                                                    ->get();

            return view('admin.produce-name.add', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/produce-name');
        }
    }

    public function produceNameCreateProcess(Request $request) {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                            'name'      => 'required|string|max:60',
                            'status'    => 'required|exists:tk_status,status_code',
                            'category'  => 'required|exists:tk_category,id',
                        ]);

            if ($validator->fails()) :
                return redirect()->back()->withErrors($validator)->withInput();
            else:
                $name = ucfirst(strtolower($request->name));
                $ProduceNameExists = ProduceName::where('name', $name)->exists();


                if($ProduceNameExists):
                    $request->session()->flash('error', 'Name already exists.');
                    return redirect()->back()->withInput();
                else:
                    $produceName = new ProduceName;
                    $produceName->created_by    = Auth::guard('admin')->user()->id;
                    $produceName->name          = $name;
                    $produceName->status        = $request->status;
                    $produceName->category_id   = $request->category;

                    //for getting parent tags data.

                    $tagCategoryName=Category::Where('id',$request->category)->get('name');

                        
                        //for getting status tags data
                        switch($request->status)
                        {
                            case 1:
                                $tagStatus='active';
                                break;
                            case 2:
                                $tagStatus='request';
                                break;
                            default:
                                $tagStatus='inactive';
                        }

                    //for getting user tag

                    $tagUser=User::Where('id',Auth::guard('admin')->user()->id)->get();
                    
                    // update search tag
                    $produceName->tags = strtolower($request->name).','.strtolower($tagCategoryName[0]->name).','.$tagStatus.','.$tagUser[0]->tags;                                             
                    
                    // create slug
                    $slug = CommonFunction::createSlug($name);
                    $produceName->slug = $slug;
                    $produceName->save();

                    //Storing Photos
                    if ($request->hasfile('add_photos')) {
                    
                    foreach($request->file('add_photos') as $key=>$file)
                    {
                    $randomNumber = random_int(100000, 999999);
                    $extension=$file->getClientOriginalExtension();
                    $filename=time().'-image-'.$randomNumber.'.'.$extension;
                    $path='public/upload/produce';
                    $file->move('public/upload/produce', $filename);
                    $insert[$key]['produce_name_id']    = $produceName->id;
                    $insert[$key]['produce_image_url']  = $path.'/'.$filename;
                    }
                    }
                    Image::insert($insert);

                    $request->session()->flash('success', 'Successfully created.');
                    return redirect('admin/produce-name');
                endif;
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/produce-name');
        }
    }

    public function produceNameEdit($slug, Request $request) {
        try {
            $produceName = ProduceName::with([
                                'getCreator.getRoles',
                                'getCreator.getStatus',
                                'getStatus',
                                'getImage'
                            ])
                            ->where('slug', $slug)
                            ->first();

            if($produceName != null):
                $this->responceData['produceName']  = $produceName;
                $this->responceData['statusList']   = Status::get();
                $this->responceData['imageList']    = Image::where('produce_name_id','=',$produceName->id)->paginate(env('PAGINATE'));
                $this->responceData['categoryList'] = Category::where('status', 1)
                                                    ->get();
                return view('admin.produce-name.edit', $this->responceData);
            else:
                $request->session()->flash('error', 'Invalid request.');
                return redirect('admin/produce-name');
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/produce-name');
        }
    }

    public function produceNameEditProcess(Request $request) {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                                'slug'  => 'required|exists:tk_produce_name,slug|max:60',
                                'name'  => 'required|string|max:60',
                                'status' => 'required|exists:tk_status,status_code',
                                'category'  => 'required|exists:tk_category,id',
                            ]);

            if ($validator->fails()) :
                return redirect()->back()->withErrors($validator)->withInput();
            else:
                $name = ucfirst(strtolower($request->name));
                $ProduceNameExists = ProduceName::where('name', $name)
                                        ->where('slug', '!=', $request->slug)
                                        ->exists();


                if($ProduceNameExists):
                    $request->session()->flash('error', 'Name already exists.');
                    return redirect()->back()->withInput();
                else:
                    $produceName = ProduceName::where('slug', $request->slug)->first();

                    if($produceName != null):
                        $produceName->created_by    = Auth::guard('admin')->user()->id;
                        $produceName->name          = $name;
                        $produceName->status        = $request->status;
                        $produceName->category_id   = $request->category;

                        //for getting parent tags data.
                        $tagCategoryName=Category::Where('id',$request->category)->get('name');

                        
                        //for getting status tags data
                        switch($request->status)
                        {
                            case 1:
                                $tagStatus='active';
                                break;
                            case 2:
                                $tagStatus='request';
                                break;
                            default:
                                $tagStatus='inactive';
                        }

                    //for getting user tag
                    $tagUser=User::Where('id',Auth::guard('admin')->user()->id)->get();
                    
                    // update search tag
                    $produceName->tags = strtolower($request->name).','.strtolower($tagCategoryName[0]->name).','.$tagStatus.','.$tagUser[0]->tags;
                        
                        $produceName->save();

                        //chechking and saving product_image

                    if ($request->hasfile('add_photos')) {
                        
                        foreach($request->file('add_photos') as $key=>$file)
                        {
                        $randomNumber = random_int(100000, 999999);
                        $extension=$file->getClientOriginalExtension();
                        $filename=time().'-image-'.$randomNumber.'.'.$extension;
                        $path='public/upload/produce';
                        $file->move('public/upload/produce', $filename);
                        $insert[$key]['produce_name_id']    = $produceName->id;
                        $insert[$key]['produce_image_url']  = $path.'/'.$filename;
                        }
                        Image::insert($insert);
                    }

                        // updating slug
                        $slug = CommonFunction::createSlug($request->name);
                        $produceExists = ProduceName::where('slug', $slug)
                                            ->where('id', '!=', $produceName->id)
                                            ->exists();
                        $slug = $produceExists ? $slug . '-' . $produceName->id : $slug;
                        ProduceName::where('id', $produceName->id)
                            ->update([
                                "slug" => $slug
                            ]);

                        $request->session()->flash('success', 'Successfully updated.');
                        return redirect('admin/produce-name');
                    else:
                        $request->session()->flash('error', 'Invalid request.');
                        return redirect('admin/produce-name');
                    endif;
                endif;
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/produce-name');
        }
    }

    public function produceNameDelete($slug, Request $request) {
        try {
            $produceName=ProduceName::Where('slug', $slug)->first();
            $produce =Produce::Where('produce_name_id',$produceName->id)->first();

            if ($produce)
            {
                $request->session()->flash('error', 'Assigned Produce Name cannot be Deleted. Please remove the Produce Name from all assigned Produces and try again.');
                return redirect()->back();
            }
            else
            {
                $produceName->delete();
                $request->session()->flash('success', 'Successfully deleted.');
                return redirect()->back();
            }

        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/produce-name');
        }
    }
    
    public function produceNameChangeStatus($slug, Request $request) {
        try {
            $produceName = ProduceName::where('slug', $slug)->first();

            if($produceName != null):
                $produceName->status = !$produceName->status;
                $produceName->save();

                $request->session()->flash('success', 'Successfully updated.');
                return redirect()->back();
            else:
                $request->session()->flash('error', 'Invalid request.');
                return redirect()->back();
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/produce-name');
        }
    }

    public function produceDeleteImage($id,Request $request) {

        $image=Image::where('id','=',$id)->get();

        if($image){
            $image[0]->delete();
            $request->session()->flash('success', 'Image successfully deleted.');
                return redirect()->back();
            }
            else
            {
                $request->session()->flash('error', 'Invalid request.');
                return redirect()->back();}
        
    }

}

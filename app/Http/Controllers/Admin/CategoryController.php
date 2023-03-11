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
use App\Models\Category;
use App\Models\Produce;
use App\Models\ProduceName;
use App\Models\WeightUnit;

class CategoryController extends Controller {

    private $responceData = [];

    public function __construct() {
        $this->responceData['searchKeyword'] = "";
    }
    
    public function categoryList(Request $request) {
        try {
            $query = Category::with([
                                        'getStatus',
                                        'getParent'
                                    ]);

            // for search
            if(isset($request->search_keyword)):
                $keyword = $request->search_keyword;
                $query = $query->where('tags', 'LIKE', "%$keyword%");
                $this->responceData['searchKeyword'] = $request->search_keyword;
            endif;

            $this->responceData['listData'] = $query->orderBy('id', 'desc')->paginate(env('PAGINATE'));


            return view('admin.category-management.list', $this->responceData);

        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/admin/dashboard');
        }
    }

    public function categoryCreate(Request $request) {
        try {
            $this->responceData['categoryList'] = Category::where('status', 1)
                                                    ->get();
            $this->responceData['statusList'] = Status::get();

            return view('admin.category-management.add', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/admin/dashboard');
        }
    }

    public function categoryCreateProcess(Request $request) {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                                'parent_id'     => 'nullable|exists:tk_category,id',
                                'name'          => 'required|string|max:60',
                                'description'   => 'required|string|max:1000',
                                'priority'      => 'required|integer',
                                'status'        => 'required|integer|exists:tk_status,status_code',
                                'is_editable'   => 'required|boolean',
                            ]);

            if ($validator->fails()) :
                return redirect()->back()->withErrors($validator)->withInput();
            else:
                $category = new Category;
                $category->parent_id    = $request->parent_category;
                $category->name         = ucfirst(strtolower($request->name));
                $category->description  = $request->description;
                $category->priority     = $request->priority;
                $category->status       = $request->status;
                $category->is_editable  = $request->is_editable;

                // create slug
                $slug = CommonFunction::createSlug($request->name . CommonFunction::generateRandomNumber(20));
                $category->slug = $slug;

                //for getting parent tags data.
                if($request->parent_category==0)
                {
                    $tagParentCategory = 'main';
                }
                else
                {
                    $tagParent=Category::Where('id',$request->parent_category)->get('name');
                    $tagParentCategory=$tagParent[0]->name;
                }
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
                $category->tags = strtolower($request->name) . ',' . strtolower($request->description).','. strtolower($tagParentCategory).','.$tagStatus.','.$tagUser[0]->tags;

                $category->save();

                // updating slug
                $slug = CommonFunction::createSlug($request->first_name . ' ' . $request->last_name);
                $categoryExists = Category::where('slug', $slug)
                                ->where('id', '!=', $category->id)
                                ->exists();
                $slug = $categoryExists ? $slug . '-' . $category->id : $slug;
                Category::where('id', $category->id)
                    ->update([
                        "slug" => $slug
                    ]);

                $request->session()->flash('success', 'Successfully created.');
                return redirect('admin/category-management');
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/admin/dashboard');
        }
    }

    public function categoryEdit($slug, Request $request) {
        try {
            $this->responceData['categoryList'] = Category::with(['getParent'])
                                                    ->where('status', 1)
                                                    ->where('slug', '!=', $slug)
                                                    ->get();
            $this->responceData['statusList'] = Status::get();

            $this->responceData['category'] = Category::with([
                                                    'getStatus',
                                                    'getParent'
                                                ])
                                                ->where('slug', $slug)
                                                ->first();
            
            return view('admin.category-management.edit', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/admin/dashboard');
        }
    }

    public function categoryEditProcess(Request $request) {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                                'slug'          => 'required|exists:tk_category,slug|max:60',
                                'parent_id'     => 'nullable|exists:tk_category,id',
                                'name'          => 'required|string|max:60',
                                'description'   => 'required|string|max:1000',
                                'priority'      => 'required|integer',
                                'status'        => 'required|integer|exists:tk_status,status_code',
                                'is_editable'   => 'required|boolean',
                            ]);

            if ($validator->fails()) :
                return redirect()->back()->withErrors($validator)->withInput();
            else:
                $category = Category::where('slug', $request->slug)->first();

                $category->parent_id    = $request->parent_category;
                $category->name         = ucfirst(strtolower($request->name));
                $category->description  = $request->description;
                $category->priority     = $request->priority;
                $category->status       = $request->status;
                $category->is_editable  = $request->is_editable;

                // create slug
                $slug = CommonFunction::createSlug($request->name . CommonFunction::generateRandomNumber(20));
                $category->slug = $slug;

                //for getting parent tags data.
                if($request->parent_category==0)
                {
                    $tagParentCategory = 'main';
                }
                else
                {
                    $tagParent=Category::Where('id',$request->parent_category)->get();
                    $tagParentCategory=$tagParent[0]->name;
                }
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
                $category->tags = strtolower($request->name) . ',' . strtolower($request->description).','. strtolower($tagParentCategory).','.$tagStatus.','.$tagUser[0]->tags;

                $category->save();

                // updating slug
                $slug = CommonFunction::createSlug($request->first_name . ' ' . $request->last_name);
                $userExists = User::where('slug', $slug)
                                ->where('id', '!=', $category->id)
                                ->exists();
                $slug = $userExists ? $slug . '-' . $category->id : $slug;
                User::where('id', $category->id)
                    ->update([
                        "slug" => $slug
                    ]);

                $request->session()->flash('success', 'Successfully updated.');
                return redirect('admin/category-management');
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/admin/dashboard');
        }
    }

    public function categoryDelete($slug, Request $request) {
        try {
            $category=Category::where('slug', $slug)->first();
            $produceName=ProduceName::Where('category_id',$category->id)->first();

            if ($produceName)
            {
                $request->session()->flash('error', 'Assigned Category cannot be Deleted. Please remove the category from all assigned Produce Name and try again.');
                return redirect()->back();
            }
            else
            {
                $category->delete();
                $request->session()->flash('success', 'Successfully deleted.');
                return redirect()->back();
            }
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/dashboard');
        }
    }
    
    public function categoryChangeStatus($slug, Request $request) {
        try {
            $category = Category::where('slug', $slug)->first();
            $category->status = !$category->status;
            $category->save();
            
            $request->session()->flash('success', 'Successfully updated.');
            return redirect()->back();
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/dashboard');
        }
    }
}

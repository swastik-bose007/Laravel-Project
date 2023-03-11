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

class WeightController extends Controller
{

    public function __construct() {
        $this->responceData['searchKeyword'] = "";
    }

    public function weightUnitList(Request $request) {
        try {
            $query = WeightUnit::orderBy('id', 'desc');

            // for search
            if(isset($request->search_keyword)):
                $keyword = $request->search_keyword;
                $query = $query->where('tags', 'LIKE', "%$keyword%");
                $this->responceData['searchKeyword'] = $request->search_keyword;
            endif;

            $this->responceData['listData'] = $query->orderBy('id', 'desc')->paginate(env('PAGINATE'));

            return view('admin.weight-unit.list', $this->responceData);

        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/admin/dashboard');
        }
    }

    public function weightUnitCreate(Request $request) {
        try {
            $this->responceData['weightlistData'] = WeightUnit::paginate(env('PAGINATE'));
            $this->responceData['statusList'] = Status::get();


            return view('admin.weight-unit.add', $this->responceData);

        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/admin/dashboard');
        }
    }

     public function weightUnitCreateProcess(Request $request) {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                                'unit_name'          => 'required|string|max:60',
                                'unit_symbol'        => 'required|string|max:60',
                                'status'             => 'required|integer|exists:tk_status,status_code',
                            ]);

            if ($validator->fails()) :
                return redirect()->back()->withErrors($validator)->withInput();
            else:
                $weightUnit = new WeightUnit;
                $weightUnit->weight_unit_name         = ucfirst(strtolower($request->unit_name));
                $weightUnit->symbol                   = ucfirst(strtolower($request->unit_symbol));
                $weightUnit->status                   = $request->status;

                // update search tag
                $weightUnit->tags = strtolower($request->unit_name).','.strtolower($request->unit_symbol);

                // create slug
                $slug = CommonFunction::createSlug($request->name . CommonFunction::generateRandomNumber(20));
                $weightUnit->slug = $slug;

                $weightUnit->save();

                // updating slug
                $slug = CommonFunction::createSlug($request->first_name . ' ' . $request->last_name);
                $userExists = User::where('slug', $slug)
                                ->where('id', '!=', $weightUnit->id)
                                ->exists();
                $slug = $userExists ? $slug . '-' . $weightUnit->id : $slug;
                User::where('id', $weightUnit->id)
                    ->update([
                        "slug" => $slug
                    ]);

                $request->session()->flash('success', 'Successfully created.');
                return redirect('admin/weight-unit/list');
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/admin/dashboard');
        }
    }

    public function weightUnitEdit($slug, Request $request) {

        try {
            $this->responceData['weightUnitList'] = WeightUnit::Where('slug','=',$slug)->get();
            
            return view('admin.weight-unit.edit', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/admin/dashboard');
        }
    }

    public function weightUnitEditProcess(Request $request) {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                                'slug'          => 'required|exists:tk_weight_unit,slug|max:60',
                                'unit_name'     => 'required|string|max:60',
                                'unit_symbol'   => 'required|string|max:60',
                            ]);

            if ($validator->fails()) :
                return redirect()->back()->withErrors($validator)->withInput();
            else:
                $weightUnit = WeightUnit::where('slug', $request->slug)->first();
                $weightUnit->weight_unit_name         = ucfirst(strtolower($request->unit_name));
                $weightUnit->symbol                   = ucfirst(strtolower($request->unit_symbol));

                // update search tag
                $weightUnit->tags = strtolower($request->unit_name).','.strtolower($request->unit_symbol);

                // create slug
                $slug = CommonFunction::createSlug($request->name . CommonFunction::generateRandomNumber(20));
                $weightUnit->slug = $slug;

                $weightUnit->save();

                // updating slug
                $slug = CommonFunction::createSlug($request->first_name . ' ' . $request->last_name);
                $userExists = User::where('slug', $slug)
                                ->where('id', '!=', $weightUnit->id)
                                ->exists();
                $slug = $userExists ? $slug . '-' . $weightUnit->id : $slug;
                User::where('id', $weightUnit->id)
                    ->update([
                        "slug" => $slug
                    ]);

                $request->session()->flash('success', 'Successfully updated.');
                return redirect('admin/weight-unit/list');
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/admin/dashboard');
        }
    }

    public function weightUnitDelete($slug, Request $request) {
        try {
            weightUnit::where('slug', $slug)->delete();
            
            $request->session()->flash('success', 'Successfully deleted.');
            return redirect()->back();
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/dashboard');
        }
    }

    public function weightUnitChangeStatus($slug, Request $request) {
        try {
            $weightUnit = WeightUnit::where('slug', $slug)->first();
            $weightUnit->status = !$weightUnit->status;
            $weightUnit->save();
            
            $request->session()->flash('success', 'Successfully updated.');
            return redirect()->back();
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/dashboard');
        }
    }
}

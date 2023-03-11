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
use App\Models\Fpo;

class FpoController extends Controller {

    private $responceData = [];

    public function __construct() {
        $this->responceData['searchKeyword'] = "";
    }
    
    public function fpoList(Request $request) {
        try {
            $query = Fpo::orderBy('id', 'desc')
                        ->paginate(env('PAGINATE'));

            // for search
            if(isset($request->search_keyword)):
                $keyword = $request->search_keyword;
                $query = $query->where('tags', 'LIKE', "%$keyword%");
                $this->responceData['searchKeyword'] = $request->search_keyword;
            endif;

            $this->responceData['listData'] = $query;
            
            return view('fpo.fpo.list', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/fpo/dashboard');
        }
    }

    public function fpoCreate(Request $request) {
        try {
            return view('fpo.fpo.add', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/fpo/dashboard');
        }
    }

    public function fpoCreateProcess(Request $request) {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                                'fpo_type'      => 'required|string|max:60',
                                'produce_type'  => 'required|string|max:60',
                                'quantity'      => 'required|integer',
                                'slot_no'       => 'required|string|max:60',
                                'area'          => 'required|string|max:20',
                                'district'      => 'required|string|max:20',
                                'pincode'       => 'required|string|max:6|min:6'
                            ]);

            if ($validator->fails()) :
                return redirect()->back()->withErrors($validator)->withInput();
            else:
                $fpo = new Fpo;
                $fpo->fpo_type      = $request->fpo_type;
                $fpo->produce_type  = $request->produce_type;
                $fpo->quantity      = $request->quantity;
                $fpo->slot_no       = $request->slot_no;
                $fpo->area          = $request->area;
                $fpo->district      = $request->district;
                $fpo->pincode       = $request->pincode;
                
                // create slug
                $slug = CommonFunction::generateRandomNumber(40);
                $fpo->slug = $slug;

                //update search tag
                $fpo->tags = $request->fpo_type.','.$request->produce_type.','.$request->quantity.','.$request->slot_no.','.strtolower($request->area).','.strtolower($request->district).','.$request->pincode;
                
                $fpo->save();

                // updating slug
                $slug = CommonFunction::generateRandomNumber(40);
                $fpoExists = Fpo::where('slug', $slug)
                                ->where('id', '!=', $fpo->id)
                                ->exists();
                $slug = $fpoExists ? $slug . '-' . $fpo->id : $slug;
                Fpo::where('id', $fpo->id)
                    ->update([
                        "slug" => $slug
                    ]);

                $request->session()->flash('success', 'Successfully created.');
                return redirect('fpo/fpo');
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('fpo/dashboard');
        }
    }

    public function fpoEdit($slug, Request $request) {
        try {
            $fpo = Fpo::where('slug', $slug)->first();
            if($fpo != null):
                $this->responceData['fpo'] = Fpo::where('slug', $slug)->first();
                return view('fpo.fpo.edit', $this->responceData);
            else:
                $request->session()->flash('error', 'Invalid request.');
                return redirect('fpo/fpo');
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('fpo/dashboard');
        }
    }

    public function fpoEditProcess(Request $request) {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                                'slug'          => 'required|exists:tk_fpo,slug|max:60',
                                'fpo_type'      => 'required|string|max:60',
                                'produce_type'  => 'required|string|max:60',
                                'quantity'      => 'required|integer',
                                'slot_no'       => 'required|string|max:60',
                                'area'          => 'required|string|max:20',
                                'district'      => 'required|string|max:20',
                                'pincode'       => 'required|string|max:6|min:6'
                            ]);

            if ($validator->fails()) :
                return redirect()->back()->withErrors($validator)->withInput();
            else:
                $fpo = Fpo::where('slug', $request->slug)->first();

                $fpo->fpo_type      = $request->fpo_type;
                $fpo->produce_type  = $request->produce_type;
                $fpo->quantity      = $request->quantity;
                $fpo->slot_no       = $request->quantity;
                $fpo->area          = $request->area;
                $fpo->district      = $request->district;
                $fpo->pincode       = $request->pincode;

                //update search tag
                $fpo->tags = $request->fpo_type.','.$request->produce_type.','.$request->quantity.','.$request->slot_no.','.strtolower($request->area).','.strtolower($request->district).','.$request->pincode;

                $fpo->save();

                // updating slug
                $slug = CommonFunction::generateRandomNumber(40);
                $fpoExists = Fpo::where('slug', $slug)
                                ->where('id', '!=', $fpo->id)
                                ->exists();
                $slug = $fpoExists ? $slug . '-' . $fpo->id : $slug;
                Fpo::where('id', $fpo->id)
                    ->update([
                        "slug" => $slug
                    ]);

                $request->session()->flash('success', 'Successfully updated.');
                return redirect('fpo/fpo');
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('/fpo/dashboard');
        }
    }

    public function fpoDelete($slug, Request $request) {
        try {
            Fpo::where('slug', $slug)->delete();

            $request->session()->flash('success', 'Successfully deleted.');
            return redirect()->back();
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('fpo/dashboard');
        }
    }
    
    public function fpoChangeStatus($slug, Request $request) {
        try {
            $fpo = Fpo::where('slug', $slug)->first();
            $fpo->status = !$fpo->status;
            $fpo->save();
            
            $request->session()->flash('success', 'Successfully updated.');
                return redirect('fpo/fpo');
            return redirect()->back();
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('fpo/dashboard');
        }
    }
    
}

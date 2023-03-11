<?php

namespace App\Http\Controllers\Sufalstore;

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
use App\Models\WeightUnit;
use App\Models\ProduceVariant;


class ProduceController extends Controller {

    private $responceData = [];

    public function __construct() {
        $this->responceData['searchKeyword'] = "";
    }
    
    public function produceList(Request $request) {
        try {
            $query = Produce::with([
                                    'getProduceName',
                                    'getProduceName.getStatus',
                                    'getProduceName.getCategory',
                                    'getCreator.getRoles',
                                    'getCreator.getStatus',
                                    'getStatus',
                                    'getWeightUnit',
                                    'getVariant'
                                ])
                                ->where('created_by', Auth::guard('sufalstore')->user()->id);

            // for search
            if(isset($request->search_keyword)):
                $keyword = $request->search_keyword;
                $query = $query->where('tags', 'LIKE', "%$keyword%");
                $this->responceData['searchKeyword'] = $request->search_keyword;
            endif;

            $this->responceData['listData'] = $query->orderBy('id', 'desc')->paginate(env('PAGINATE'));

            
            return view('sufalstore.produce.list', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('sufalstore/dashboard');
        }
    }

    public function produceCreate(Request $request) {
        try {
            $this->responceData['produceNameList']  = ProduceName::with([
                                                            'getCategory',
                                                            'getVariant'
                                                        ])
                                                        ->orderBy('id', 'desc')
                                                        ->where('status', 1)
                                                        ->get();
            $this->responceData['variantList']       =ProduceVariant::where('status', 1)->get();
                                                        
            return view('sufalstore.produce.add', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('sufalstore/dashboard');
        }
    }

    public function produceCreateProcess(Request $request) {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                            'produce_name_id'              => 'required|exists:tk_produce_name,id',
                            'type'                         => 'required|string|max:60',
                            'quantity'                     => 'required|integer',
                        ]);

            if ($validator->fails()) :
                return redirect()->back()->withErrors($validator)->withInput();
            else:
                $produce = new Produce;
                $produce->created_by              = Auth::guard('sufalstore')->user()->id;
                $produce->produce_name_id         = $request->produce_name_id;
                if($request->produce_variant_id==NULL)
                {
                $produce->produce_variant_id      = 0;
                }
                else
                {
                $produce->produce_variant_id      = $request->produce_variant_id;
                }
                $produce->type                    = ucfirst(strtolower($request->type));
                $produce->quantity                = $request->quantity;
                $produce->stock_left              = CommonFunction::generateRandomNumber(3);
                
                // create slug
                $slug = CommonFunction::createSlug(CommonFunction::generateRandomString(20));
                $produce->slug = $slug;

                //for getting produce name tags data.

                    $tagProduceName=ProduceName::Where('id',$request->produce_name_id)->get();

                        
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

                    $tagUser=User::Where('id',Auth::guard('sufalstore')->user()->id)->get();

                    // update search tag

                    if($request->produce_variant_id)
                    {
                    $tagVariantName=ProduceVariant::Where('id',$request->produce_variant_id)->get();

                    $produce->tags = $request->quantity.','.$tagStatus.','.$tagUser[0]->tags.','.$tagProduceName[0]->tags.','.$tagVariantName[0]->tags.','.strtolower($request->type);
                    }
                    else
                    {
                        $produce->tags = $request->quantity.','.$tagStatus.','.$tagUser[0]->tags.','.$tagProduceName[0]->tags.','.strtolower($request->type);
                    }
                $produce->save();

                // updating slug
                $produceExists = Produce::where('slug', $slug)
                                ->where('id', '!=', $produce->id)
                                ->exists();
                $slug = $produceExists ? $slug . '-' . $produce->id : $slug;
                Produce::where('id', $produce->id)
                    ->update([
                        "slug" => $slug
                    ]);

                $request->session()->flash('success', 'Successfully created.');
                return redirect('sufalstore/produce');
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('sufalstore/produce');
        }
    }

    public function produceEdit($slug, Request $request) {
        try {
            $produce = Produce::with([
                            'getProduceName',
                            'getProduceName.getStatus',
                            'getProduceName.getCategory',
                            'getProduceName.getVariant',
                            'getCreator.getRoles',
                            'getCreator.getStatus',
                            'getStatus',
                            'getWeightUnit',
                            'getVariant'
                        ])
                        ->where('slug', $slug)
                        ->where('created_by', Auth::guard('sufalstore')->user()->id)
                        ->first();

            if($produce != null):
                $this->responceData['produce']          = $produce;
                $this->responceData['produceNameList']  = ProduceName::orderBy('id', 'desc')->get();
                $this->responceData['variantList'] = ProduceVariant::where('produce_name_id','=',$produce->produce_name_id)
                                                    ->get();


                return view('sufalstore.produce.edit', $this->responceData);
            else:
                $request->session()->flash('error', 'Invalid request.');
                return redirect('sufalstore/produce');
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('sufalstore/dashboard');
        }
    }

    public function produceEditProcess(Request $request) {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                                'slug'                       => 'required|exists:tk_produce,slug|max:60',
                                'produce_name_id'            => 'required|exists:tk_produce_name,id',
                                'type'                       => 'required|string|max:60',
                                'quantity'                   => 'required|integer',
                            ]);

            if ($validator->fails()) :
                return redirect()->back()->withErrors($validator)->withInput();
            else:
                $produce = Produce::where('slug', $request->slug)
                            ->where('created_by', Auth::guard('sufalstore')->user()->id)
                            ->first();

                if($produce != null):
                    $produce->produce_name_id         = $request->produce_name_id;
                    $produce->type                    = ucfirst(strtolower($request->type));
                    $produce->quantity                = $request->quantity;

                    if($request->produce_variant_id==NULL)
                    {
                    $produce->produce_variant_id      = 0;
                    }
                    else
                    {
                    $produce->produce_variant_id      = $request->produce_variant_id;
                    }
                    //for getting produce name tags data.

                    $tagProduceName=ProduceName::Where('id',$request->produce_name_id)->get();

                        
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

                    $tagUser=User::Where('id',Auth::guard('sufalstore')->user()->id)->get();

                    // update search tag

                    if($request->produce_variant_id)
                    {
                    $tagVariantName=ProduceVariant::Where('id',$request->produce_variant_id)->get();

                    $produce->tags = $request->quantity.','.$tagStatus.','.$tagUser[0]->tags.','.$tagProduceName[0]->tags.','.$tagVariantName[0]->tags.','.strtolower($request->type);
                    }
                    else
                    {
                        $produce->tags = $request->quantity.','.$tagStatus.','.$tagUser[0]->tags.','.$tagProduceName[0]->tags.','.strtolower($request->type);
                    }
                    $produce->save();

                    // updating slug
                    $slug = CommonFunction::createSlug($request->name);
                    $produceExists = Produce::where('slug', $slug)
                                        ->where('id', '!=', $produce->id)
                                        ->exists();
                    $slug = $produceExists ? $slug . '-' . $produce->id : $slug;
                    Produce::where('id', $produce->id)
                        ->update([
                            "slug" => $slug
                        ]);

                    $request->session()->flash('success', 'Successfully updated.');
                    return redirect('sufalstore/produce');
                else:
                    $request->session()->flash('error', 'Invalid request.');
                    return redirect('sufalstore/produce');
                endif;
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('sufalstore/produce');
        }
    }

    public function produceDelete($slug, Request $request) {
        try {
            $deleteFlag = Produce::where('slug', $slug)
                ->where('created_by', Auth::guard('sufalstore')->user()->id)
                ->delete();

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
            return redirect('sufalstore/produce');
        }
    }
    
    public function produceChangeStatus($slug, Request $request) {
        try {
            $produce = Produce::where('slug', $slug)
                        ->where('created_by', Auth::guard('sufalstore')->user()->id)
                        ->first();

            if($produce != null):
                $produce->status = !$produce->status;
                $produce->save();

                $request->session()->flash('success', 'Successfully updated.');
                return redirect()->back();
            else:
                $request->session()->flash('error', 'Invalid request.');
                return redirect()->back();
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('sufalstore/produce');
        }
    }

    public function getProduceNameVariant($produceSlug, Request $request) {
        try {
            $ProduceName = ProduceName::with([
                                'getVariant',
                                'getVariant.getStatus',
                                'getVariant.getWeightUnit'
                            ])
                            ->where('slug', $produceSlug)
                            ->first();

            return response()->json(array('data'=> $ProduceName), 200);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            return response()->json([], 201);
        }
    }
    
}
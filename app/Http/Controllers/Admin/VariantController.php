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
use App\Models\WeightUnit;
use App\Models\ProduceVariant;

class VariantController extends Controller
{
    private $responceData = [];

    public function __construct() {
        $this->responceData['searchKeyword'] = "";
    }
    
    public function variantList($slug,Request $request) {

        $data=produceName::where('slug',$slug)->get('id');
        $id=$data[0]->id;

        try {
            $query = ProduceVariant::with([
                                            'getStatus',
                                            'getWeightUnit',
                                        ])
                                        ->where('produce_name_id','=',$id);

            // for search
            if(isset($request->search_keyword)):
                $keyword = $request->search_keyword;
                $query = $query->where('tags', 'LIKE', "%$keyword%");
                $this->responceData['searchKeyword'] = $request->search_keyword;
            endif;

            $this->responceData['listData'] = $query->orderBy('id', 'desc')->paginate(env('PAGINATE'));

            $this->responceData['produceNameList'] = ProduceName::Where('slug','=',$slug)->get();
            return view('admin.produce-name.variants.list', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/dashboard');
        }
    }

    public function variantCreate($slug,Request $request) {
        try {
            $this->responceData['statusList'] = Status::get();
            $this->responceData['weightList'] = WeightUnit::get();
            $this->responceData['produceNameList'] = ProduceName::Where('slug','=',$slug)->get();


            return view('admin.produce-name.variants.add', $this->responceData);
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/produce-name');
        }
    }

    public function variantCreateProcess(Request $request) {
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                            'variant_name'      => 'required|string|max:60',
                            'quantity'          => 'required|integer|min:1',
                            'status'            => 'required|exists:tk_status,status_code',
                            'weight_unit'       => 'required|exists:tk_weight_unit,id',
                        ]);

            if ($validator->fails()) :
                return redirect()->back()->withErrors($validator)->withInput();
            else:
                $name = ucfirst(strtolower($request->variant_name));
                $VariantNameExists = ProduceVariant::where('name', $name)->exists();


                if($VariantNameExists):
                    $request->session()->flash('error', 'Name already exists.');
                    return redirect()->back()->withInput();
                else:
                    $variant = new ProduceVariant;
                    $variant->name                  = ucfirst(strtolower($request->variant_name));
                    $variant->status                = $request->status;
                    $variant->quantity              = $request->quantity;
                    $variant->weight_unit_code      = $request->weight_unit;
                    $variant->produce_name_id       = $request->produce_name_id;

                    // create slug
                    $slug = CommonFunction::createSlug($request->variant_name);
                    $variant->slug = $slug;

                    //for getting produce name tags data.

                    $tagProduceName=produceName::Where('id',$request->produce_name_id)->get();

                        
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
                    $variant->tags = strtolower($request->variant_name) . ',' .$request->quantity.','.$tagStatus.','.$tagProduceName[0]->name.','.$tagProduceName[0]->tags;
                    $variant->save();

                    // updating slug
                    $slugExists = ProduceVariant::where('slug', $slug)
                                        ->where('id', '!=', $variant->id)
                                        ->exists();
                    $slug = $slugExists ? $slug . '-' . $variant->id : $slug;
                    ProduceVariant::where('id', $variant->id)
                        ->update([
                            "slug" => $slug
                        ]);

                    $request->session()->flash('success', 'Successfully created.');
                    return redirect('admin/produce-name/variant/'.$request->slug);
                endif;
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/produce-name');
        }
    }

    public function variantEdit($slug, Request $request) {
        try {
            $variant = ProduceVariant::with([
                                'getStatus',
                                'getWeightUnit',
                            ])
                            ->where('slug', $slug)
                            ->first();

            if($variant != null):
            $this->responceData['weightList']  = WeightUnit::Where('id','!=',$variant->unit_code)->get();
            $this->responceData['variantList'] = ProduceVariant::with([
                                                                    'getStatus',
                                                                    'getWeightUnit',
                                                                    'getProduceName'
                                                                ])
                                                                ->Where('slug','=',$slug)
                                                                ->get();

            

                return view('admin.produce-name.variants.edit', $this->responceData);
            else:
                $request->session()->flash('error', 'Invalid request.');
                return redirect('admin/produce-name/variant/'.$slug);
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/produce-name/variant/'.$slug);
        }
    }

    public function variantEditProcess(Request $request) {
        
        try {
            /* data validation */
            $validator = Validator::make($request->all(), [
                                'slug'              => 'required|exists:tk_produce_variants,slug|max:60',
                                'variant_name'      => 'required|string|max:60',
                                'quantity'          => 'required|integer|min:1',
                                'weight_unit'       => 'required|exists:tk_weight_unit,id'
                                ]);

            if ($validator->fails()) :
                return redirect()->back()->withErrors($validator)->withInput();
            else:
                $name = ucfirst(strtolower($request->variant_name));
                $variantNameExists = ProduceVariant::where('name', $name)
                                        ->where('slug', '!=', $request->slug)
                                        ->exists();


                if($variantNameExists):
                    $request->session()->flash('error', 'Name already exists.');
                    return redirect()->back()->withInput();
                else:

                    $variant = ProduceVariant::where('slug', $request->slug)->first();
                    if($variant != null):
                        $variant->name              = ucfirst(strtolower($request->variant_name));
                        $variant->quantity          = $request->quantity;
                        $variant->weight_unit_code  = $request->weight_unit;
                        $variant->slug              = $request->slug;

                        //for getting produce name tags data.

                        $tagProduceName=produceName::Where('id',$variant->produce_name_id)->get();

                            
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
                        $variant->tags = strtolower($request->variant_name) . ',' .$request->quantity.','.$tagStatus.','.$tagProduceName[0]->name.','.$tagProduceName[0]->tags;

                        $variant->save();


                        // updating slug
                        $slug = CommonFunction::createSlug($request->variant_name);
                        $variantExists = ProduceVariant::where('slug', $slug)
                                            ->where('id', '!=', $variant->id)
                                            ->exists();
                        $slug = $variantExists ? $slug . '-' . $variant->id : $slug;
                        ProduceVariant::where('id', $variant->id)
                                ->update([
                                "slug" => $slug
                            ]);

                        $request->session()->flash('success', 'Successfully updated.');
                        return redirect('admin/produce-name/variant/'.$request->produce_name_slug);
                    else:
                        $request->session()->flash('error', 'Invalid request.');
                        return redirect('admin/produce-name/variant/'.$request->produce_name_slug);
                    endif;
                endif;
            endif;
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/produce-name/variant/'.$request->produce_name_slug);
        }
    }

    public function variantDelete($slug, Request $request) {
        try {
            $produceVariant =ProduceVariant::Where('slug',$slug)->first();
            $produce=Produce::Where('produce_variant_id',$produceVariant->id)->first();

            if ($produce)
            {
                $request->session()->flash('error', 'Assigned Variant cannot be Deleted. Please remove the Variant from all assigned Produce Names and try again.');
                return redirect()->back();
            }
            else
            {
                $produceVariant->delete();
                $request->session()->flash('success', 'Successfully deleted.');
                return redirect()->back();
            }
        } catch (Exception $ex) {
            CommonFunction::generateErrorLog($ex, $request->all());
            $request->session()->flash('error', 'An error occurred.');
            return redirect('admin/produce-name/variant/'.$request->slug);
        }
    }
    
    public function variantChangeStatus($slug, Request $request) {
        try {
            $produceName = ProduceVariant::where('slug', $slug)->first();

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
            return redirect('admin/produce-name/variant/'.$request->slug);
        }
    }

    public function produceDeleteImage($slug,Request $request) {

        $image=Image::where('slug','=',$slug)->get();
        if($image){
            unlink('public/upload/product/'.$image[0]->produce_image);
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

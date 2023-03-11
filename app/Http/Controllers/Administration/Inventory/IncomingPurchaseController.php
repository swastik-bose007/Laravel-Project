<?php

namespace App\Http\Controllers\Administration\Inventory;

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

class IncomingPurchaseController extends Controller {

    private $responceData = [];

    public function __construct() {
        $this->responceData['searchKeyword'] = "";
    }
    
    public function index(Request $request) {
        $query = Produce::with([
                                'getProduceName',
                                'getCreator.getRoles',
                                'getCreator.getStatus',
                                'getCreator.getCreator.getRoles',
                                'getCreator.getCreator.getStatus',
                                'getStatus'
                            ]);

        // for search
            if(isset($request->search_keyword)):
                $keyword = $request->search_keyword;
                $query = $query->where('tags', 'LIKE', "%$keyword%");
                $this->responceData['searchKeyword'] = $request->search_keyword;
            endif;

            $this->responceData['listData'] = $query->orderBy('id', 'desc')->paginate(env('PAGINATE'));

        return view('administration.inventory.incoming-purchase.list', $this->responceData);
    }
    
}

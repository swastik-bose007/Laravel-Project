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

class HomeController extends Controller {

    private $responceData = [];

    public function __construct() {
    }
    
    public function index(Request $request) {
        return view('admin.dashboard.default', $this->responceData);
    }
    
}

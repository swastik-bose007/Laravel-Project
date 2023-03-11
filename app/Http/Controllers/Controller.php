<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendResponse($responseData) {

        $response = [
            'status'        => $responseData['status'],
            'status_code'   => $responseData['status_code'],
            'message'       => $responseData['message'],
            'data'          => $responseData['data'],
            'request_data'  => $responseData['request_data']
        ];

        return response()->json($response);
    }

}

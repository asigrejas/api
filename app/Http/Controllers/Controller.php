<?php

namespace app\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function response($data, $status = 200)
    {
        if (is_bool($status)) {
            $status = $status ? 200 : 422;
        }

        if (!is_array($data) && !is_object($data)) {
            $data = ['message' => $data];
        }

        if ($status >= 400 && $status <= 499) {
            return response()->json(['error' => $data, 'status' => $status], $status);
        }

        return response()->json($data, $status);
    }
}

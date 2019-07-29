<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function vue()
    {
        return view('index');
    }

    /**
     * Used to return success response
     * @return Response
     */

    public function ok($items = null)
    {
        return response()->json($items);
    }

    public function error($items = null, $status = 422)
    {
        $data = array();

        if ($items) {
            foreach ($items as $key => $item) {
                $data['error'][$key][] = $item;
            }
        }

        return response()->json($data, $status);
    }

    /**
     * Used to return success response
     * @return Response
     */

    public function success($items = null, $status = 200)
    {
        $data = ['status' => 'success'];

        if ($items instanceof Arrayable) {
            $items = $items->toArray();
        }

        if ($items) {
            foreach ($items as $key => $item) {
                $data[$key] = $item;
            }
        }

        return response()->json($data, $status);
    }
}

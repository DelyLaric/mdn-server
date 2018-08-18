<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function viaParams($rules)
    {

        $validator = \Validator::make($this->params, $rules);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        foreach ($rules as $key => $value) {
            if (!isset($this->params[$key])) {
                $this->params[$key] = null;
            }
        }

        return $this->params;
    }

    public function via(array $rules)
    {
        $this->params = request(array_keys($rules));

        return $this->viaParams($rules);
    }
}

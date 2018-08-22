<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;

class ValidationController extends Controller
{
    public function validation()
    {
        $params = request()->all();
        $errors = [];

        foreach ($params as $key => $param) {
            if (!$this->singleValidate(
                $param['value'], $param['rule'])
            ) {
                $errors[] = $key;
            }
        }

        return ['errors' => $errors];
    }

    public function singleValidate($value, $rule)
    {
        $result = \Validator::make(
            ['value' => $value],
            ['value' => $rule]
        );
        if ($result->fails()) return false;
        else return true;
    }
}

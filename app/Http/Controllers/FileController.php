<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request) {
        $result = $request->file('file')->store('public/images');
        return [
            "result"    => $result,
            "filename"  => $request->file('file')->hashName()
        ];
    }
}

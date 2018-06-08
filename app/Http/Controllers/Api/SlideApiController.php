<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use DB;

class SlideApiController extends Controller
{
    public function getSlide()
    {
        $slide=DB::table('slides')->select('id','link','image')->get();
        return response()->json($slide,200);
    }
}

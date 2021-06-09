<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;

class MoviesController extends Controller
{

    public function new($id = null)
    {
        if($id == null){
            return response()->json(
                [
                    'success' => true,
                    'data' => Movie::orderBy('created_at','desc')->take(3)->get(),
                ]
            );
        }else
        {
            return response()->json(
                [
                    'success' => true,
                    'data' => Movie::where('id', $id)->get(),
                ]
            );
        }
    }

    public function get_all($id = null)
    {
        if($id == null){
            return response()->json(
                [
                    'success' => true,
                    'data' => Movie::all(),
                ]
            );
        }else
        {
            return response()->json(
                [
                    'success' => true,
                    'data' => Movie::where('id', $id)->get(),
                ]
            );
        }
    }

    public function get_available($id = null)
    {
        if($id == null){
            return response()->json(
                [
                    'success' => true,
                    'data' => Movie::where('status', '0')->get(),
                ]
            );
        }else
        {
            return response()->json(
                [
                    'success' => true,
                    'data' => Movie::where('id', $id)->where('status', '0')->get(),
                ]
            );
        }
    }
}

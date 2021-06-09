<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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

    public function add_movie(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => [
                'required',
            ],
            'rating' => [
                'required',
            ],
            'price' => [
                'required',
            ],
            'synopsis' => [
                'required',
            ],
        ]);

        if($validator->fails())
        {
            $errors = $validator->errors();

            return response()->json(['success' => false, 'message' => $errors]);
        }

        $user_id = Auth::guard('api')->user()->id;
        $check = User::where('id', $user_id)->where('role', 'admin')->first();
        

        if (!$check) {
            return response()->json([
                'success' => false,
                'message' => 'Login Sebagai Admin'
            ]);
        }

        $insert = Movie::create([
            'title' => $request->title,
            'photo' => 'photo.jpg',
            'rating' => $request->rating,
            'price' => $request->price,
            'synopsis' => $request->synopsis,
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan film'
        ], 200);
    }

    public function remove_movie($id_movie)
    {
        $user_id = Auth::guard('api')->user()->id;
        $movie_id = $id_movie;
       
        $check = User::where('id', $user_id)->where('role', 'admin')->first();
        

        if (!$check) {
            return response()->json([
                'success' => false,
                'message' => 'Login Sebagai Admin'
            ]);
        }


        $movie = Movie::where('id', $id_movie)->first();
        if(empty($movie))
        {
            return response()->json([
                'success' => false,
                'message' => 'Film tidak ada'
            ]);
        }
        $delete = $movie->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus Film'
        ], 200);
    }
}

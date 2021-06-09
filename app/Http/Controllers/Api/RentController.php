<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RentMovie;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RentController extends Controller
{
    public function rent_list()
    {
        $user_id = Auth::guard('api')->user()->id;
        
        
        $data = User::where('id', $user_id)->with('movies')->get()->first();
        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);
            
    }

    public function rent(Request $request, $id_movie)
    {
        $user_id = Auth::guard('api')->user()->id;
        $movie_id = $id_movie;

        
        $check = RentMovie::where('user_id', $user_id)->where('movie_id', $movie_id)->first();
        if(!empty($check))
        {
            return response()->json([
                'success' => false,
                'message' => 'Kamu sudah meminjam film ini'
            ]);
        }
            RentMovie::create([
                'user_id' => $user_id,
                'movie_id' => $id_movie,
            ]);
    
            $update = Movie::find($id_movie);
            $update->status = '1';
            $update->save();

            return response()->json([
                'success' => true,
                'message' => 'Film berasil dipinjam'
            ], 200);
    }

    public function unrent($id_movie)
    {
        $user_id = Auth::guard('api')->user()->id;
        $movie_id = $id_movie;

        $check = RentMovie::where('user_id', $user_id)->where('movie_id', $movie_id)->first();
        if(empty($check))
        {
            return response()->json([
                'success' => false,
                'message' => 'Belum meminjam film ini'
            ]);
        }
        $update = Movie::find($id_movie);
            $update->status = '0';
            $update->save();

        $delete = $check->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengembalikan film'
        ], 200);
    }
}

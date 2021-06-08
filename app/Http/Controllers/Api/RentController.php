<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RentMovie;
use App\Models\Movie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
}

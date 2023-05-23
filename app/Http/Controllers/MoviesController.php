<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
    
class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $movies = null;
        if($request->hasAny(Movie::$filterable)){
            $movies = Movie::filter($request->input())->paginate();
        } else{
            $movies = Movie::paginate();
        }
        return response()->json(['success' => true,
                                 'message' => $movies]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:movies|max:255',
            'director_id' => 'required'
            
        ]);
        
        $movie = Movie::create($request->input());
        $movie->load('director');
        return response()->json($movie, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        return response()->json($movie);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        $request->validate([
            'title' => 'unique:movies|max:255',
            
        ]);
        $movie->update($request->input());
        return response()->json($movie, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        return response()->json( $movie->delete(),202);
    }

}

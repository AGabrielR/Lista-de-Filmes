<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Profile;
use App\Models\moviesList;

class ListController extends Controller
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
        $movie_id = $request->only(['movie_id']);
        
        $aux = DB::table('movies_lists')
            ->select(DB::raw('movie_id'))
            ->where(
                [
                    ['profile_id', '=', session()->get('profile_id', [1])], 
                    ['movie_id', '=', $movie_id],
                ])
            ->get();
        
        if(!isset($aux)){
            
            $movies_list = $request->only(['movie_id']);
            $movies_list['profile_id'] = session()->get('profile_id', [1]);
            $movies_list['watched'] = false;

        moviesList::create($movies_list);
        }

        

        return redirect()->route('movies.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {   
        $aux = DB::table('movies_lists')
            ->select(DB::raw('movie_id'))
            ->where('profile_id', '=', session()->get('profile_id', [1]))
            ->get();
        
        $listMovies = [];

        foreach ($aux as $movie) {
            $listMovies[] = Http::withToken(config('services.tmdb.token'))
                ->get('api.themoviedb.org/3/movie/'.$movie->movie_id.'?api_key=779bc7008873609c435dd32a32ab1bba&language=en-US')
                ->json();
        }

        // dd($listMovies);        
        $genresArray = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/genre/movie/list')
            ->json(['genres']);

        $genres = collect($genresArray)->mapWithKeys(function ($genre){
            return [$genre['id'] => $genre['name']];
        });

        return view('list.movies', [
            'listMovies' => $listMovies,
            'genres' => $genres,
        ]);
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
}

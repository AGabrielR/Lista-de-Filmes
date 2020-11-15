<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        
        $popularMovies = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/movie/popular?api_key=779bc7008873609c435dd32a32ab1bba&language=pt-BR')
            ->json(['results']);

        $genresArray = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/genre/movie/list?api_key=779bc7008873609c435dd32a32ab1bba&language=pt-BR')
            ->json(['genres']);

        $genres = collect($genresArray)->mapWithKeys(function ($genre){
            return [$genre['id'] => $genre['name']];
        });

        $aux = DB::table('movies_cats')
                ->select(DB::raw('cat_id, count(cat_id) as cat'))
                ->where([
                    ['profile_id', '=', session()->get('profile_id', [1])],
                ])
                ->groupByRaw('cat_id')
                ->orderByRaw('count(cat_id) desc')
                ->get();
        
        if(isset($aux[0]->cat)){
            $recommendMovies = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/discover/movie?api_key=779bc7008873609c435dd32a32ab1bba&language=pt-BR&with_genres='.$aux[0]->cat_id)
            ->json(['results']);

        return view('index', [
            'popularMovies' => $popularMovies,
            'genres' => $genres,
            'recommendMovies' => $recommendMovies,
        ]);
        }else{
            return view('index', [
                'popularMovies' => $popularMovies,
                'genres' => $genres,
            ]);
        }
    }   

    public function find(Request $search){

        $searchResults = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/search/movie?api_key={eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI3NzliYzcwMDg4NzM2MDljNDM1ZGQzMmEzMmFiMWJiYSIsInN1YiI6IjVmYWQ3MjgwZGExMGYwMDA0MGQ1MmFmNCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.ZzCx7Wny6o6HM0VvWZWcP3vpCAhL999bY-_eTZH96zs}&language=pt-BR&query='.$search['search'])
            ->json(['results']);
        
            $genresArray = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/genre/movie/list?api_key=779bc7008873609c435dd32a32ab1bba&language=pt-BR')
            ->json(['genres']);

        $genres = collect($genresArray)->mapWithKeys(function ($genre){
            return [$genre['id'] => $genre['name']];
        });

            return view('movies.find', [
                'searchResults' => $searchResults,
                'genres' => $genres,
            ]);
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
}

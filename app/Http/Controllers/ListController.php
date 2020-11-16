<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Profile;
use App\Models\moviesList;
use App\Models\moviesCat;

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
        if(null !== (session()->get('profile_id'))){
            if([] !== $request->only(['id'])){
                $movie_id = $request->only(['id']);
            }else{
                $movie_id = $request->only(['movie_id']);
            }
           
            // dd($movie_id['movie_id']);
            
            // dd(session()->get('profile_id'));
            if(isset($movie_id['movie_id'])){
                $aux = DB::table('movies_lists')
                    ->select(DB::raw('movie_id'))
                    ->where(
                        [
                            ['profile_id', '=', session()->get('profile_id', [1])], 
                            ['movie_id', '=', $movie_id['movie_id']],
                        ])
                    ->get();
            }else{
                $aux = DB::table('movies_lists')
                    ->select(DB::raw('movie_id'))
                    ->where(
                        [
                            ['profile_id', '=', session()->get('profile_id', [1])], 
                            ['movie_id', '=', $movie_id['id']],
                        ])
                    ->get();
            }

            if($aux!==[]){
                if(isset($movie_id['id'])){
                    $movies_list['movie_id'] = $movie_id['id'];
                }else{
                    $movies_list['movie_id'] = $movie_id['movie_id'];
                }
                
                $movies_list['profile_id'] = session()->get('profile_id', [1]);
                $movies_list['watched'] = false;
                
                $genresArray = Http::withToken(config('services.tmdb.token'))
                ->get('api.themoviedb.org/3/movie/'.$movies_list['movie_id'].'?api_key=779bc7008873609c435dd32a32ab1bba&language=en-US')
                ->json('genres');

                foreach ($genresArray as $genre) {
                    $movies_cat['cat_id'] = $genre['id'];
                    $movies_cat['profile_id'] = session()->get('profile_id', [1]);

                    moviesCat::create($movies_cat);
                }

            moviesList::create($movies_list);
            }

            return redirect()->route('movies.index');
        }else{
            return redirect()->route('profile.change');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {   
        if(null !== (session()->get('profile_id'))){
            $aux = DB::table('movies_lists')
                ->select(DB::raw('movie_id'))
                ->where([
                    ['profile_id', '=', session()->get('profile_id', [1])],
                    ['watched', '=', false],
                ])
                ->get();
            
            $listMovies = [];

            foreach ($aux as $movie) {
                $listMovies[] = Http::withToken(config('services.tmdb.token'))
                    ->get('api.themoviedb.org/3/movie/'.$movie->movie_id.'?api_key=779bc7008873609c435dd32a32ab1bba&language=pt-BR')
                    ->json();
            }

            $genresArray = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/genre/movie/list?api_key=779bc7008873609c435dd32a32ab1bba&language=pt-BR')
                ->json(['genres']);

            $genres = collect($genresArray)->mapWithKeys(function ($genre){
                return [$genre['id'] => $genre['name']];
            });

            return view('list.movies', [
                'listMovies' => $listMovies,
                'genres' => $genres,
            ]);
        }else{
            return redirect()->route('profile.change');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function watched()
    {
        if(null !== (session()->get('profile_id'))){
            $aux = DB::table('movies_lists')
            ->select(DB::raw('movie_id'))
            ->where([
                ['profile_id', '=', session()->get('profile_id', [1])],
                ['watched', '=', true],
            ])
            ->get();
            
            $listMovies = [];

            foreach ($aux as $movie) {
                $listMovies[] = Http::withToken(config('services.tmdb.token'))
                    ->get('api.themoviedb.org/3/movie/'.$movie->movie_id.'?api_key=779bc7008873609c435dd32a32ab1bba&language=pt-BR')
                    ->json();
            }

            // dd($listMovies);        
            $genresArray = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/genre/movie/list?api_key=779bc7008873609c435dd32a32ab1bba&language=pt-BR')
                ->json(['genres']);

            $genres = collect($genresArray)->mapWithKeys(function ($genre){
                return [$genre['id'] => $genre['name']];
            });

            return view('list.watched', [
                'listMovies' => $listMovies,
                'genres' => $genres,
            ]);

        }else{
            return redirect()->route('profile.change');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(null !== (session()->get('profile_id'))){
            $movie_id = $request->only(['id']);

                $aux = DB::table('movies_lists')
                    ->where(
                        [
                            ['profile_id', '=', session()->get('profile_id', [1])], 
                            ['movie_id', '=', $movie_id["id"]],
                        ])
                    ->update(['watched' => true]);
                
                $aux = null;

                $aux = DB::table('movies_lists')
                    ->select(DB::raw('movie_id'))
                    ->where([
                        ['profile_id', '=', session()->get('profile_id', [1])],
                        ['watched', '=', true],
                    ])
                    ->get();

                $listMovies = [];

                foreach ($aux as $movie) {
                    $listMovies[] = Http::withToken(config('services.tmdb.token'))
                        ->get('api.themoviedb.org/3/movie/'.$movie->movie_id.'?api_key=779bc7008873609c435dd32a32ab1bba&language=pt-BR')
                        ->json();
                }

                // dd($listMovies);        
                $genresArray = Http::withToken(config('services.tmdb.token'))
                    ->get('https://api.themoviedb.org/3/genre/movie/list?api_key=779bc7008873609c435dd32a32ab1bba&language=pt-BR')
                    ->json(['genres']);

                $genres = collect($genresArray)->mapWithKeys(function ($genre){
                    return [$genre['id'] => $genre['name']];
                });

                return view('list.watched', [
                    'listMovies' => $listMovies,
                    'genres' => $genres,
                ]);
            }else{
            return redirect()->route('profile.change');
        }
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

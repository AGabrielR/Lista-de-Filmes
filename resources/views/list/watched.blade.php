@extends('layouts.app')
    @section('content')
        <div class="container">
            <div class="popular-movies">
                <h2 class="uppercase trackindwider text-orange-500 text-lg font-semibold">Filmes que {{session()->get('profile_name', [1])}} já assistiu:</h2>
                <br>
                @if($listMovies === [])
                    <p>Nenhum filme encontrado, procure por algo para adicionar à lista.</p>
                @else
                <div class="row">
                    @foreach($listMovies as $movie)
                        <div class="col-md-3 mb-4">
                            <a href="#">
                                <img src="{{'https://image.tmdb.org/t/p/w500/'.$movie['poster_path']}}" alt="" class="offset-md-1 col-md-11 img-fluid">
                            </a>
                            <div class="offset-md-1 col-md-11">
                                <a href="" class="lead">{{$movie['title']}}</a>
                                <div>
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-star-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <span>{{$movie['vote_average'] * 10 .'%'}}</span>
                                    <span>|</span>
                                    <span>{{ \Carbon\Carbon::parse($movie['release_date'])->format('d M, y')}}</span>
                                </div>
                                <div>
                                    @for($i = 0; $i < count($movie['genres']); $i++)
                                        @foreach($movie['genres'][$i] as $genre)
                                            @if(!is_numeric($genre))
                                                {{ $genre }}@if (!$loop->last), @endif
                                            @endif
                                        @endforeach
                                    @endfor
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    @endsection
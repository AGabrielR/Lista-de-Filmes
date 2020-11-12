
@extends('layouts.app')
    @section('content')
    <br>

        @if(session()->has('profile_id'))
            <div class="offset-md-3 col-md-5">
                Você está logado no perfil {{session()->get('profile_id', [1])}}
            </div>
        @endif
        <div class="offset-md-8 col-md-2">
            <a href="{{route('profile.create')}}" class="btn btn-block btn-outline-primary">
                Criar um perfil (Limite de 4)
            </a>
        </div>
        <br>
        <table class="table table-hover table-bordered text-center col-md-8 offset-md-2">
            <thead class="thead-dark">
                <tr>
                    <th>Nome</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($profiles as $p)
                    <tr>
                        <td>{{$p->nome}}</td>
                        <td>
                            <a href="{{route('profile.edit',$p->id)}}" class="btn btn-warning">Alterar</a>
                        </td>
                        <td>
                            <form action="{{route('profile.destroy',$p->id)}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-outline-danger">
                                    Apagar
                                </button>
                            </form>
                        </td>
                        <td>
                            <form action="{{route('profile.access', $p->id, $p->nome)}}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-outline-success">
                                    Acessar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endsection
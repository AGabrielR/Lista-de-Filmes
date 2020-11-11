@extends('layouts.app')
    @section('content')
        <form action="{{route('profile.store')}}" method="post" class="col-md-8 offset-md-2">
        @csrf
            <br>
            <input type="text" name="nome" class="form-control" placeholder="Insira o nome do Perfil">
            <!-- name tem que ser o mesmo do atributo da tabela -->
            <br>
            <div class="row justify-content-end">
                    <button type="submit" class="btn btn-outline-success col-md-2">Salvar</button>
                    <button type="reset" class="btn btn-outline-danger btn-block col-md-2 offset-md-1">Apagar</button>
                </div>
            </div>
            

        </form>        
    @endsection    
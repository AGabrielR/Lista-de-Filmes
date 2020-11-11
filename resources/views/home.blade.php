@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if (!session('status'))
                    <div class="card-header">{{ __('Criar perfis') }}</div>

                    <div class="card-body">
                        <form action="{{route ('perfil.store')" method="post">
                            @csrf
                            
                        </form>
                    </div>
                    
                        
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

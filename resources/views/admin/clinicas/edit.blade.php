@extends('layouts.app')

@section('content')
<div class="page-info">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('clinicas.index') }}">Clínicas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar</li>
        </ol>
    </nav>
</div>
<div class="main-wrapper">
    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Editar clínica</h5>

                    <form action="{{ route('clinicas.update', $clinica->id) }}" method="POST">

                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Nombre</label>
                            <input
                                type="text"
                                class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
                                name="nombre"
                                value="{{ old('nombre') ? old('nombre') : $clinica->nombre }}"
                                required
                            >

                            @if ($errors->has('nombre'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('nombre') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="estado" name="estado" {{ $clinica->estado ? 'checked' : '' }}>
                                <label class="custom-control-label" for="estado">
                                    Activo
                                </label>
                            </div>
                        </div>

                        <div class="mt-5">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                            <a href="{{ route('clinicas.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

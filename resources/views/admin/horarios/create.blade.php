@extends('layouts.app')

@section('content')
<div class="page-info">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Horarios</a></li>
            <li class="breadcrumb-item active" aria-current="page">Crear</li>
        </ol>
    </nav>
</div>
<div class="main-wrapper">
    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nuevo Horario</h5>

                    <form action="{{ route('horarios.store') }}" method="POST">

                        @csrf

                        <input type="hidden" name="clinica_id" value="{{ $id }}">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Fecha Inicio</label>
                                <input
                                    type="datetime-local"
                                    class="form-control {{ $errors->has('fecha_inicio') ? 'is-invalid' : '' }}"
                                    name="fecha_inicio"
                                    value="{{ old('fecha_inicio') ?? old('fecha_inicio') }}"
                                    required
                                >

                                @if ($errors->has('fecha_inicio'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('fecha_inicio') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label>Fecha Fin</label>
                                <input
                                    type="datetime-local"
                                    class="form-control {{ $errors->has('fecha_fin') ? 'is-invalid' : '' }}"
                                    name="fecha_fin"
                                    value="{{ old('fecha_fin') ?? old('fecha_fin') }}"
                                    required
                                >

                                @if ($errors->has('fecha_fin'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('fecha_fin') }}
                                    </div>
                                @endif
                            </div>
                        </div>


                        <div class="mt-5">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

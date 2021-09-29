@extends('layouts.app')

@section('content')
<div class="page-info">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('clinicas.index') }}">Clínicas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Crear</li>
        </ol>
    </nav>
</div>
<div class="main-wrapper">
    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nueva clínica</h5>

                    <form action="{{ route('clinicas.store') }}" method="POST">

                        @csrf

                        <div class="form-group">
                            <label>Nombre</label>
                            <input
                                type="text"
                                class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
                                name="nombre"
                                value="{{ old('nombre') ?? old('nombre') }}"
                                required
                            >

                            @if ($errors->has('nombre'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('nombre') }}
                                </div>
                            @endif
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

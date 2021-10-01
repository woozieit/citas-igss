@extends('layouts.app')

@section('content')
<div class="page-info">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar</li>
        </ol>
    </nav>
</div>
<div class="main-wrapper">
    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Editar usuario</h5>

                    <form action="{{ route('usuarios.update', $user->id) }}" method="POST">

                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Nombres y apellidos</label>
                            <input
                                type="text"
                                class="form-control {{ $errors->has('nombres_apellidos') ? 'is-invalid' : '' }}"
                                name="nombres_apellidos"
                                value="{{ old('nombres_apellidos') ? old('nombres_apellidos') : $user->nombres_apellidos }}"
                                required
                            >

                            @if ($errors->has('nombres_apellidos'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('nombres_apellidos') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>DPI</label>
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('dpi') ? 'is-invalid' : '' }}"
                                    name="dpi"
                                    value="{{ old('dpi') ? old('dpi') : $user->dpi }}"
                                    required
                                    minlength="13"
                                    maxlength="13"
                                >

                                @if ($errors->has('dpi'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('dpi') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label>Correo</label>
                                <input
                                    type="email"
                                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                    name="correo"
                                    value="{{ old('correo') ? old('correo') : $user->correo }}"
                                    required
                                >

                                @if ($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Rol</label>
                                <select name="rol" class="form-control {{ $errors->has('rol') ? 'is-invalid' : '' }} custom-select" required>
                                    <option value="Admin" {{ ( old('rol') === 'Admin' ? 'selected' : $user->rol === 'Admin' ) ? 'selected' : '' }}>Admin</option>
                                    <option value="Afiliado" {{ ( old('rol') === 'Afiliado' ? 'selected' : $user->rol === 'Afiliado' ) ? 'selected' : '' }}>Afiliado</option>
                                </select>

                                @if ($errors->has('rol'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('rol') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label>Teléfono</label>
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('telefono') ? 'is-invalid' : '' }}"
                                    name="telefono"
                                    value="{{ old('telefono') ? old('telefono') : $user->telefono }}"
                                    minlength="8"
                                    maxlength="8"
                                >

                                @if ($errors->has('telefono'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('telefono') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Dirección</label>
                            <textarea class="form-control" name="direccion" rows="5">{{ old('direccion') ? old('direccion') : $user->direccion }}</textarea>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="acreditacion" name="acreditacion" {{ $user->acreditacion ? 'checked' : '' }}>
                                <label class="custom-control-label" for="acreditacion">
                                    Acreditado
                                </label>
                            </div>
                        </div>

                        <div class="mt-5">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

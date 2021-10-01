@extends('layouts.app')

@section('content')
<div class="page-info">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ver</li>
        </ol>
    </nav>
</div>
<div class="main-wrapper">
    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Detalle del usuario</h5>

                    <div class="tab-content p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th class="width-25"> Nombres y Apellidos</th> <td><strong>{{ $user->nombres_apellidos }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="width-25"> DPI</th> <td><strong>{{ $user->dpi }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="width-25"> Correo</th> <td><strong>{{ $user->correo }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="width-25"> Rol</th> <td><strong>{{ $user->rol }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="width-25"> Teléfono</th> <td><strong>{{ $user->telefono }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="width-25"> Acreditado</th> <td><strong>{{ $user->acreditacion ? 'Si' : 'No' }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="width-25"> Dirección</th> <td><strong>{{ $user->direccion }}</strong></td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="{{ route('usuarios.index') }}" class="btn btn-sm btn-secondary mt-5">Regresar</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

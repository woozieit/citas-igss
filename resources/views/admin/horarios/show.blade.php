@extends('layouts.app')

@section('content')
<div class="page-info">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('clinicas.index') }}">Clínicas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ver</li>
        </ol>
    </nav>
</div>
<div class="main-wrapper">
    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Detalle de la clínica</h5>

                    <div class="tab-content p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th class="width-25"> Nombre</th> <td><strong>{{ $clinica->nombre }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="width-25"> Estado</th> <td><strong>{{ $clinica->estado ? 'Activo' : 'Inactivo' }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="width-25"> Creado Por</th> <td><strong>{{ $clinica->user->nombres_apellidos }}</strong></td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="{{ route('clinicas.index') }}" class="btn btn-sm btn-secondary mt-5">Regresar</a>
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

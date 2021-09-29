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

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Horarios</h5>

                    <div class="tab-content p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th>Estado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clinica->horarios as $horario)
                                        <tr>
                                            <td>{{ $horario->fecha_inicio }}</td>
                                            <td>{{ $horario->fecha_fin }}</td>
                                            <td>{{ $horario->estado ? 'Ocupado' : 'Libre' }}</td>
                                            <td>
                                                <button type="button" class="btn btn-danger delete" data-url="{{ route('horarios.destroy', $horario->id) }}" data-table="horarios"><i class="far fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')

    <script>

        $('.delete').on('click', function() {
            let table = $(this).data('table');
            let url = $(this).data('url');
            sweetalert2(table, url, 1)
        });


    </script>

@endsection

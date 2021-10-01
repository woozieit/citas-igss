@extends('layouts.app')

@section('content')
<div class="page-info">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Citas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lista</li>
        </ol>
    </nav>

    <div class="page-options">
        <a href="{{ route('citas.create') }}" class="btn btn-primary">Nuevo Registro</a>
    </div>

</div>
<div class="main-wrapper">
    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Lista de citas</h5>

                    <table class="table align-items-center">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Afiliado</th>
                                <th scope="col">Clinica</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Hora</th>
                                @if ( $role === 'Admin' )
                                    <th scope="col">Creado Por</th>
                                @endif
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($citas as $cita)
                                <tr>
                                    <th scope="row">{{ $cita->id }}</th>
                                    <td>{{ $cita->afiliado->nombres_apellidos }}</td>
                                    <td>{{ $cita->clinica->nombre }}</td>
                                    <td>{{ $cita->fecha_cita }}</td>
                                    <td>{{ $cita->hora_cita }}</td>
                                    @if ( $role === 'Admin' )
                                        <td>{{ $cita->user->nombres_apellidos }}</td>
                                    @endif
                                    <td>
                                        <div class="mail-actions">
                                            <a href="{{ route('citas.edit', $cita->id) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                            @if ( $role === 'Admin' )
                                                <button type="button" class="btn btn-danger delete" data-url="{{ route('citas.destroy', $cita->id) }}" data-table="citas"><i class="far fa-trash-alt"></i></button>
                                            @endif
                                        </div>
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
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css"/>
@endsection

@section('js')

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.js"></script>

    <script>

        $(document).ready( function () {

            $('table').DataTable({
                ordering: false,
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });

            $('.delete').on('click', function() {
                let table = $(this).data('table');
                let url = $(this).data('url');
                sweetalert2(table, url, 1)
            });

        });

    </script>

@endsection

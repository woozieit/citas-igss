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

@section('js')

    <script>

        $('.delete').on('click', function() {
            let table = $(this).data('table');
            let url = $(this).data('url');
            sweetalert2(table, url, 1)
        });


    </script>

@endsection

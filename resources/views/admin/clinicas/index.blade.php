@extends('layouts.app')

@section('content')
<div class="page-info">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Clínicas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lista</li>
        </ol>
    </nav>

    <div class="page-options">
        <a href="{{ route('clinicas.create') }}" class="btn btn-primary">Nuevo Registro</a>
    </div>
</div>
<div class="main-wrapper">
    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Lista de clínicas</h5>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Creado Por</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clinicas as $clinica)
                                <tr>
                                    <th scope="row">{{ $clinica->id }}</th>
                                    <td>{{ $clinica->nombre }}</td>
                                    <td>{{ $clinica->estado ? 'Activo' : 'Inactivo' }}</td>
                                    <td>{{ $clinica->user->nombres_apellidos }}</td>
                                    <td>
                                        <div class="mail-actions">
                                            <a href="{{ route('clinicas.show', $clinica->id) }}" class="btn btn-secondary"><i class="far fa-eye"></i></a>
                                            <a href="{{ route('clinicas.edit', $clinica->id) }}" class="btn btn-info"><i class="far fa-edit"></i></a>
                                            <a href="{{ route('horarios.index', $clinica->id) }}" class="btn btn-warning"><i class="far fa-calendar"></i></a>
                                            <button type="button" class="btn btn-danger delete" data-url="{{ route('clinicas.destroy', $clinica->id) }}" data-table="clinicas"><i class="far fa-trash-alt"></i></button>
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

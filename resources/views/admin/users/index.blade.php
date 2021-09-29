@extends('layouts.app')

@section('content')
<div class="page-info">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ver</li>
        </ol>
    </nav>

    <div class="page-options">
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">Nuevo Registro</a>
    </div>

</div>
<div class="main-wrapper">
    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Lista de usuario</h5>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Usuario</th>
                                <th scope="col">DPI</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Rol</th>
                                <th scope="col">Acreditado</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td>{{ $user->nombres_apellidos }}</td>
                                    <td>{{ $user->dpi }}</td>
                                    <td>{{ $user->correo }}</td>
                                    <td>{{ $user->rol }}</td>
                                    <td>{{ $user->acreditacion ? 'Si' : 'No' }}</td>
                                    <td>
                                        <div class="mail-actions">
                                            <a href="{{ route('usuarios.show', $user->id) }}" class="btn btn-secondary"><i class="far fa-eye"></i></a>
                                            <a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-info"><i class="far fa-edit"></i></a>

                                            @if ( $user->id != 1 )
                                                <button type="button" class="btn btn-danger delete" data-url="{{ route('usuarios.destroy', $user->id) }}" data-table="users"><i class="far fa-trash-alt"></i></button>
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

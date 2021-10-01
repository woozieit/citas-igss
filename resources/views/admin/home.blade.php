@extends('layouts.app')

@section('content')
<div class="page-info">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Citas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
</div>
<div class="main-wrapper">
    <div class="row stats-row">
        @if ( $role === 'Admin' )
            <div class="col-lg-4 col-md-12">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="text-center">
                            <h5 class="card-title">{{ $cardCitas }}</h5>
                            <p class="stats-text">Citas</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="text-center">
                            <h5 class="card-title">{{ $cardClinicas }}</h5>
                            <p class="stats-text">Clínicas</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="card stats-card">
                    <div class="card-body">
                        <div class="text-center">
                            <h5 class="card-title">{{ $cardAfiliados }}</h5>
                            <p class="stats-text">Afiliados</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="row mt-5">
        <div class="col-xl">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Próximas citas</h5>

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

@extends('layouts.app')

@section('content')
<div class="page-info">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Horarios</a></li>
            <li class="breadcrumb-item active" aria-current="page">Crear</li>
        </ol>
    </nav>
</div>
<div class="main-wrapper">
    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Gestionar Horario</h5>

                    <form action="{{ route('horarios.store') }}" method="POST">

                        @csrf

                        <input type="hidden" name="clinica_id" value="{{ $id }}">

                        @if (session('errors'))
                            <div class="alert alert-danger" role="alert">
                                Los cambios se han guardado pero tener en cuenta que:
                                <ul>
                                    @foreach (session('errors') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead_light">
                                    <tr>
                                        <th scope="col">Día</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Turno Mañana</th>
                                        <th scope="col">Turno Tarde</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $horarios as $key => $horario)
                                        <tr>
                                            <td>{{ $dias[$key] }}</td>
                                            <td>
                                                <div class="custom-control custom-switch">
                                                    <input
                                                        type="checkbox"
                                                        name="estado[]"
                                                        class="custom-control-input"
                                                        value="{{ $key }}"
                                                        @if( $horario->estado ) checked @endif
                                                        id="customSwitch{{ $key }}"
                                                    >
                                                    <label class="custom-control-label" for="customSwitch{{ $key }}"></label>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="row">
                                                    <div class="col">
                                                        <select name="manana_inicio[]" class="form-control custom-select">
                                                            @for ($i = 7; $i <= 12; $i++)
                                                                <option
                                                                    value="{{ ($i < 10 ? '0': '') . $i }}:00"
                                                                    @if( $i . ':00 AM' == $horario->manana_inicio || $i . ':00 PM' == $horario->manana_inicio ) selected @endif
                                                                >
                                                                    {{ $i }}:00 @if( $i == 12 ) PM  @else AM @endif
                                                                </option>

                                                                @if ( ($i . ':30') != '12:30' )
                                                                    <option
                                                                        value="{{ ( $i < 10 ? '0' : '' ) . $i }}:30"
                                                                        @if( $i . ':30 AM' == $horario->manana_inicio || $i . ':30 PM' == $horario->manana_inicio ) selected @endif
                                                                    >
                                                                        {{ $i }}:30 @if( $i == 12 ) PM  @else AM @endif
                                                                    </option>
                                                                @endif
                                                            @endfor
                                                        </select>
                                                    </div>

                                                    <div class="col">
                                                        <select name="manana_fin[]" class="form-control custom-select">
                                                            @for ($i = 7; $i <= 12; $i++)
                                                                <option
                                                                    value="{{ ($i < 10 ? '0': '') . $i }}:00"
                                                                    @if( $i . ':00 AM' == $horario->manana_fin || $i . ':00 PM' == $horario->manana_fin ) selected @endif
                                                                >
                                                                    {{ $i }}:00 @if( $i == 12 ) PM  @else AM @endif
                                                                </option>

                                                                @if ( ($i . ':30') != '12:30' )
                                                                    <option
                                                                        value="{{ ( $i < 10 ? '0' : '' ) . $i }}:30"
                                                                        @if( $i. ':30 AM' == $horario->manana_fin || $i . ':30 PM' == $horario->manana_fin ) selected @endif
                                                                    >
                                                                        {{ $i }}:30 @if( $i == 12 ) PM  @else AM @endif
                                                                    </option>
                                                                @endif
                                                            @endfor
                                                        </select>
                                                    </div>

                                                </div>
                                            </td>

                                            <td>
                                                <div class="row">
                                                    <div class="col">
                                                        <select name="tarde_inicio[]" class="form-control custom-select">
                                                            @for ($i = 1; $i <= 3; $i++)
                                                                <option
                                                                    value="{{ $i + 12 }}:00"
                                                                    @if( $i . ':00 PM' == $horario->tarde_inicio ) selected @endif
                                                                >
                                                                    {{ $i }}:00 PM
                                                                </option>

                                                                @if ( ($i . ':30') != '3:30' )
                                                                    <option
                                                                        value="{{ $i + 12 }}:30"
                                                                        @if( $i . ':30 PM' == $horario->tarde_inicio ) selected @endif
                                                                    >
                                                                        {{ $i }}:30 PM
                                                                    </option>
                                                                @endif
                                                            @endfor
                                                        </select>
                                                    </div>

                                                    <div class="col">
                                                        <select name="tarde_fin[]" class="form-control custom-select">
                                                            @for ($i = 1; $i <= 3; $i++)
                                                                <option
                                                                    value="{{ $i + 12 }}:00"
                                                                    @if( $i . ':00 PM' == $horario->tarde_fin ) selected @endif
                                                                >
                                                                    {{ $i }}:00 PM
                                                                </option>

                                                                @if ( ($i . ':30') != '3:30' )
                                                                    <option
                                                                        value="{{ $i + 12 }}:30"
                                                                        @if( $i . ':30 PM' == $horario->tarde_fin ) selected @endif
                                                                    >
                                                                        {{ $i }}:30 PM
                                                                    </option>
                                                                @endif
                                                            @endfor
                                                        </select>
                                                    </div>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-5">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                            <a href="{{ route('clinicas.index') }}" class="btn btn-secondary ml-3">Regresar</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

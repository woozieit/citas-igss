@extends('layouts.app')

@section('content')
<div class="page-info">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('citas.index') }}">Citas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Crear</li>
        </ol>
    </nav>
</div>
<div class="main-wrapper">
    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nueva cita</h5>

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                @foreach ( $errors->all() as $error )
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('citas.store') }}" method="POST">

                        @csrf

                        @if( $role == 'Admin' )
                            <div class="form-group">
                                <label>Afiliado</label>
                                <select
                                    class="form-control select2 {{ $errors->has('afiliado_id') ? 'is-invalid' : '' }}"
                                    name="afiliado_id"
                                    required
                                >
                                    <option selected disabled>--Seleccione--</option>
                                    @foreach ($afiliados as $afiliado)
                                        <option
                                            value="{{ $afiliado->id }}"
                                            @if( old('afiliado_id') == $afiliado->id)  selected @endif
                                        >{{ $afiliado->nombres_apellidos . ' - ' . $afiliado->dpi }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('afiliado_id'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('afiliado_id') }}
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="form-group">
                            <label>Clínica</label>
                            <select class="form-control select2" id="clinica_id" name="clinica_id">
                                <option selected disabled>--Seleccione--</option>
                                @foreach ($clinicas as $clinica)
                                    <option value="{{ $clinica->id }}">{{ $clinica->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Fecha</label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                  </div>
                                <input
                                    class="form-control datepicker"
                                    placeholder="Seleccionar fecha"
                                    id="date"
                                    name="fecha_cita"
                                    type="text"
                                    value="{{ old('scheduled_date', date('Y-m-d')) }}"
                                    data-date-format="yyyy-mm-dd"
                                    data-date-start-date="{{ date('Y-m-d') }}"
                                    data-date-end-date="+30d">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Hora de atención</label>
                            <div id="hours">
                                @if ( $intervals )

                                    @foreach ($intervals['manana'] as $key => $interval)
                                        <div class="custom-control custom-radio mb-3">
                                            <input name="hora_cita" value="{{ $interval['start'] }}" class="custom-control-input" id="intervalMorning{{ $key }}" type="radio" required>
                                            <label class="custom-control-label" for="intervalMorning{{ $key }}">{{ $interval['start'] }} - {{ $interval['end'] }}</label>
                                        </div>
                                    @endforeach

                                    @foreach ($intervals['tarde'] as $key => $interval)
                                        <div class="custom-control custom-radio mb-3">
                                            <input name="hora_cita" value="{{ $interval['start'] }}" class="custom-control-input" id="intervalAfternoon{{ $key }}" type="radio" required>
                                            <label class="custom-control-label" for="intervalAfternoon{{ $key }}">{{ $interval['start'] }} - {{ $interval['end'] }}</label>
                                        </div>
                                    @endforeach

                                @else

                                    <div class="alert alert-info" role="alert">
                                        Seleccione una clínica y una fecha, para ver sus horas disponibles.
                                    </div>

                                @endif
                            </div>
                        </div>

                        <div class="mt-5">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                            <a href="{{ route('citas.index') }}" class="btn btn-secondary ml-3">Regresar</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
    <style>
        .datepicker.dropdown-menu {
            visibility: visible;
            opacity: 1;
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script>
    <script>

        let clinica, date, hours;
        let iRadio;

        const noHoursAlert = `<div class="alert alert-danger" role="alert">
            <strong>Lo sentimos!</strong> No se encontraron horas disponibles para la clínica en el día seleccionado.
        </div>`;

        clinica = $('#clinica_id');
        date = $('#date');
        hours = $('#hours');

        $(document).ready(function () {

            $('.select2').select2();

            $('.datepicker').datepicker({
                language: 'es',
                daysOfWeekDisabled: [0,6]
            });

            clinica.change( loadHours )
            date.change( loadHours )

        });

        function loadHours() {

            const clinica_id = clinica.val();
            const selectDate = date.val();
            const url = `/horarios/horas?fecha=${selectDate}&clinica_id=${clinica_id}`;

            $.getJSON( url, displayHours );
        }

        function displayHours( data ) {
            console.log(data)

            if ( !data.manana && !data.tarde || data.manana.length === 0 && data.tarde.length === 0 ) {

                hours.html(noHoursAlert);
                return;
            }

            let htmlHours = '';
            iRadio = 0;

            if ( data.manana ) {
                const manana_intervals = data.manana;

                manana_intervals.forEach(interval => {
                    htmlHours += getRadioIntervalHtml(interval);
                });
            }

            if ( data.tarde ) {
                const tarde_intervals = data.tarde;

                tarde_intervals.forEach(interval => {
                    htmlHours += getRadioIntervalHtml(interval);
                });
            }

            hours.html(htmlHours);
        }

        function getRadioIntervalHtml(interval) {
            const text = `${interval.start} - ${interval.end}`;

            return `<div class="custom-control custom-radio mb-3">
                    <input name="hora_cita" value="${interval.start}" class="custom-control-input" id="interval${iRadio}" type="radio" required>
                    <label class="custom-control-label" for="interval${iRadio++}">${text}</label>
                </div>`;
        }

    </script>
@endsection

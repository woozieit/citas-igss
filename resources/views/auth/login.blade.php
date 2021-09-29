@extends('layouts.auth')

@section('content')

<div class="auth-form">
    <div class="row">
        <div class="col">
            <div class="logo-box"><a href="#" class="logo-text">Login Citas IGSS</a></div>

            @if ( Session::has('credentials') )
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('credentials') }}
                </div>

            @endif

            <form method="POST" action="{{ route('login') }}">

                @csrf

                <div class="form-group">
                    <input type="text" class="form-control {{ $errors->has('dpi') ? 'is-invalid' : '' }}" name="dpi" aria-describedby="emailHelp" placeholder="Ingrese usuario">

                    @if ($errors->has('dpi'))
                        <div class="invalid-feedback">
                            {{ $errors->first('dpi') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" placeholder="Ingrese Contraseña">

                    @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-submit">Ingresar</button>

            </form>
        </div>
    </div>
</div>
@endsection

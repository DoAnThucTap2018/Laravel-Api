@extends('backpack::master')

<!-- Main Content -->
@section('content')

    <body class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href=""><b>Cyber</b>Air</a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Forget Password</p>
            <form role="form" method="POST" action="{{ route('backpack.auth.password.email') }}">
                {!! csrf_field() !!}
                <div class="form-group has-feedback">
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control" name="email"  value="{{ old('email') }}" placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-flat">
                    <i class="fa fa-btn fa-envelope"></i> {{ trans('backpack::base.send_reset_link') }}
                </button>
                <a href="{{ url(config('backpack.base.route_prefix', 'admin').'/login') }}" class="btn btn-primary btn-block btn-flat"> <i class="fa fa-btn fa-sign-out"></i> Back to Login</a>
            </form></div>
    </div>
@endsection

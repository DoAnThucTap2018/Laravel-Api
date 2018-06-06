@extends('backpack::master')

@section('content')
    <body class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href=""><b>Cyber</b>Air</a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Reset Password</p>
            <form role="form" method="POST" action="{{ route('backpack.auth.password.reset') }}">
                {!! csrf_field() !!}
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group has-feedback">
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="email" class="form-control" name="email" value="{{ $email or old('email') }}" placeholder="Email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                 <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Retype password">
                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-flat">
                    <i class="fa fa-btn fa-refresh"></i> {{ trans('backpack::base.reset_password') }}
                </button>
            </form>
        </div>
    </div>
@endsection
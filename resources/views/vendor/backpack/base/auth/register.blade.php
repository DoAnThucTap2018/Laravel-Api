@extends('backpack::master')

@section('content')
    <div class="hold-transition register-page">
        <div class="register-box">
            <div class="register-logo">
                <a href=""><b>Cyber</b>Air</a>
            </div>

            <div class="register-box-body">
                <p class="login-box-msg">Register a new membership</p>

                <form action="" role="form" method="POST" action="{{ route('backpack.auth.register') }}">
                    <div class="form-group has-feedback">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="Firts name">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            @if ($errors->has('firts_name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('firts_name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Last name">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="form-group{{ $errors->has(backpack_authentication_column()) ? ' has-error' : '' }}">
                            <input type="{{ backpack_authentication_column()=='email'?'email':'text'}}" class="form-control" name="{{ backpack_authentication_column() }}" value="{{ old(backpack_authentication_column()) }}" placeholder="Email">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            @if ($errors->has(backpack_authentication_column()))
                                <span class="help-block">
                                 <strong>{{ $errors->first(backpack_authentication_column()) }}</strong>
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
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox"> I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">
                                <i class="fa fa-btn fa-user"></i> {{ trans('backpack::base.register') }}
                            </button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <a href="{{ url(config('backpack.base.route_prefix', 'admin').'/login') }}" class="text-center">I already have a membership</a>
            </div>
            <!-- /.form-box -->
        </div>
    </div>
@endsection

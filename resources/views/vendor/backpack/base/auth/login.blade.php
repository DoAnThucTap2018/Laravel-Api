@extends('backpack::master')

@section('content')
    <div class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href=""><b>Cyber</b>Air</a>
        </div>
        <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form  role="form" method="POST" action="{{ route('backpack.auth.login') }}">
                    {!! csrf_field() !!}

                    <div class="form-group has-feedback{{ $errors->has($username) ? ' has-error' : '' }}">


                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" name="{{ $username }}" value="{{ old($username) }}"
                                   placeholder="Email">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                            @if ($errors->has($username))
                                <span class="help-block">
                                        <strong>{{ $errors->first($username) }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">


                        <div class="form-group has-feedback">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox" name="remember"> {{ trans('backpack::base.remember_me') }}
                                </label>
                            </div>
                        </div>


                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">
                            {{ trans('backpack::base.login') }}
                        </button>
                    </div>
                    </div>

                </form>
                <p class="mb-1">
                    @if (backpack_users_have_email())
                        <a href="{{ route('backpack.auth.password.reset') }}">{{ trans('backpack::base.forgot_your_password') }}</a>
                    @endif
                </p>
                {{--<p class="mb-0">--}}
                    {{--<a href="{{ route('backpack.auth.register') }}" class="text-center">Register a new membership</a>--}}
                {{--</p>--}}
            </div>
        </div>
    </div>
@endsection

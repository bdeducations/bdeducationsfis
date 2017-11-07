@extends('layouts.login')

@section('content')
<div class="login-box-body">
    <form class="" role="form" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
      <div class="form-group has-feedback">
        <input type="email" id="email" name="email" class="form-control" placeholder="E-Mail Address" value="{{ old('email') }}" required autofocus>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <!--div class="checkbox icheck">
            <label>
              <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
            </label>
          </div-->
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <!--a href="{{ route('password.request') }}">I forgot my password</a-->
</div>
@endsection

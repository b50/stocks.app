<html>
@include('header')
<body>
<div id="loginBackground"></div>
<div class="container">
  <div class="centre" id="login">
    <div class="header">{{ _('Login') }}
      <div class="pull-right">
        <img id="logo" src="/images/logo.png" alt="">
        RTS
      </div>
    </div>
    <form method="POST" action="/auth/login" id="login-form">
      {!! csrf_field() !!}

      <div class="form-group @if($errors->first('email')) has-error @endif">
        <label for="inputEmail" class="control-label">
          {{ _('Email') }}
        </label>
        <input type="email" class="form-control" id="inputEmail"
               placeholder="Email" name="email"
               value="{{ old('email') }}">
        @if($errors->first('email'))
          <span class="help-block">{{ $errors->first('email') }}</span>
        @endif
      </div>

      <div class="form-group @if($errors->first('password')) has-error @endif">
        <label for="inputPassword"
               class="control-label">{{ _('Password') }}</label>
        <input type="password" class="form-control" id="inputPassword"
               placeholder="Password" name="password">
        @if($errors->first('password'))
          <span class="help-block">{{ $errors->first('password') }}</span>
        @endif
      </div>

      <div class="form-group">
        <input type="checkbox" name="remember"
               @if(old('remember')) checked @endif> Remember Me
      </div>
      <div class="form-group">
        <button class="btn btn-default" type="submit">Login</button>
      </div>
    </form>
  </div>
</div>
</body>
</html>


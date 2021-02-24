@extends('layout.authentication')
@section('title', 'Login')


@section('content')

<div class="vertical-align-wrap">
	<div class="vertical-align-middle auth-main">
		<div class="auth-box">
            <div class="top">
                <img src="{{url('/')}}/assets/img/logo-white.png" alt="La Mesa">
            </div>
			<div class="card">
                <div class="header">
                    <p class="lead">Admin account Login</p>
                </div>
                <div class="body">
                    <form class="form-auth-small" method="POST" action=" {{ route('admin.login.submit') }}">
                        @csrf
                        <div class="form-group">
                            <label for="signin-email" class="control-label sr-only">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label for="signin-password" class="control-label sr-only">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        {{-- <div class="form-group clearfix">
                            <label class="fancy-checkbox element-left">
                                <input type="checkbox">
                                <span>Remember me</span>
                            </label>								
                        </div> --}}
                        <button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
                        <div class="bottom">
                            
                            <span>Don't have an account? <a href="{{route('admin.register')}}">Register As Admin</a></span>
                        </div>
                    </form>
                </div>
            </div>
		</div>
	</div>
</div>

@stop
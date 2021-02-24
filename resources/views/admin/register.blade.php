@extends('layout.authentication')
@section('title', 'Register')


@section('content')

<div class="vertical-align-wrap">
	<div class="vertical-align-middle auth-main">
		<div class="auth-box" style="width: 500px">
            <div class="top">
                <img src="{{url('/')}}/assets/img/logo-white.png" alt="LaMesa">
            </div>
			<div class="card">
                <div class="header">
                    <p class="lead">Create an Admin account</p>
                </div>
                
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <br /> 
                @endif

                <div class="body">
                    <form method="POST" action=" {{ route('admin.register.submit') }}" validate class="form-auth-small">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">First Name</label>
                                <input type="text" class="form-control" name="f_name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Last Name</label>
                                <input type="text" class="form-control" name="l_name" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputAddress">Contact</label>
                                <input type="text" class="form-control" name="contact" >
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputAddress">Company</label>
                                <input type="text" class="form-control" name="company">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Company Address</label>
                            <input type="text" class="form-control" name="comaddress">
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Company Contact</label>
                            <input type="text" class="form-control" name="comcontact">
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block">REGISTER</button>
                        <div class="bottom">
                            <span class="helper-text">Already have an account? <a href="{{route('admin.login')}}">Login</a></span>
                        </div>
                    </form>
                </div>
            </div>
		</div>
	</div>
</div>

@stop
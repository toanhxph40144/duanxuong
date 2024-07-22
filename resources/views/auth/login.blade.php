@extends('layouts.auth')

@section('content')
	<section class="fxt-template-animation fxt-template-layout9" data-bg-image="{{asset('assets/auth/img/figure/bg9-l.jpg')}}">
		<div class="container">
			<div class="row align-items-center justify-content-center">
				<div class="col-lg-3">
					<div class="fxt-header">
						<a href="login-9.html" class="fxt-logo"><img src="{{asset('assets/auth/img/logo-9.png')}}" alt="Logo"></a>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="fxt-content">
						<h2>Login into your account</h2>
						<div class="fxt-form">
							<form method="POST" action="{{route ('login')}}">
								@csrf
								<div class="form-group">
									<div class="fxt-transformY-50 fxt-transition-delay-1">
										<input type="email" id="email" class="form-control" name="email" 
										    value="{{old('email')}}" placeholder="Email" required="required" autocomplete="email">
											@error('email')
												  <p class="text-danger"> {{$message}}</p>
											@enderror
									</div>
								</div>
								<div class="form-group">
									<div class="fxt-transformY-50 fxt-transition-delay-2">
										<input id="password" type="password" class="form-control" name="password" placeholder="********" required="required">
										<i toggle="#password" class="fa fa-fw fa-eye toggle-password field-icon"></i>
									</div>
									@error('password')
												  <p class="text-danger"> {{$message}}</p>
											@enderror
								</div>
								<div class="form-group">
									<div class="fxt-transformY-50 fxt-transition-delay-3">
										<div class="fxt-checkbox-area">
											<div class="checkbox">
												<input id="checkbox1" type="checkbox">
												<label for="checkbox1">Keep me logged in</label>
											</div>
											<a href="forgot-password-9.html" class="switcher-text">Forgot Password</a>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="fxt-transformY-50 fxt-transition-delay-4">
										<button type="submit" class="fxt-btn-fill">Log in</button>
									</div>
								</div>
							</form>
						</div>
						<div class="fxt-footer">
							<div class="fxt-transformY-50 fxt-transition-delay-9">
								<p>Don't have an account?<a href="register-9.html" class="switcher-text2 inline-text">Register</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection	
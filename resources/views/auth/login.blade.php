@extends('template.header')
@section('section')
<div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body">
        <div class="auth-wrapper auth-cover">
            <div class="auth-inner row m-0">
                <!-- Brand logo--><a class="brand-logo" href="index-2.html">
                    
                    <h2 class="brand-text text-primary ms-1 text-bold">Alpha Digital</h2>
                </a>
                <!-- /Brand logo-->
                <!-- Left Text-->
                <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                    <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img class="img-fluid" src="https://pixinvent.com/demo/vuexy-html-bootstrap-admin-template/app-assets/images/pages/login-v2.svg" alt="Login V2" /></div>
                </div>
                <!-- /Left Text-->
                <!-- Login-->
                <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                        <h2 class="card-title fw-bold mb-1">Welcome 👋</h2>
                        <p class="card-text mb-2">Please sign-in to your account to continue</p>
                        
                        <form class="mt-2" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-1">
                                <label class="form-label" for="login-email">Email</label>
                                <input class="@error('email') is-invalid @enderror form-control" id="email" type="text" name="email" placeholder="john@example.com" aria-describedby="login-email" autofocus="" tabindex="1" />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-1">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="login-password">Passworssd</label><a href="auth-forgot-password-cover.html"><small>Forgot Password?</small></a>
                                </div>
                                <div class="input-group input-group-merge form-password-toggle">
                                    <input class="@error('password') is-invalid @enderror form-control form-control-merge" id="password" type="password" name="password" placeholder="············" aria-describedby="login-password" tabindex="2" /><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <div class="mb-1">
                                <div class="form-check">
                                    <input class="form-check-input" id="remember-me" type="checkbox" tabindex="3" />
                                    <label class="form-check-label" for="remember-me"> Remember Me</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" tabindex="4">Sign in</button>
                        </form>
                        <!-- <p class="text-center mt-2"><a href="{{route('register')}}"><span>&nbsp;Create an account</span></a></p> -->
                        <!-- <div class="divider my-2">
                            <div class="divider-text">or</div>
                        </div> -->
                        <!-- <div class="auth-footer-btn d-flex justify-content-center"><a class="btn btn-facebook" href="#"><i data-feather="facebook"></i></a><a class="btn btn-twitter white" href="#"><i data-feather="twitter"></i></a><a class="btn btn-google" href="#"><i data-feather="mail"></i></a><a class="btn btn-github" href="#"><i data-feather="github"></i></a></div> -->
                    </div>
                </div>
                <!-- /Login-->
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layout.layout')

@section('content')


    <div class="az-signin-wrapper mt-5">
      <div class="az-card-signin">
        @if(Session::has('error'))
          <div class="alert alert-danger" role="alert">
              {{ Session::get('error') }}
          </div>
        @endif
        <h1 class="az-logo">BukuKu</h1>
        <div class="az-signin-header">
          <h2>Welcome back!</h2>
          <h4>Please sign in to continue</h4>

          <form action="{{url('signinProcess')}}" method="post">
            @csrf
            <div class="form-group">
              <label>Email</label>
              <input type="text" class="form-control" name="email" placeholder="Enter your email" >
            </div><!-- form-group -->
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" name="password" placeholder="Enter your password" >
            </div><!-- form-group -->
            <button class="btn btn-az-primary btn-block">Sign In</button>
          </form>
        </div><!-- az-signin-header -->
        <div class="az-signin-footer">
          <p><a href="">Forgot password?</a></p>
          <p>Don't have an account? <a href="{{url('/signup')}}">Create an Account</a></p>
        </div><!-- az-signin-footer -->
      </div><!-- az-card-signin -->
    </div><!-- az-signin-wrapper -->

@endsection
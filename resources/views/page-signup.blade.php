@extends('layout.layout')

@section('content')

    <div class="az-signup-wrapper">
      <div class="az-column-signup-left">
        <div>
          <i class="typcn typcn-chart-bar-outline"></i>
          <h1 class="az-logo">Bukuku</h1>
          <h5>Modern Dashboard </h5>
          
          <a href="#" class="btn btn-outline-indigo">Learn More</a>
        </div>
      </div><!-- az-column-signup-left -->
      <div class="az-column-signup">
        <h1 class="az-logo">Bukuku</h1>

        <div class="az-signup-header">
          <h2>Get Started</h2>
          <h4>It's free to signup and only takes a minute.</h4>

          <form action="{{url('signupProcess')}}" method="POST">
            @csrf
            <div class="form-group">
              <label>Firstname &amp; Lastname</label>
              <input type="text" class="form-control" name="name" placeholder="Enter your firstname and lastname">
            </div><!-- form-group -->
            <div class="form-group">
              <label>Email</label>
              <input type="text" class="form-control" name="email" placeholder="Enter your email">
            </div><!-- form-group -->
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" name="password" placeholder="Enter your password">
            </div><!-- form-group -->
            <button class="btn btn-az-primary btn-block">Create Account</button>
            <!-- <div class="row row-xs">
              <div class="col-sm-6"><button class="btn btn-block"><i class="fab fa-facebook-f"></i> Signup with Facebook</button></div>
              <div class="col-sm-6 mg-t-10 mg-sm-t-0"><button class="btn btn-primary btn-block"><i class="fab fa-twitter"></i> Signup with Twitter</button></div>
            </div> -->
          </form>
        </div><!-- az-signup-header -->
        <div class="az-signup-footer">
          <p>Already have an account? <a href="{{url('/signin')}}">Sign In</a></p>
        </div><!-- az-signin-footer -->
      </div><!-- az-column-signup -->
    </div><!-- az-signup-wrapper -->

    @endsection
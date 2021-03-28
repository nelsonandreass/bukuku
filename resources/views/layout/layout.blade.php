<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <!-- Meta -->
    

    <title>BukuKu</title>

    <!-- vendor css -->
    <link rel="stylesheet" href="{{asset('/azia.css')}}">
    <link rel="stylesheet" href="{{asset('/lib/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('/lib/ionicons/css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('/lib/typicons.font/typicons.css')}}">
    <link rel="stylesheet" href="{{asset('/lib/flag-icon-css/css/flag-icon.min.css')}}">

    <!-- <link href="../lib/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="../lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="../lib/typicons.font/typicons.css" rel="stylesheet">
    <link href="../lib/flag-icon-css/css/flag-icon.min.css" rel="stylesheet"> -->

    <!-- azia CSS -->
    <link rel="stylesheet" href="{{asset('/azia.css')}}">

  </head>

  <body>
  <div class="az-header">
      <div class="container">
        <div class="az-header-left">
          <a href="index.html" class="az-logo"><span></span> BukuKu</a>
          <a href="" id="azMenuShow" class="az-header-menu-icon d-lg-none"><span></span></a>
        </div><!-- az-header-left -->
        <div class="az-header-menu">
          <ul class="nav d-block d-lg-none">
            <li class="nav-item">
              <a href="{{url('user/home')}}" class="nav-link"><i class=""></i> Home</a>
            </li>
            <li class="nav-item">
              <a href="{{url('user/itemmasuk')}}" class="nav-link"><i class=""></i> Item Masuk</a>
            </li>
            <li class="nav-item">
              <a href="{{url('user/itemkeluar')}}" class="nav-link"><i class=""></i> Item Keluar</a>
            </li>
            <li class="nav-item">
              <a href="{{url('user/stock')}}" class="nav-link"><i class=""></i> Stock</a>
            </li>
            <li class="nav-item">
              <a href="{{url('user/transaksi')}}" class="nav-link"><i class=""></i> Transaksi</a>
            </li>
            <!-- <li class="nav-item">
              <a href="" class="nav-link with-sub"><i class="typcn typcn-document"></i> Pages</a>
              <nav class="az-menu-sub">
                <a href="page-signin.html" class="nav-link">Sign In</a>
                <a href="page-signup.html" class="nav-link">Sign Up</a>
              </nav>
            </li> -->
          </ul>
        </div>
        <!-- <div class="az-header-menu">
          <div class="az-header-menu-header">
            <a href="index.html" class="az-logo"><span></span> azia</a>
            <a href="" class="close">&times;</a>
          </div>
          <ul class="nav">
            <li class="nav-item">
              <a href="index.html" class="nav-link"><i class="typcn typcn-chart-area-outline"></i> Dashboard</a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link with-sub"><i class="typcn typcn-document"></i> Pages</a>
              <nav class="az-menu-sub">
                <a href="page-signin.html" class="nav-link">Sign In</a>
                <a href="page-signup.html" class="nav-link">Sign Up</a>
              </nav>
            </li>
            <li class="nav-item">
              <a href="chart-chartjs.html" class="nav-link"><i class="typcn typcn-chart-bar-outline"></i> Charts</a>
            </li>
            <li class="nav-item">
              <a href="form-elements.html" class="nav-link"><i class="typcn typcn-chart-bar-outline"></i> Forms</a>
            </li>
            <li class="nav-item active">
              <a href="" class="nav-link with-sub"><i class="typcn typcn-book"></i> Components</a>
              <div class="az-menu-sub">
                <div class="container">
                  <div>
                    <nav class="nav">
                      <a href="elem-buttons.html" class="nav-link">Buttons</a>
                      <a href="elem-dropdown.html" class="nav-link">Dropdown</a>
                      <a href="elem-icons.html" class="nav-link">Icons</a>
                      <a href="table-basic.html" class="nav-link">Table</a>
                    </nav>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div> -->
        <div class="az-header-right">
          <!-- <a href="https://www.bootstrapdash.com/demo/azia-free/docs/documentation.html" target="_blank" class="az-header-search-link"><i class="far fa-file-alt"></i></a>
          <a href="" class="az-header-search-link"><i class="fas fa-search"></i></a> -->
          <!-- <div class="az-header-message">
            <a href="#"><i class="typcn typcn-messages"></i></a>
          </div> -->
          <!-- <div class="dropdown az-header-notification">
            <a href="" class="new"><i class="typcn typcn-bell"></i></a>
            <div class="dropdown-menu">
              <div class="az-dropdown-header mg-b-20 d-sm-none">
                <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
              </div>
              <h6 class="az-notification-title">Notifications</h6>
              <p class="az-notification-text">You have 2 unread notification</p>
              <div class="az-notification-list">
                <div class="media new">
                  <div class="az-img-user"><img src="../img/faces/face2.jpg" alt=""></div>
                  <div class="media-body">
                    <p>Congratulate <strong>Socrates Itumay</strong> for work anniversaries</p>
                    <span>Mar 15 12:32pm</span>
                  </div>
                </div>
                <div class="media new">
                  <div class="az-img-user online"><img src="../img/faces/face3.jpg" alt=""></div>
                  <div class="media-body">
                    <p><strong>Joyce Chua</strong> just created a new blog post</p>
                    <span>Mar 13 04:16am</span>
                  </div>
                </div>
                <div class="media">
                  <div class="az-img-user"><img src="../img/faces/face4.jpg" alt=""></div>
                  <div class="media-body">
                    <p><strong>Althea Cabardo</strong> just created a new blog post</p>
                    <span>Mar 13 02:56am</span>
                  </div>
                </div>
                <div class="media">
                  <div class="az-img-user"><img src="../img/faces/face5.jpg" alt=""></div>
                  <div class="media-body">
                    <p><strong>Adrian Monino</strong> added new comment on your photo</p>
                    <span>Mar 12 10:40pm</span>
                  </div>
                </div>
              </div>
              <div class="dropdown-footer"><a href="">View All Notifications</a></div>
            </div>
          </div> -->
          @guest
            <a href="{{url('/signin')}}" class="btn btn-az-primary">Sign in</a>
          @else
          <div class="dropdown az-profile-menu">
            <a href="#" ><i class="typcn typcn-user-outline"></i></a>
            <div class="dropdown-menu">
              <div class="az-dropdown-header d-sm-none">
                <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
              </div>
             
              <a href="{{url('/signout')}}" class="dropdown-item"><i class="typcn typcn-power-outline"></i> Sign Out</a>
            </div><!-- dropdown-menu -->
          </div>
          @endguest
        </div><!-- az-header-right -->
      </div><!-- container -->
    </div>

    @yield('content')
   
    <script src=" {{ URL::asset('/lib/jquery/jquery.min.js') }}"></script>
    <script src=" {{ URL::asset('/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src=" {{ URL::asset('/lib/ionicons/ionicons.js') }}"></script>
    <script src=" {{ URL::asset('/lib/jquery.flot/jquery.flot.js') }}"></script>
    <script src=" {{ URL::asset('/lib/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src=" {{ URL::asset('/lib/chart.js/Chart.bundle.min.js') }}"></script>
    <script src=" {{ URL::asset('/lib/peity/jquery.peity.min.js') }}"></script>

    <script src=" {{ URL::asset('/js/azia.js') }}"></script>
    <script src=" {{ URL::asset('/js/chart.flot.sampledata.js') }}"></script>
    <script src=" {{ URL::asset('/js/dashboard.sampledata.js') }}"></script>
    <script src=" {{ URL::asset('/js/jquery.cookie.js" type="text/javascript') }}"></script>
    <script src=" {{ URL::asset('/js/chart.chartjs.js') }}"></script>





    <!-- <script src="../lib/jquery/jquery.min.js"></script>
    <script src="../lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/ionicons/ionicons.js"></script>
    <script src="../lib/jquery.flot/jquery.flot.js"></script>
    <script src="../lib/jquery.flot/jquery.flot.resize.js"></script>
    <script src="../lib/chart.js/Chart.bundle.min.js"></script>
    <script src="../lib/peity/jquery.peity.min.js"></script> -->
    
    <!-- <script src="../js/azia.js"></script>
    <script src="../js/chart.flot.sampledata.js"></script>
    <script src="../js/dashboard.sampledata.js"></script>
    <script src="../js/jquery.cookie.js" type="text/javascript"></script>
    <script src="../js/chart.chartjs.js"></script> -->

    
  </body>

</html>
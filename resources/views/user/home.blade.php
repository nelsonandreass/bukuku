@extends('layout.layout')

@section('content')
@include('parts.leftmenu')
<div class="az-content-body pd-lg-l-40 d-flex flex-column">
  <div class="az-content-breadcrumb">
    <span><a href="{{url('user/home')}}">User</a></span>
    <span>Home</span>
  </div>
 
  <div class="az-content">
    <div class="row">
      <div class="col-md-3">
        <a href="{{url('user/transaksi')}}" class=""style="text-decoration: none;color: #031b4e;">
          <div class="card mb-3">
            <div class="card-header text-center">
              Jumlah Transaksi bulan ini 
            </div>
            <div class="card-body text-center">
              
                {{$count}} Transaksi
            
            </div>
          </div> 
        </a>
      </div>
      <div class="col-md-3">
        <div class="card mb-3">
          <div class="card-header text-center">
            Pengeluaran bulan ini 
          </div>
          <div class="card-body text-center">
              Rp. {{$expense}}
          </div>
        </div> 
      </div>
      <div class="col-md-3">
        <div class="card mb-3">
          <div class="card-header text-center">
            Pemasukan bulan ini 
          </div>
          <div class="card-body text-center">
            Rp. {{$income}}
          </div>
        </div> 
      </div>
      <div class="col-md-3">
        <a href="{{url('user/reportprofit')}}" class=""style="text-decoration: none;color: #031b4e;">
          <div class="card mb-3">
            <div class="card-header text-center">
              Keuntungan bulan ini 
            </div>
            <div class="card-body text-center">
              Rp. {{$profit}}
            </div>
          </div> 
        </a>
      </div>
    </div>
    
    <div class="row">
      <div class="col-12">
        <form action="{{url('user/tutupbuku')}}" method="post">
          @csrf
          <button href="{{url('user/tutupbuku')}}" class="btn btn-primary">Closing bulan ini</button>
        </form>
       
      </div>
    </div>
  </div>
 
</div>


@endsection
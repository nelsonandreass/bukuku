@extends('layout.layout')

@section('content')
@include('parts.leftmenu')
<div class="az-content-body pd-lg-l-40 d-flex flex-column">
  <div class="az-content-breadcrumb">
    <span><a href="{{url('user/home')}}">User</a></span>
    <span>Chart Profit</span>
  </div>
 
  <div class="az-content">
      <form action="{{url('/user/reportoutcome/filter')}}" method="post">
        @csrf
        <div class="row">
          <div class="col-6">
            <select name="period" id="" class="form-control">
              <option value="3">3 Bulan</option>
              <option value="6">6 Bulan</option>
              <option value="12">1 Tahun</option>
            </select>
          </div>
          <div class="col-3">
            <button class="btn btn-primary">Filter</button>
          </div>
        </div>
      </form>

    <div class="row mt-3">
      <div class="col-md-12">
        <canvas id="myChart" height="100%"></canvas>

      </div>
    </div>   
  </div>
    
</div>

@include('parts.chart')

@endsection
@extends('layout.layout')

@section('content')
@include('parts.leftmenu')

<div class="az-content-body pd-lg-l-40 d-flex flex-column">
  <div class="az-content-breadcrumb">
    <span><a href="{{url('user/home')}}">User</a></span>
    <span>Transaksi</span>
  </div>

  <div class="row">
    <div class="col-4">Tanggal mulai</div>
    <div class="col-4">Tanggal Akhir</div>

  </div>
  <form action="{{url('/user/transaksi/filter')}}" method="post">
    @csrf
    <div class="row">
      <div class="col-4"><input type="date" name="tanggalmulai"class="form-control"></div>
      <div class="col-4"><input type="date" name="tanggalakhir"class="form-control"></div>

      <div class="col-4"><button class="btn btn-primary">Filter</button></div>
    </div>
  </form>

  <div class="table-responsive mt-3">
    <table class="table table-striped mg-b-0">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Item</th>
          <th>Jenis</th>
          <th>Jumlah</th>
          <th>Harga</th>
        </tr>
      </thead>
      <tbody>
        @foreach($items as $item)
          <tr>
            <th>{{$item->created_at}}</th>
            <td>{{$item->stock->item_name}}</td>
            <td>{{$item->inout}}</td>
            <td>{{$item->amount}}</td>
            <td>Rp. {{$item->totalprice}}</td>
          </tr>
        @endforeach
       
      </tbody>
    </table>
  </div>
</div>

@endsection
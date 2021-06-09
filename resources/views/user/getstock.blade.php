@extends('layout.layout')

@section('content')
@include('parts.leftmenu')
<div class="az-content-body pd-lg-l-40 d-flex flex-column">
  <div class="az-content-breadcrumb">
    <span><a href="{{url('user/home')}}">User</a></span>
    <span><a href="{{url('user/stock')}}" style="text-decoration:none;">Stock</a></span>
    <span>Tambah item</span>
  </div>
  @if(Session::has('error'))
      <div class="alert alert-danger" role="alert">
          {{ Session::get('error') }}
      </div>
    @elseif(Session::has('success'))
      <div class="alert alert-success" role="alert">
          {{ Session::get('success') }}
      </div>
    @endif
  <form action="{{url('/user/stock/update')}}" method="post">
  @csrf
      <input type="hidden" value="{{$item->id}}" name="item_id">
      <label for="">Nama Item</label>
      <input class="form-control" placeholder="" name="name" type="text" value="{{$item->item_name}}">
      
      <label for="" class="mt-2">Harga Masuk</label>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text">Rp.</span>
        </div>
        <input class="form-control" placeholder="" name="hargamasuk" type="number" value="{{$item->item_price_in}}">
      </div>

      <label for="" class="mt-2">Harga Keluar</label>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text">Rp.</span>
        </div>
        <input class="form-control" placeholder="" name="hargakeluar" type="number" value="{{$item->item_price_out}}">
      </div>

      <label for="" class="mt-2">Jumlah Stock</label>
      <input class="form-control" name="jumlahstock" type="number" value="{{$item->item_stock}}">

      <div class="col-sm-6 col-md-3"><button class="btn btn-indigo btn-rounded btn-block mt-4">Simpan</button></div>
    </form>
  
</div>

@endsection
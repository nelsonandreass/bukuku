@extends('layout.layout')

@section('content')
@include('parts.leftmenu')
<div class="az-content-body pd-lg-l-40 d-flex flex-column">
  <div class="az-content-breadcrumb">
    <span><a href="{{url('user/home')}}">User</a></span>
    <span>Stock</span>
  </div>

  <div class="row ">
    <div class="col-sm-6 col-md-3 mb-3" ><a href="{{url('/user/tambahitem')}}" class="btn btn-az-primary btn-with-icon btn-block"><i class="typcn typcn-edit"></i> Input Stock</a></div>
    <div class="col-sm-6 col-md-3 mb-3" ><a href="{{url('/user/tambahitembaru')}}" class="btn btn-success btn-with-icon btn-block"><i class="typcn typcn-edit"></i> Tambah Item Baru</a></div>
  </div>

  <div class="table-responsive mt-3">
  
    <table class="table table-striped mg-b-0">
      <thead>
        <tr>
          <th>Nomor</th>
          <th>Item</th>
          <th>Modal</th>
          <th>Harga Jual</th>
          <th>Stock</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $index = 1;?>
        @foreach($items as $item)
          <tr>
            <th>{{$index}}</th>
            <td>{{$item->item_name}}</td>
            <td>Rp. {{$item->item_price_in}}</td>
            <td>Rp. {{$item->item_price_out}}</td>
            <td>{{$item->item_stock}}</td>
            <td><a href="{{url('user/get/stock'  , $item->id)}}" class="btn btn-success">Edit</a></td>
          </tr>
          <?php $index++;?>
        @endforeach
       
      </tbody>
    </table>
  </div>
</div>

@endsection
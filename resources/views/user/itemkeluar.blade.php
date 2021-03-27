@extends('layout.layout')

@section('content')
@include('parts.leftmenu')

<div class="az-content-body pd-lg-l-40 ">
  <div class="az-content-breadcrumb">
    <span><a href="{{url('user/home')}}">User</a></span>
    <span>Item keluar</span>
  </div>

  <!-- <div class="notif">
    test
  </div> -->
  
  <div class="az-content pl-3 mt-2">
    <form action="{{url('/user/itemkeluarprocess')}}" method="post">
      @csrf
      <label for="">Nama Item</label>
      <select id="option" name="itemid" class="form-control select2-no-search" onchange="calculate()">
        <option label="Choose one"></option>
        @foreach($items as $item)
          <option  value="{{$item->id}},{{$item->item_price_out}}">{{$item->item_name}}</option>
        @endforeach
        
      </select>
      <label for="" class="mt-2">Jumlah item</label>
      <input class="form-control" placeholder="" name="amount" id="jumlahitem" type="number" onchange="calculate()";>

      <label for="" class="mt-2">Total Harga</label>
      <input class="form-control" readonly id="totalharga" name="totalprice" type="number">

      <div class="col-sm-6 col-md-3"><button class="btn btn-indigo btn-rounded btn-block mt-4">Simpan</button></div>
    </form>
  </div>
  
</div>

<script>
  
  function calculate(){
    var hargaitem = document.getElementById("option").value.split(',',2)[1];
    var jumlahitem = document.getElementById("jumlahitem").value;
    var harga = hargaitem * jumlahitem;
    var totalharga = document.getElementById("totalharga").value=harga;
    console.log(hargaitem);
  }
 
</script>
@endsection
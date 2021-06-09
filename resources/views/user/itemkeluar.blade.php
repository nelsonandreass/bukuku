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
    @if(Session::has('error'))
      <div class="alert alert-danger" role="alert">
          {{ Session::get('error') }}
      </div>
    @elseif(Session::has('success'))
      <div class="alert alert-success" role="alert">
          {{ Session::get('success') }}
      </div>
    @endif
    
    <div class="row mb-3">
      <div class="col-2">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="radio" id="cash" onclick="check()" checked>
          <label class="form-check-label" for="cash">
            Cash
          </label>
        </div>
      </div>
      <div class="col-2">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="radio" id="tempo" onclick="check()">
          <label class="form-check-label" for="tempo">
            Tempo
          </label>
        </div>
      </div>
    </div>
    <!-- form tempo -->
    <form id="form-tempo" action="{{url('/user/itemkeluartempoprocess')}}" method="post" style="display: none;">
      @csrf
      <label for="" class="mt-2">Nama Customer</label>
      <input class="form-control" placeholder="" name="nama" id="nama" type="text";>

      <label for="">Nama Item</label>
      <select id="optiontempo" name="itemid" class="form-control select2-no-search" onchange="calculatetempo()">
        <option label="Choose one"></option>
        @foreach($items as $item)
          <option  value="{{$item->id}},{{$item->item_price_out}}">{{$item->item_name}}</option>
        @endforeach
        
      </select>
      <label for="" class="mt-2">Jumlah item</label>
      <input class="form-control" placeholder="" name="amount" id="jumlahitemtempo" type="number" onchange="calculatetempo()";>

      <label for="" class="mt-2">Total Harga</label>
      <input class="form-control" readonly id="totalhargatempo" name="totalprice" type="number">

      <div class="col-sm-6 col-md-3"><button class="btn btn-indigo btn-block mt-4">Simpan</button></div>
    </form>
    <!-- form cash -->
    <form id="form-cash" action="{{url('/user/itemkeluarprocess')}}" method="post">
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

      <div class="col-sm-6 col-md-3"><button class="btn btn-indigo btn-block mt-4">Simpan</button></div>
    </form>
  </div>
  
</div>

<script>
 
  function check(){
    var cash =  document.getElementById("cash").checked;
    var tempo =  document.getElementById("tempo").checked;  
    var formtempo =  document.getElementById("form-tempo");  
    var formcash =  document.getElementById("form-cash");  
    if(cash == true){
      formtempo.style.display = "none";
      formcash.style.display = "block";
    }
    else{
      formtempo.style.display = "block";
      formcash.style.display = "none";
    }
  }

  function calculate(){
    var hargaitem = document.getElementById("option").value.split(',',2)[1];
    var jumlahitem = document.getElementById("jumlahitem").value;
    var harga = hargaitem * jumlahitem;
    var totalharga = document.getElementById("totalharga").value=harga;
  }
 
  function calculatetempo(){
    var hargaitem = document.getElementById("optiontempo").value.split(',',2)[1];
    var jumlahitem = document.getElementById("jumlahitemtempo").value;
    var harga = hargaitem * jumlahitem;
    var totalharga = document.getElementById("totalhargatempo").value=harga;
  }
</script>
@endsection
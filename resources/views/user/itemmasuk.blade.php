@extends('layout.layout')

@section('content')
@include('parts.leftmenu')

<div class="az-content-body pd-lg-l-40 ">
  <div class="az-content-breadcrumb">
    <span><a href="{{url('user/home')}}">User</a></span>
    <span>Item masuk</span>
  </div>

  
  <div class="az-content pl-3 mt-2">
    <div>
      <div class="col-sm-6 col-md-3 mb-3" style="margin-left:-15px;"><a href="{{url('/user/tambahitembaru')}}" class="btn btn-success btn-with-icon btn-block"><i class="typcn typcn-edit"></i> Tambah Item Baru</a></div>
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
    <form action="{{url('/user/itemmasukprocess')}}" method="post">
      @csrf
      <label for="">Nama Item</label>
      <select id="option" name="itemid" class="form-control select2" onchange="calculate()">
        <option label="Choose one"></option>
        @foreach($items as $item)
          <option  value="{{$item->id}},{{$item->item_price_in}}">{{$item->item_name}}</option>
        @endforeach
        
      </select>
      <label for="" class="mt-2">Jumlah item</label>
      <input class="form-control" placeholder="" name="amount" id="jumlahitem" type="number" onchange="calculate()";>

      <label for="" class="mt-2">Total Harga</label>
      <input class="form-control" readonly id="totalharga" name="totalprice" type="number">

      <div class="col-sm-6 col-md-3"><button class="btn btn-indigo  btn-block mt-4">Simpan</button></div>
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

    <script>
      // Additional code for adding placeholder in search box of select2
      (function($) {
        var Defaults = $.fn.select2.amd.require('select2/defaults');

        $.extend(Defaults.defaults, {
          searchInputPlaceholder: ''
        });

        var SearchDropdown = $.fn.select2.amd.require('select2/dropdown/search');

        var _renderSearchDropdown = SearchDropdown.prototype.render;

        SearchDropdown.prototype.render = function(decorated) {

          // invoke parent method
          var $rendered = _renderSearchDropdown.apply(this, Array.prototype.slice.apply(arguments));

          this.$search.attr('placeholder', this.options.get('searchInputPlaceholder'));

          return $rendered;
        };

      })(window.jQuery);
    </script>

    <script>
      $(function(){
        'use strict'
        $(document).ready(function(){
          $('.select2').select2({
            placeholder: 'Choose one',
            searchInputPlaceholder: 'Search'
          });
        });
      });
    </script>
@endsection
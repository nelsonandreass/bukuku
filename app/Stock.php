<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    public function Transaksis(){
        return $this->hasMany(Transaksi::class,'item_id','id');
    }
}

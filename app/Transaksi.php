<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    public function Stock(){
        return $this->belongsTo(Stock::class,'item_id','id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cadeau extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function nature(){
        return $this->belongsTo(Nature::class);
    }

    public function implications(){
        return $this->hasMany(Implication::class);
    }

}

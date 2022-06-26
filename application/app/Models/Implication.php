<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Implication extends Model
{
    use HasFactory;

    public function cadeau(){
        return $this->belongsTo(Cadeau::class);
    }

}

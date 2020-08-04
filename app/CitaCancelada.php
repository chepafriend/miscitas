<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class CitaCancelada extends Model
{
    public function cancelado_por(){
        return $this->belongsTo(User::class);
    }
    //
}

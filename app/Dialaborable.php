<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dialaborable extends Model
{
    protected $fillable = [
        'dia', 'activo', 'inicio_manana','fin_manana', 'inicio_tarde','fin_tarde', 'user_id'
    ];
}

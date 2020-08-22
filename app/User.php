<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Cita;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $fillable = [
        'nombre', 'email', 'password','dni', 'direccion', 'telefono', 'rol'
    ];

    
    protected $hidden = [
        'password', 'remember_token', 'pivot',
         'email_verified_at', 'created_at', 'updated_at'
    ];

        protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function especialidades(){
        return $this->belongsToMany(Especialidad::class)->withTimestamps();
        }
    public function scopeDoctores($query){
        return $query->where('rol', 'doctor');
    }
    public function scopePacientes($query){
        return $query->where('rol', 'paciente');
    }

    public function citasDoctores(){
        return $this->hasMany(Cita::class, 'doctor_id');
    }

    public function citasPacientes(){
        return $this->hasMany(Cita::class, 'paciente_id');
    }

    public function citasAtendidas(){
        return $this->citasDoctores()->where('estado','atendida');
    }

    public function citasCanceladas(){
        return $this->citasDoctores()->where('estado','cancelada');
    }
}

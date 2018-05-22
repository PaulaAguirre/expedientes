<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'expediente_id','area_id','estado', 'fecha_entrada', 'observaciones', 'observaciones_regularizacion', 'aprobado_por'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       //
    ];

    public function expediente()
    {
        return $this->belongsTo ('App\Expediente');
    }

    public function area ()
    {
        return $this->belongsTo ('App\Area');
    }
}

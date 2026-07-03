<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $table = 'consultas';
    protected $primaryKey = 'id_consulta';
    public $timestamps = false;

    protected $fillable = [
        'id_paciente',
        'id_enfermedad',
        'fecha',
        'diagnostico',
        'tratamiento',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
        ];
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente', 'id_paciente');
    }

    public function enfermedad()
    {
        return $this->belongsTo(Enfermedad::class, 'id_enfermedad', 'id_enfermedad');
    }
}

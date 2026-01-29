<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'id',
        'case_id',
        'type',
        'result',
        'checks',
        'started_at',
        'assigned_to',
        'location',
        'completed_at'
    ];
    
    protected $casts = [
        'checks' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime'
    ];

    public function case()
    {
        return $this->belongsTo(Kase::class, 'case_id');
    }

    public function getTypeLabel()
    {
        return match($this->type) {
            'physical'    => 'Fiziskā pārbaude',
            'rtg'         => 'Rentgena pārbaude',
            'document'    => 'Dokumentu pārbaude',
            'screening'   => 'Sākotnējā skenēšana',
            default       => ucfirst($this->type ?? 'Pārbaude'),
        };
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    
}
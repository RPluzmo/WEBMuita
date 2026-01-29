<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kase extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'id',
        'external_ref',
        'status',
        'priority',
        'arrival_ts',
        'checkpoint_id',
        'origin_country',
        'destination_country',
        'risk_flags',
        'vehicle_id',
        'declarant_id',
        'consignee_id'
    ];
    
    protected $casts = [
        'risk_flags' => 'array',
        'arrival_ts' => 'datetime'
    ];

    public function vehicle() {
    return $this->belongsTo(Vehicle::class, 'vehicle_id');
}

public function declarant()
{
    return $this->belongsTo(User::class, 'declarant_id')->withDefault([
        'full_name' => 'Nezināms deklarētājs',
        'name' => 'Nezināms deklarētājs'
    ]);
}

public function consignee() {
    return $this->belongsTo(Party::class, 'consignee_id');
}

public function documents() {
    return $this->hasMany(Document::class, 'case_id');
}

public function inspections() {
    return $this->hasMany(Inspection::class, 'case_id');
}
}
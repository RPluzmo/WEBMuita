<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kases;

class Document extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'id',
        'case_id',
        'filename',
        'mime_type',
        'category',
        'pages',
        'uploaded_by'
    ];

    public function kase()
    {
        return $this->belongsTo(Kases::class, 'kase_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
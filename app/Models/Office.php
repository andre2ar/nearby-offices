<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliate_id',
        'name',
        'latitude',
        'longitude'
    ];

    public $timestamps = false;
    protected $primaryKey = 'affiliate_id';
    public $incrementing = false;
}

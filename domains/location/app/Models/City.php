<?php

namespace Domains\Location\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class City extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'lat',
        'long',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * Auto fill the uuid attribute
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (City $model) {
            $model->uuid = Str::uuid()->toString();
        });
    }
}

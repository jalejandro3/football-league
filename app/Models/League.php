<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class League
 *
 * @package App\Models
 */
class League extends Model
{
    use HasFactory;

    /**
     * STATUS IMPORTED
     */
    const STATUS_IMPORTED = 'imported';

    /**
     * STATUS NOT IMPORTED
     */
    const STATUS_NOT_IMPORTED = 'not imported';

    /**
     * @var array
     */
    protected $fillable = ['code', 'status'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}

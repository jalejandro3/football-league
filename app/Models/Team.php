<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Team
 *
 * @package App\Models
 */
class Team extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['name', 'tla', 'shortName', 'areaName', 'email'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * A team belongs to many competitions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function competitions() {
        return $this->belongsToMany(Competition::class);
    }

    /**
     * A team has many players.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function players()
    {
        return $this->hasMany(Player::class);
    }
}

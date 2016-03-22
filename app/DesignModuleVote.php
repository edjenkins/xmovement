<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesignModuleVote extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'xmovement_module_id', 'user_id', 'value'
    ];
}

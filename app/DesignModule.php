<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesignModule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idea_id', 'user_id', 'type'
    ];
    
    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }

    public function xmovement_module()
    {
        return $this->morphTo();
    }
}

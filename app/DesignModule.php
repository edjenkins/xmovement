<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\DesignModuleVote;

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

    public function voteCount()
    {
        return DesignModuleVote::where('design_module_id', $this->id)->sum('value');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'visibility', 'description', 'photo'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The Design Modules for the idea.
     *
     * @var array
     */
    public function designModules()
    {
        return $this->hasMany(DesignModule::class);
    }

    public function supporterCount()
    {
        return Supporter::where('idea_id', $this->id)->count();
    }

    /**
     * The supporters of the Idea.
     */
    public function supporters()
    {
        return $this->belongsToMany(User::class, 'supporters')->withTimestamps();
    }
}
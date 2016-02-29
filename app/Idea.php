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

    public function supporterCount()
    {
        return Supporter::where('idea_id', $this->id)->count();
    }
}

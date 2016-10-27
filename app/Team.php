<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'email', 'avatar', 'bio'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'email'
    ];

    /**
     * The Tenders a team has submitted.
     *
     * @var array
     */
    public function tenders()
    {
		return $this->hasMany(Tender::class);
    }

    /**
     * The users/members of the team.
     *
     * @var array
     */
    public function users()
    {
		return $this->belongsToMany(User::class);
    }
}

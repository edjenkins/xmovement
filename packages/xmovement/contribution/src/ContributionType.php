<?php

namespace XMovement\Contribution;

use Illuminate\Database\Eloquent\Model;

use Auth;

class ContributionType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'xmovement_contribution_id'
    ];

    protected $table = 'xmovement_contribution_types';
   
}
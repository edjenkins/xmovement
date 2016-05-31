<?php

namespace XMovement\Contribution;

use Illuminate\Database\Eloquent\Model;

use Auth;

class ContributionAvailableType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description'
    ];

    protected $table = 'xmovement_contribution_available_types';
    
    public function contributionType()
    {
        return $this->belongsTo(Contribution::class, 'xmovement_contribution_types');
    }

}
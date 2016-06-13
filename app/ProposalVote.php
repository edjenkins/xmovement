<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProposalVote extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'proposal_id', 'value'
    ];
}

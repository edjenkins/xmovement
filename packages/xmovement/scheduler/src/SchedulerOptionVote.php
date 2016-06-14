<?php

namespace XMovement\Scheduler;

use Illuminate\Database\Eloquent\Model;

class SchedulerOptionVote extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'xmovement_scheduler_option_id', 'user_id', 'value'
    ];

    protected $table = 'xmovement_scheduler_option_votes';

    public function scheduler()
    {
        return $this->belongsTo(Scheduler::class, 'xmovement_scheduler_id');
    }
}

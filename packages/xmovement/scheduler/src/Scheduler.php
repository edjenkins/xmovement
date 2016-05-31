<?php

namespace XMovement\Scheduler;

use Illuminate\Database\Eloquent\Model;

class Scheduler extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id'
    ];

    protected $table = 'xmovement_schedulers';

    public function renderTile($design_task)
    {
    	return view('scheduler::tile', ['scheduler' => $this, 'design_task' => $design_task]);
    }

    public function designTask()
    {
        return $this->morphMany('App\DesignTask', 'xmovement_task');
    }

}

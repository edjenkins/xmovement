<?php

namespace XMovement\Schedule;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id'
    ];

    protected $table = 'xmovement_schedules';

    public function renderTile($design_task)
    {
    	return view('schedule::tile', ['schedule' => $this, 'design_task' => $design_task]);
    }

    public function designTask()
    {
        return $this->morphMany('App\DesignTask', 'xmovement_task');
    }

}

<?php

namespace XMovement\Discussion;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id'
    ];

    protected $table = 'xmovement_discussions';

    public function renderTile($design_task)
    {
    	return view('discussion::tile', ['discussion' => $this, 'design_task' => $design_task]);
    }

	public function renderProposalOutput(\App\DesignTask $design_task)
	{
		return view('discussion::proposal-tile', ['discussion' => $this]);
	}

    public function designTask()
    {
        return $this->morphMany('App\DesignTask', 'xmovement_task');
    }

}

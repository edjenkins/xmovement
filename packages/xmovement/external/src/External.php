<?php

namespace XMovement\External;

use Illuminate\Database\Eloquent\Model;

class External extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
				'embed_code',
				'external_link'
    ];

    protected $table = 'xmovement_externals';

    public function renderTile($design_task)
    {
    	return view('external::tile', ['external' => $this, 'design_task' => $design_task]);
    }

	public function renderProposalOutput(\App\DesignTask $design_task)
	{
		return view('external::proposal-tile', ['external' => $this]);
	}

    public function designTask()
    {
        return $this->morphMany('App\DesignTask', 'xmovement_task');
    }

}

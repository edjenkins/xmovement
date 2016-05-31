<?php

namespace XMovement\Requirement;

use Illuminate\Database\Eloquent\Model;

use Auth;
use DB;

class Requirement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'item', 'count'
    ];

    protected $table = 'xmovement_requirements';

    public function renderTile($design_task)
    {
    	return view('requirement::tile', ['requirement' => $this, 'design_task' => $design_task]);
    }

    public function requirementsFilled()
    {
        return $this->hasMany(RequirementFilled::class, 'xmovement_requirement_id');
    }

    public function designTask()
    {
        return $this->morphMany('App\DesignTask', 'xmovement_task');
    }

    public function fillRequirement()
    {
        // Check user can vote
        // Not locked

        if (false)
        {
            // Prevent voting twice in one direction
            return false;
        }
        else
        {
            // Fill requirement
            $requirementFilled = RequirementFilled::create([
                'xmovement_requirement_id' => $this->id,
                'user_id' => Auth::user()->id
            ]);

            return $requirementFilled;
        }
    }

}
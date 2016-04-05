<?php

namespace XMovement\Requirement;

use Illuminate\Database\Eloquent\Model;

use Auth;

use App\User;

class RequirementFilled extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'xmovement_requirement_id'
    ];

    protected $table = 'xmovement_requirements_filled';

    public function requirement()
    {
        return $this->belongsTo(Requirement::class, 'xmovement_requirement_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function withdraw()
    {
        // Check user can withdraw
        
        $this->delete();

        return true;
    }
}
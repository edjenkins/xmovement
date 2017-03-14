<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use MartinBean\Database\Eloquent\Sluggable;

use Auth;
use Carbon\Carbon;
use DynamicConfig;
use Log;

class BlogPost extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
		'content',
		'photo',
		'visibility'
    ];

    protected $dates = ['deleted_at'];

	use Sluggable;
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

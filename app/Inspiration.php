<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Auth;
use Log;

use App\InspirationFavourite;

class Inspiration extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'user_id',
		'type',
		'description',
		'content',
    ];

	protected $appends = ['short_description', 'favourited_count', 'has_favourited'];
    protected $dates = ['deleted_at'];

	use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany('App\InspirationCategory');
    }

	public function favourite()
	{
		// Set old favourites
		InspirationFavourite::where([
			'inspiration_id' => $this->id,
			'user_id' => Auth::user()->id,
		])->update(['latest' => false]);

		// Add new favourite
		$inspiration_favourite = InspirationFavourite::create([
			'user_id' => Auth::user()->id,
			'inspiration_id' => $this->id,
			'value' => 1,
			'latest' => true
		]);

		return $inspiration_favourite;
	}

	public function unfavourite()
	{
		// Set old favourites
		InspirationFavourite::where([
			'inspiration_id' => $this->id,
			'user_id' => Auth::user()->id,
		])->update(['latest' => false]);

		// Add new unfavourite
		$inspiration_favourite = InspirationFavourite::create([
			'user_id' => Auth::user()->id,
			'inspiration_id' => $this->id,
			'value' => 0,
			'latest' => true
		]);

		return $inspiration_favourite;
	}

    /**
     * The Favourited Inspirations
     *
     * @var array
     */
    public function favourites()
    {
        return $this->hasMany(InspirationFavourite::class);
    }

	public function getShortDescriptionAttribute()
	{
		return str_limit($this->description, 80);
	}

	public function getFavouritedCountAttribute()
	{
		return InspirationFavourite::where([
			'inspiration_id' => $this->id,
			'value' => 1,
			'latest' => true
		])->count();
	}

	public function getHasFavouritedAttribute()
	{
		return InspirationFavourite::where([
			'inspiration_id' => $this->id,
			'user_id' => Auth::user()->id,
			'value' => 1,
			'latest' => true
		])->exists();
	}

}

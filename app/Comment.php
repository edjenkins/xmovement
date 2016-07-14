<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\CommentVote;
use App\Report;
use Auth;
use App\Comment;
use Log;
use Response;

class ResponseObject {

	public $meta = array();
	public $errors = array();
	public $data = array();

	public function __construct()
	{
		$this->meta['success'] = false;
	}
}

class Comment extends Model
{
	protected $fillable = [
	   'user_id', 'text', 'url', 'in_reply_to_comment_id'
	];

    protected $dates = ['deleted_at'];

	use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function children()
	{
        return $this->hasMany('App\Comment', 'in_reply_to_comment_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Comment', 'in_reply_to_comment_id');
    }

    public function reports()
    {
		return $this->morphMany('App\Report', 'reportable');
    }

    public function voteCount()
    {
        return CommentVote::where([['comment_id', $this->id], ['latest', true]])->sum('value');
    }

	public function userVote()
	{
		$user_id = (Auth::user()) ? Auth::user()->id : null;

		// Check if user has voted on comment
		$user_vote = CommentVote::where([
			['user_id', $user_id],
			['comment_id', $this->id],
			['latest', true],
		])->orderBy('created_at', -1)->first();

		return $user_vote['value'];
	}

	public function addVote($value)
	{
        // Check user can vote
        // Not locked

        if ($this->userVote() == $value)
        {
            // Prevent voting twice in one direction
            return false;
        }
        else
        {
			// Set old voted to inactive
			CommentVote::where([
				'comment_id' => $this->id,
				'user_id' => Auth::user()->id,
			])->update(['latest' => false]);

			// Add new vote
			CommentVote::create([
				'comment_id' => $this->id,
				'user_id' => Auth::user()->id,
				'value' => $value,
				'latest' => true
			]);

            return true;
        }

	}

}

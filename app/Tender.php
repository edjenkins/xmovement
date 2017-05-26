<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Auth;
use App\Report;

class Tender extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idea_id', 'user_id', 'team_id', 'summary', 'document', 'private_document'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'private_document'
    ];

    protected $dates = ['deleted_at'];

    use SoftDeletes;

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }

    public function questions()
    {
        return $this->hasManyThrough(TenderQuestion::class, TenderQuestionAnswer::class, 'tender_id', 'id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(TenderQuestionAnswer::class, 'tender_id')->whereHas('question', function($q)
        {
            $q->where('public', '=', true);

        });
    }

    public function updates()
    {
        return $this->morphMany('App\Update', 'updateable');
    }
}

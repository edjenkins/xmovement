<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TenderQuestion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'question',
		'public',
		'enabled'
    ];

    public function tenders()
    {
        return $this->belongsToMany('App\Tender');
    }

    public function answers()
    {
        return $this->belongsToMany('App\TenderQuestionAnswer', 'tender_question_id');
    }
}

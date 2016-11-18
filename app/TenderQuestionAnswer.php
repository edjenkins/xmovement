<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TenderQuestionAnswer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'tender_question_id', 'answer', 'tender_id'
    ];

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function question()
    {
        return $this->hasOne('App\TenderQuestion', 'id', 'tender_question_id');
    }
}

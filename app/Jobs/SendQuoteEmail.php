<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Inspiring;

use Lang;
use Log;
use Mail;

use App\User;


class SendQuoteEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $receiver;
	protected $quote;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $receiver)
    {
		// Generate quote
		$quote = Inspiring::quote();

		$this->receiver = $receiver;
		$this->quote = $quote;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('emails.quote', ['receiver' => $this->receiver, 'quote' => $this->quote], function ($message) {

			$message->to($this->receiver->email)->subject(Lang::get('emails.quote_subject'));

        });
    }
}

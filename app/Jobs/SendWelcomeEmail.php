<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Lang;
use Mail;

use App\User;


class SendWelcomeEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;
    protected $isFacebookUser;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $isFacebookUser)
    {
        $this->user = $user;
        $this->isFacebookUser = $isFacebookUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('emails.welcome', ['facebook' => $this->isFacebookUser, 'user' => $this->user], function ($message) {

            $message->to($this->user->email)->subject(Lang::get('emails.welcome_subject'));

        });
    }
}

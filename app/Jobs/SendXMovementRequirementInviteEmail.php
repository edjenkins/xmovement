<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Lang;
use Mail;

use App\User;


class SendXMovementRequirementInviteEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $name;
    protected $email;
    protected $personal_message;
    protected $link;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $email, $personal_message, $link, User $user)
    {
        $this->name = $name;
        $this->email = $email;
        $this->personal_message = $personal_message;
        $this->link = $link;

        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('xmovement.requirement.emails.invite', ['name' => $this->name, 'email' => $this->email, 'personal_message' => $this->personal_message, 'link' => $this->link, 'user' => $this->user], function ($message) {

			$message->to($this->email)->subject(Lang::get('emails.xmovement_requirement_invite_subject', ['name' => $this->user->name]));

        });
    }
}

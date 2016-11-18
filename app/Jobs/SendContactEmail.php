<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Lang;
use Mail;

use App\Message;
use App\User;


class SendContactEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $name;
    protected $email;
    protected $text;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $email, $text)
    {
        $this->name = $name;
		$this->email = $email;
        $this->text = $text;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('emails.contact-email', ['name' => $this->name, 'email' => $this->email, 'text' => $this->text], function ($message) {

            $message->to(getenv('APP_CONTACT_EMAIL'))->subject(Lang::get('emails.contact_email_subject', ['name' => $this->name]));

        });
    }
}

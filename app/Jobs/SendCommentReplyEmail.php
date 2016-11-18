<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Lang;
use Log;
use Mail;

use App\Comment;
use App\User;


class SendCommentReplyEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $sender;
    protected $receiver;
    protected $comment;
    protected $reply;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $sender, User $receiver, Comment $comment, Comment $reply)
    {
        $this->sender = $sender;
		$this->receiver = $receiver;
        $this->comment = $comment;
		$this->reply = $reply;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		Log::info('Sending comment reply email');

        Mail::send('emails.comment-reply', ['sender' => $this->sender, 'receiver' => $this->receiver, 'comment' => $this->comment, 'reply' => $this->reply], function ($message) {

            $message->to($this->receiver->email)->subject(Lang::get('emails.comment_reply_subject', ['user_name' => $this->sender->name]));

        });
    }
}

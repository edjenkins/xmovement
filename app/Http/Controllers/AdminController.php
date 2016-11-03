<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Jobs\SendTestEmails;

class AdminController extends Controller
{
    public function emailTest(Request $request)
    {
		$job = (new SendTestEmails())->onQueue('emails');//->delay(30)

		$this->dispatch($job);

		return 'Test emails sent!';
    }
}

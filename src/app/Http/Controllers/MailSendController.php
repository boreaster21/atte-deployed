<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailSendController extends Controller
{
    public function index()
    {

        $data = [];

        Mail::send('emails.thx', $data, function ($message) {
            $message->to('abc987@example.com', 'Test')
            ->subject('This is a test mail');
        });
    }
}

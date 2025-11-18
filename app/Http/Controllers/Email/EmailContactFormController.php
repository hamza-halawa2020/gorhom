<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Http\Requests\Email\EmailContactFormRequest;
use App\Mail\AutoReplyMail;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class EmailContactFormController extends Controller
{
    public function send(EmailContactFormRequest $request)
    {
        $data = $request->validated();

        $interest = strtolower(trim($data['interest']));
        $recipient = 'info@hpsaviation.com';

        if ($interest === 'investment opportunities') {
            Config::set('mail.from.name', $interest);
            $recipient = 'investors@hpsaviation.com';
            // $recipient = 'h.halawa2020@gmail.com';

        } elseif (in_array($interest, ['strategic partnership', 'technology licensing', 'other'])) {
            Config::set('mail.from.name', $interest);
            $recipient = 'info@hpsaviation.com';
        } elseif ($interest === 'career opportunities') {
            Config::set('mail.from.name', $interest);
            $recipient = 'career@hpsaviation.com';
        }

        Mail::to($recipient)->queue(new ContactFormMail($data));

        if ($interest === 'investment opportunities') {
            if (! empty($data['email'])) {
                Mail::to($data['email'])
                    ->bcc('investors@hpsaviation.com')
                    ->queue(new AutoReplyMail($data));
            }
        }

        return response()->json(['message' => 'Email sent successfully!']);
    }
}

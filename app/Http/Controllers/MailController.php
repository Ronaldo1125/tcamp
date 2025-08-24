<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class MailController extends Controller
{
    public function index() 
    {
        $subject = 'Application of Travel Order';

        Mail::to('rbbanas@neda.gov.ph')->send(new TestMail($subject));
        

    }
}

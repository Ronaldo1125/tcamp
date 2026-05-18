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
        $content = "Testing lang po.";
        $travel_order = 2;

        Mail::to('rbbanas@depdev.gov.ph')->send(new TestMail($subject, $content, $travel_order));
        

    }
}

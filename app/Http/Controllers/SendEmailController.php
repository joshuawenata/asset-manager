<?php

namespace App\Http\Controllers;

use App\Mail\NotifyMail;
use App\Mail\NotifyMailPeminjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public function index($receiver, $message, $subjek){
        Mail::to($receiver)->send(new NotifyMail($message, $subjek));
    }

    public function indexPeminjam($receiver, $message, $subjek){
        Mail::to($receiver)->send(new NotifyMailPeminjam($message, $subjek));
    }
}

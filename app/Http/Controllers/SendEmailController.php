<?php

namespace App\Http\Controllers;

use App\Mail\NotifyMail;
use App\Mail\NotifyMailPeminjam;
use App\Mail\NotifyMailPeminjamApprove;
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

    public function indexPeminjamApprove($receiver, $message, $subjek, $req_id){
        Mail::to($receiver)->send(new NotifyMailPeminjamApprove($message, $subjek, $req_id));
    }
}

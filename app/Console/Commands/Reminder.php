<?php

namespace App\Console\Commands;

use App\Mail\NotifyMail;
use App\Models\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class Reminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminder to return asset';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $d = strtotime("today");
        $requests = \App\Models\Request::where('status', 'on use')
            ->whereYear('return_date', date('Y'))
            ->whereMonth('return_date', date('m'))
            ->whereDay('return_date', date('d', strtotime("+1 days", $d)))
            ->get();

        $subjek = "Reminder Pengembalian Barang";

        if($requests->count() > 0){
            foreach ($requests as $r){
                $message = "Reminder pengembalian barang besok " . date("l, d M Y H:i", strtotime($r->return_date));
                Mail::to($r->User->email)->send(new NotifyMail($message, $subjek));
            }
        }

        return Command::SUCCESS;
    }
}

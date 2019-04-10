<?php

namespace App\Http\Controllers;
use App\notifications;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function notification() {
        $note=notifications::get();
         $notes= json_decode(trim($note, '[]'),true);
        // return $notes;
        return view('backEnd.index',compact('notes'));
    }
}

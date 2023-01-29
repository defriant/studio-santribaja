<?php

namespace App\Http\Controllers;

use App\Models\Mailbox;
use Illuminate\Http\Request;

class MailboxController extends Controller
{
    public function mailbox()
    {
        return view('mailbox');
    }

    public function get_mailbox()
    {
        $mailbox = Mailbox::orderBy('created_at', 'DESC')->get();
        $data = [];

        foreach ($mailbox as $m) {
            $data[] = [
                "id" => $m->id,
                "is_read" => $m->is_read,
                "date" => date('d F Y', strtotime($m->created_at)),
                "name" => $m->name,
                "time" => date("H:i", strtotime($m->created_at)),
                "phone" => $m->phone,
                "email" => $m->email,
                "message" => $m->message
            ];
        }

        $response = [
            "response" => "success",
            "data" => $data
        ];

        return response()->json($response);
    }

    public function read_mailbox(Request $request)
    {
        Mailbox::find($request->id)->update([
            "is_read" => true
        ]);

        $response = [
            "response" => "success"
        ];

        return response()->json($response);
    }

    public function delete_mailbox(Request $request)
    {
        foreach ($request->id as $mail) {
            Mailbox::find($mail)->delete();
        }

        $response = [
            "response" => "success",
            "message" => "Mail deleted successfully"
        ];

        return response()->json($response);
    }
}

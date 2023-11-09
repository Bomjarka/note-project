<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function list(Request $request)
    {
        $user = $request->user();

        return view('notes', ['notes' => $user->notes]);
    }

    public function show(Note $note, Request $request)
    {
        return view('note', ['note' => $note]);
    }
}

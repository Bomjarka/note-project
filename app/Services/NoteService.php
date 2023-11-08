<?php

namespace App\Services;

use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteService
{
    /**
     * @param Note $note
     * @param array $data
     * @return Note
     */
    public function createOrUpdate(Note $note, array $data): Note
    {
        $note->fill($data);
        $note->save();

        return $note;
    }

    /**
     * @param Note $note
     * @return void
     */
    public function destroy(Note $note): void
    {
        $note->delete();
    }
}

<?php

namespace App\Services;

use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteService
{
    /**
     * @param array $data
     * @param int|null $id
     * @return Note
     */
    public function createOrUpdate(array $data, int $id = null): Note
    {
        $note = Note::findOrNew($id);
        $note->fill($data);
        $note->user_id = Auth::user()->id;
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

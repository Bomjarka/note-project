<?php

namespace App\Http\Controllers\Api\Notes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Note\NoteRequest;
use App\Models\Note;
use App\Services\NoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return response()->json(Auth::user()->notes);
    }

    /**
     * @param int $id
     * @return JsonResponse|Note
     */
    public function show(int $id): JsonResponse|Note
    {
        if (!Note::find($id)) {
            return response()->json([
                'message' => 'Note doesnt exist',
            ], 404);
        }
        $userNote =  Auth::user()->notes()->whereId($id)->first();
        if (!$userNote) {
            return response()->json([
                'message' => 'You cant view this note',
            ], 403);
        }
        return response()->json($userNote);
    }

    /**
     * @param NoteRequest $request
     * @param NoteService $noteService
     * @param int|null $id
     * @return JsonResponse
     */
    public function storeOrUpdate(NoteRequest $request, NoteService $noteService, int $id = null): JsonResponse
    {
        $note = Note::findOrNew($id);
        $data = array_merge(['user_id' => Auth::user()->id], $request->all());
        if (isset($note->id) && $note->user_id !== Auth::user()->id) {
            return response()->json([
                'message' => 'You cannot update this note',
            ], 403);
        }
        $note = $noteService->createOrUpdate($note, $data);

        return response()->json($note);
    }

    /**
     * @param int $id
     * @param NoteService $noteService
     * @return JsonResponse
     */
    public function destroy(int $id, NoteService $noteService): JsonResponse
    {
       if ($note = Note::find($id)) {
           if ($note->user_id !== Auth::user()->id) {
               return response()->json([
                   'message' => 'You cannot destroy this note',
               ], 403);
           }
           $noteService->destroy($note);

           return response()->json($note);
       }

        return response()->json([
            'message' => 'Note doesnt exist',
        ], 404);
    }
}

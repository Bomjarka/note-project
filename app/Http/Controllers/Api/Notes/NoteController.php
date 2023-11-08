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
        if (!Auth::user()) {
            return response()->json([
                'message' => 'You cannot sign with those credentials',
                'errors' => 'Unauthorised'
            ], 401);
        }

        return response()->json(Auth::user()->notes);
    }

    /**
     * @param Note $note
     * @return JsonResponse|Note
     */
    public function show(Note $note): JsonResponse|Note
    {
        if (!Auth::user()) {
            return response()->json([
                'message' => 'You cannot sign with those credentials',
                'errors' => 'Unauthorised'
            ], 401);
        }

        $userNote =  Auth::user()->notes()->whereId($note->id)->first();

        return response()->json(['note' => $userNote]);
    }

    /**
     * @param NoteRequest $request
     * @param NoteService $noteService
     * @param int|null $id
     * @return JsonResponse
     */
    public function storeOrUpdate(NoteRequest $request, NoteService $noteService, int $id = null): JsonResponse
    {
        $data = array_merge(['user_id' => Auth::user()->id], $request->all());
        $note = $noteService->createOrUpdate($data, $id);

        return response()->json($note);
    }

    /**
     * @param Note $note
     * @param NoteService $noteService
     * @return JsonResponse
     */
    public function destroy(Note $note, NoteService $noteService): JsonResponse
    {
        $noteService->destroy($note);

        return response()->json($note);
    }
}

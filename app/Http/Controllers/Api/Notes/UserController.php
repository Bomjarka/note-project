<?php

namespace App\Http\Controllers\Api\Notes;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = User::find($id);

        if ($user && Auth::user()->id === $user->id) {
            return response()->json($user);
        }

        return response()->json([
            'message' => 'Something wrong with user_id',
        ], 500);
    }
}

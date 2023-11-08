<?php

namespace App\Http\Requests\Api\Note;

use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'topic' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:255'],
        ];
    }
}

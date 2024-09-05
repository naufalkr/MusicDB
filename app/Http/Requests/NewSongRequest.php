<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewSongRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'album' => 'required|string|max:255',
            'year' => 'nullable|integer',
            'duration' => 'nullable|integer',
            'music_company' => 'required|string|unique:song,music_company|max:13',
            'genre' => 'required|array',
            'genre.*' => 'exists:genre,id',
            'description' => 'nullable|string',
        ];
    }
}

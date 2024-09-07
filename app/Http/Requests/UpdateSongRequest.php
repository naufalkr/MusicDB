<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSongRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        // Return true if all users are allowed to make this request.
        // You can add additional authorization logic here.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        // Get the current Song instance from the route
        $songId = $this->route('song')->id;

        return [
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'album' => 'required|string|max:255',
            'year' => 'nullable|integer',
            'duration' => 'nullable|integer',
            'music_company' => [
                'required',
                'string',
                'max:200',
                Rule::unique('song', 'music_company')->ignore($songId),
            ],
            'genre' => 'required|array',
            'genre.*' => 'exists:genre,id',
            'description' => 'nullable|string',
        ];
    }
}

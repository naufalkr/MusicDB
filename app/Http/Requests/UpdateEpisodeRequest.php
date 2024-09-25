<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEpisodeRequest extends FormRequest
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
        // Get the current Episode instance from the route
        $episodeId = $this->route('episode')->id;

        return [
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'show' => 'required|string|max:255',
            'year' => 'nullable|integer',
            'release_date' => 'nullable|string',
            'duration' => 'nullable|integer',
            // 'music_company' => [
            //     'required',
            //     'string',
            //     'max:200',
            //     Rule::unique('episode', 'music_company')->ignore($episodeId),
            // ],
            // 'genre' => 'required|array',
            // 'genre.*' => 'exists:genre,id',
            'description' => 'nullable|string',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostToggleReactionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'like' => filter_var($this->input('like'), FILTER_VALIDATE_BOOLEAN),
        ]);
    }

    public function rules()
    {
        return [
            'post_id' => 'required|int|exists:posts,id',
            'like'    => 'required|boolean',
        ];
    }
}

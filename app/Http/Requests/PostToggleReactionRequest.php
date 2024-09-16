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
            'like' => $this->convertToBoolean($this->input('like')),
        ]);
    }

    public function rules()
    {
        return [
            'post_id' => 'required|int|exists:posts,id',
            'like'    => 'required|boolean',
        ];
    }

    private function convertToBoolean($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false;
    }
}

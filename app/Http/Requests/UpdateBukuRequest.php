<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBukuRequest extends StoreBukuRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = parent::rules();

        foreach ($rules as $key => $rule) {
            $rules[$key] = 'sometimes|' . $rule;
        }

        return $rules;
    }
}

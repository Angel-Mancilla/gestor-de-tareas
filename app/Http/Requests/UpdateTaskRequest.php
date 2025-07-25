<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
        if($this->isMethod('patch')) {
            return[
                'title' => 'sometimes|string|max:255',
                'description' => 'sometimes|string',
                'completed' => 'sometimes|boolean',
            ];
        }

        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'completed' => 'nullable|boolean',
            
        ];
    }
}

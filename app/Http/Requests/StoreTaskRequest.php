<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->role <= 4 ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:50'],
            'description' => ['present', 'max:500'],
            'status' => ['required', 'numeric', 'integer'],
            'deadline' => ['date', 'nullable'],
            'priority' => ['required', 'numeric', 'integer'],
            'workers' => ['present']
        ];
    }
}
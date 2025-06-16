<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskPriorityEnum;
use App\Http\Requests\ApiBaseRequest;

class UpdateTaskRequest extends ApiBaseRequest
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
            'title' => 'required',
            'description' => 'required',
            'date' => 'required|after:now',
            'priority' => ['required', 'in:' . implode(',', array_column(TaskPriorityEnum::cases(), 'name'))]
        ];
    }
}

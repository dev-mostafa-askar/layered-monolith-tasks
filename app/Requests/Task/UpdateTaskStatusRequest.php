<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskStatusEnum;
use App\Http\Requests\ApiBaseRequest;

class UpdateTaskStatusRequest extends ApiBaseRequest
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
            'status' => ['required', 'in:' . implode(',', array_column(TaskStatusEnum::cases(), 'name'))]
        ];
    }
}

<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Http\Requests\ApiBaseRequest;

class ListTasksRequest extends ApiBaseRequest
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
            "page" => "nullable",
            "perPage" => "nullable",
            'search' => 'nullable',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            'sortedBy' => 'nullable',
            'orderedBy' => 'nullable',
            'status' => ['nullable', 'in:' . implode(',', array_column(TaskStatusEnum::cases(), 'name'))],
            'priority' => ['nullable', 'in:' . implode(',', array_column(TaskPriorityEnum::cases(), 'name'))]
        ];
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $from = $this->input('from_date');
            $to = $this->input('to_date');

            if ($from && $to && strtotime($to) < strtotime($from)) {
                $validator->errors()->add('to_date', 'The to_date must be a date after from_date.');
            }

            if ($from && !$to) {
                $this->merge([
                    'to_date' => now()->toDateString(),
                ]);
            }
        });
    }
}

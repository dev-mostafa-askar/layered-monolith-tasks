<?php

namespace App\DTOs\Task;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;

class ListTaskDto
{

    public function __construct(
        private readonly ?int $page,
        private readonly ?int $perPage,
        private readonly ?string $search,
        private readonly ?string $from_date,
        private readonly ?string $to_date,
        private readonly ?string $sortedBy,
        private readonly ?string $orderedBy,
        private readonly ?TaskStatusEnum $status,
        private readonly ?TaskPriorityEnum $priority
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            page: isset($data['page']) ? (int) $data['page'] : null,
            perPage: isset($data['perPage']) ? (int) $data['perPage'] : null,
            search: $data['search'] ?? null,
            from_date: $data['from_date'] ?? null,
            to_date: $data['to_date'] ?? null,
            sortedBy: $data['sortedBy'] ?? null,
            orderedBy: $data['orderedBy'] ?? null,
            status: isset($data['status']) ? TaskStatusEnum::{$data['status']} : null,
            priority: isset($data['priority']) ? TaskPriorityEnum::{$data['priority']} : null
        );
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function getPerPage(): ?int
    {
        return $this->perPage;
    }

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function getFromDate(): ?string
    {
        return $this->from_date;
    }

    public function getToDate(): ?string
    {
        return $this->to_date;
    }

    public function getSortedBy(): ?string
    {
        return $this->sortedBy;
    }

    public function getOrderedBy(): ?string
    {
        return $this->orderedBy;
    }

    public function getStatus(): ?TaskStatusEnum
    {
        return $this->status;
    }

    public function getPriority(): ?TaskPriorityEnum
    {
        return $this->priority;
    }
}

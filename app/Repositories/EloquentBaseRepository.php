<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class EloquentBaseRepository implements BaseRepository
{
    public function __construct(private Model $model) {}

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find($id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function findByEmail(string $email): ?Model
    {
        return $this->model->where('email', $email)->first();
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update($id, array $data): bool
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function delete($id): bool
    {
        return $this->model->where('id', $id)->delete();
    }

    public function select(array $columns): Collection
    {
        return $this->model->select($columns);
    }

    public function buildQuery()
    {
        return $this->model->query();
    }
}

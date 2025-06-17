<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepository
{
    public function all(): Collection;
    public function find($id): Model;
    public function findByEmail(string $email): ?Model;
    public function create(array $data): Model;
    public function update($id, array $data): bool;
    public function delete($id): bool;
    public function select(array $columns): Collection;
    public function buildQuery();
}

<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseService
{
    protected string $repositoryClass;

    protected function repository(): mixed
    {
        return app($this->repositoryClass);
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->repository()->all($columns, $relations);
    }

    public function paginate(int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator
    {
        return $this->repository()->paginate($perPage, $columns, $relations);
    }

    public function findById(int $id, array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->repository()->findById($id, $columns, $relations);
    }

    public function findOrFail(int $id, array $columns = ['*'], array $relations = []): Model
    {
        return $this->repository()->findOrFail($id, $columns, $relations);
    }

    public function create(array $attributes): Model
    {
        return $this->repository()->create($attributes);
    }

    public function update(int $id, array $attributes): Model
    {
        $this->repository()->update($id, $attributes);
        return $this->repository()->findOrFail($id);
    }

    public function delete(int $id): bool
    {
        return $this->repository()->delete($id);
    }

    public function count(): int
    {
        return $this->repository()->count();
    }
}

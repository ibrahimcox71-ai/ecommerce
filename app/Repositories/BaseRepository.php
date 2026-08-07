<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository
{
    protected Model $model;

    public function __construct()
    {
        $this->model = $this->model();
    }

    abstract protected function model(): Model;

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator
    {
        return $this->model->with($relations)->paginate($perPage, $columns);
    }

    public function findById(int $id, array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->model->with($relations)->find($id, $columns);
    }

    public function findOrFail(int $id, array $columns = ['*'], array $relations = []): Model
    {
        return $this->model->with($relations)->findOrFail($id, $columns);
    }

    public function findWhere(array $conditions, array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->where($conditions)->get($columns);
    }

    public function findWhereFirst(array $conditions, array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->model->with($relations)->where($conditions)->first($columns);
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function update(int $id, array $attributes): bool
    {
        return $this->findOrFail($id)->update($attributes);
    }

    public function updateOrCreate(array $conditions, array $attributes): Model
    {
        return $this->model->updateOrCreate($conditions, $attributes);
    }

    public function delete(int $id): bool
    {
        return $this->findOrFail($id)->delete();
    }

    public function deleteWhere(array $conditions): bool
    {
        return $this->model->where($conditions)->delete() > 0;
    }

    public function forceDelete(int $id): bool
    {
        return $this->findOrFail($id)->forceDelete();
    }

    public function count(): int
    {
        return $this->model->count();
    }

    public function countWhere(array $conditions): int
    {
        return $this->model->where($conditions)->count();
    }

    public function exists(array $conditions): bool
    {
        return $this->model->where($conditions)->exists();
    }

    public function pluck(string $value, string $key = null): Collection
    {
        return $this->model->pluck($value, $key);
    }

    public function query(): Builder
    {
        return $this->model->newQuery();
    }

    public function withTrashed(): Builder
    {
        return $this->model->newQuery()->withTrashed();
    }

    public function onlyTrashed(): Builder
    {
        return $this->model->newQuery()->onlyTrashed();
    }

    public function restore(int $id): bool
    {
        return $this->withTrashed()->find($id)?->restore() ?? false;
    }
}

<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class BaseRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $with = [], array $columns = ['*'])
    {
        $query = $this->model->newQuery();

        foreach ($with as $relation) {
            $query->with($relation);
        }

        return $query->get($columns);
    }

    public function findOrFail(string $id, array $with = [])
    {
        $query = $this->model->newQuery();

        foreach ($with as $relation) {
            $query->with($relation);
        }

        return $query->findOrFail($id);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(Model $model, array $data): Model
    {
        $model->fill($data);
        $model->save();

        return $model;
    }

    public function delete(Model $model): bool
    {
        return $model->delete();
    }
}

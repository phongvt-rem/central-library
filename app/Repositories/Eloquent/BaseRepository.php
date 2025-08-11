<?php

namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected Model $model;

    /**
     * Constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Find a record by ID.
     *
     * @param mixed $id
     * @return Model
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new record.
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a record by ID.
     *
     * @param mixed $id
     * @param array $data
     * @return Model
     */
    public function update($id, array $data)
    {
        $model = $this->find($id);
        $model->update($data);
        return $model;
    }

    /**
     * Delete a record by ID.
     *
     * @param mixed $id
     * @return int
     */
    public function delete($id)
    {
        return $this->model::destroy($id);
    }
}

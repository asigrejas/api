<?php

namespace Domain\Criteria;

use Exception;

class Repository
{
    public $limit = 50;

    public function response()
    {
        return $this->model->get();
//        return $this->model->paginate($this->limit);
    }

    /**
     * Get all [objetos].
     *
     * @param  array  $columns
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function all(array $columns = ['*'], array $with = [])
    {
        $this->model = $this->model->select($columns)->with($with);

        return $this->response();
    }

    /**
     * Store new OBJECT.
     *
     * @param  array  $data
     *
     * @return int|bool
     */
    public function store(array $data)
    {
        try {
            $this->model->fill($data);
            $this->model->save();

            return $this->model;
        } catch (Exception $e) {
            dd([$e->getMessage(), $data, $this->model->primaryKey]);

            return false;
        }
    }

    /**
     * Pesquisa por um objeto.
     *
     * @param  int $id
     * @param  array  $columns
     * @param  array  $with
     *
     * @return bool|Illuminate\Database\Eloquent\Model
     */
    public function find($id, array $columns = ['*'], array $with = [])
    {
        $this->model = $this->model->where($this->model->getKeyName(), $id)->select($columns)->with($with);

        return $this->response();
    }

    /**
     * First.
     *
     * @param  int $id
     * @param  array  $columns
     * @param  array  $with
     *
     * @return bool|Illuminate\Database\Eloquent\Model
     */
    public function first($id, array $columns = ['*'], array $with = [])
    {
        return $this->model->where($this->model->getKeyName(), $id)->select($columns)->with($with)->first();
    }

    /**
     * force delete.
     *
     * @param int|string $ids
     *
     * @return int
     */
    public function forceDelete($ids)
    {
        if (!in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this->model))) {
            return 0;
        }

        if (!is_array($ids)) {
            $ids = explode(',', $ids);
        }

        return $this->model->withTrashed()->whereIn($this->model->getKeyName(), $ids)->forceDelete();
    }
}

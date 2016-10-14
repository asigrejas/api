<?php

namespace Church\Repositories;

use Church\Church;
use Domain\Criteria\Repository;

class ChurchRepository extends Repository
{
    protected $model;

    public function __construct(Church $model)
    {
        $this->model = $model;
    }

    /**
     * Get all churches active.
     *
     * @param  array  $columns
     * @param  array  $with
     *
     * @return Church
     */
    public function allActive(array $columns = ['*'], array $with = [])
    {
        $this->model = $this->model->where('status', true)->orderby('updated_at', 'desc');

        return $this->all($columns, $with);
    }

    /**
     * Get church active by id :id.
     *
     * @param  int  $id
     * @param  array  $columns
     * @param  array  $with
     *
     * @return Church
     */
    public function findActive($id, array $columns = ['*'], array $with = [])
    {
        $this->model = $this->model->where('status', true);

        return $this->find($id, $columns, $with);
    }
}

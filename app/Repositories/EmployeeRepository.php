<?php


namespace App\Repositories;


use App\Employee;


class EmployeeRepository implements RepositoryInterface
{
    protected $model;

    public function __construct(Employee $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        $this->model->all();
    }

    public function paginate($size)
    {
        return $this->model->paginate($size);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function destroy($id)
    {
        return $this->model->destroy($id);
    }

}

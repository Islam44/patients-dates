<?php
namespace App\Repositories;
use App\Repositories\IRepositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\AssignOp\Mod;

class Repository implements RepositoryInterface{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $row = $this->show($id);
        return $row->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }
    
    public function paginate(int $perPage)
    {
       return $this->model->paginate($perPage);
    }
}

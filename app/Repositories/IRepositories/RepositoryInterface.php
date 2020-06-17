<?php
namespace App\Repositories\IRepositories;

interface RepositoryInterface
{
    public function all();

    public function paginate(int $perPage);

    public function show($id);

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

}

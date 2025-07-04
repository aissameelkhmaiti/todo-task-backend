<?php
namespace App\Repositories;

interface TaskRepositoryInterface
{
    public function all();
    public function findById($id, $userId);
    public function create(array $data);
    public function update($id, array $data, $userId);
    public function delete($id, $userId);
}

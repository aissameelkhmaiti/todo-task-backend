<?php

namespace App\Services;

use App\Repositories\TaskRepositoryInterface;

class TaskService
{
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }



        public function getAll()
{
    return $this->taskRepository->all(); 
}

    public function getById($id, $userId)
    {
        return $this->taskRepository->findById($id, $userId);
    }

    public function create(array $data, $userId)
    {
        $data['user_id'] = $userId;
        return $this->taskRepository->create($data);
    }

    public function update($id, array $data, $userId)
    {
        return $this->taskRepository->update($id, $data, $userId);
    }

    public function delete($id, $userId)
    {
        return $this->taskRepository->delete($id, $userId);
    }
}

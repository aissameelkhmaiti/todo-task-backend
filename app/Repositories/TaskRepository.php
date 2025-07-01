<?php
namespace App\Repositories;

use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    public function allForUser($userId)
    {
        return Task::where('user_id', $userId)->get();
    }

    public function findById($id, $userId)
    {
        return Task::where('id', $id)->where('user_id', $userId)->firstOrFail();
    }

    public function create(array $data)
    {
        return Task::create($data);
    }

    public function update($id, array $data, $userId)
    {
        $task = $this->findById($id, $userId);
        $task->update($data);
        return $task;
    }

    public function delete($id, $userId)
    {
        $task = $this->findById($id, $userId);
        $task->delete();
        return true;
    }
}

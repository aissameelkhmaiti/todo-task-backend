<?php

namespace App\Http\Controllers;

use App\Events\TaskCreated;
use Illuminate\Http\Request;
use App\Services\TaskService;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    // Récupérer toutes les tâches de l'utilisateur connecté
        public function index(Request $request)
{
    $tasks = $this->taskService->getAll(); 
    return response()->json([
        'success' => true,
        'data' => $tasks
    ]);
}

    // Récupérer une tâche spécifique
    public function show($id, Request $request)
    {
        $task = $this->taskService->getById($id, $request->user()->id);
        return response()->json([
            'success' => true,
            'data' => $task
        ]);
    }

    // Créer une nouvelle tâche
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean'
        ]);

        // Ajoute l'utilisateur à la requête
        $data['user_id'] = $request->user()->id;

        $task = $this->taskService->create($request->all(), auth()->id());


        // Diffuser l'événement pour les notifications en temps réel
        broadcast(new TaskCreated($task))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'Tâche créée avec succès.',
            'data' => $task
        ]);
    }

    // Mettre à jour une tâche
    public function update($id, Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean'
        ]);

        $updatedTask = $this->taskService->update($id, $data, $request->user()->id);

        return response()->json([
            'success' => true,
            'message' => 'Tâche mise à jour avec succès.',
            'data' => $updatedTask
        ]);
    }

    // Supprimer une tâche
    public function destroy($id, Request $request)
    {
        $this->taskService->delete($id, $request->user()->id);

        return response()->json([
            'success' => true,
            'message' => 'Tâche supprimée.'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;
use App\Models\Task;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;


class TaskController extends Controller
{
    public function index(int $id)
    {
        $folders = Folder::all();

        $folder = Folder::findOrFail($id);

        // $tasks = Task::where('folder_id', $folder->id)->get();
        $tasks = $folder->tasks()->get();

        return view('tasks.index', [
            'folders' => $folders,
            'folder_id' => $id,
            'tasks' => $tasks
        ]);
    }

    /**
     * Display Create task's page
     * 
     * GET /folders/{id}/tasks/create
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function showCreateForm(int $id)
    {
        return view('tasks.create', [
            'folder_id' => $id
        ]);
    }

    /**
     * Create Task's page
     * 
     * POST /folders/{id}/tasks/create
     * @param int $id
     * @param CreateTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(int $id, CreateTask $request)
    {
        $folder = Folder::find($id);

        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;
        $folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'id' => $folder->id,
            'folder_id' => $folder->folder_id
        ]);
    }

    /**
     * Get the target task to be edit
     * @param int $id
     * @param int $task_id
     * @return \Illuminate\View\View
     */
    public function showEditForm(int $id, int $task_id)
    {
        $task = Task::findOrFail($task_id);

        return view('tasks/edit', [
            'task' => $task,
            'folder_id' => $id,
        ]);
    }

    /**
     * Save the edited task
     * 
     * POST /folders/{id}/tasks/{task_id}/edit
     * @param int $id
     * @param int $task_id
     * @param EditTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(int $id, int $task_id, EditTask $request)
    {
        $task = Task::findOrFail($task_id);

        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);
    }

    /**
     * Display the task deletion page
     * 
     * GET /folders/{id}/tasks/{task_id}/delete
     * @param int $id
     * @param int $task_id
     * @return \Illuminate\View\View
     */
    public function showDeleteForm(int $id, int $task_id)
    {
        $task = Task::findOrFail($task_id);

        return view('tasks.delete', [
            'task' => $task,
        ]);
    }

    /**
     * Delete the target task
     * 
     * POST /folders/{id}/tasks/{task_id}/delete
     * @param int $id
     * @param int $task_id
     * return \Illuminate\View\View
     */
    public function delete(int $id, int $task_id)
    {
        $task = Task::findOrFail($task_id);
        $task->delete();

        return redirect()->route('tasks.index', [
            'id' => $id,
        ]);
    }
}

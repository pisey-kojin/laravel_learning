<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;
use App\Http\Requests\CreateFolder;
use App\Http\Requests\EditFolder;

class FolderController extends Controller
{
    /**
     * Display Create folder page
     * 
     * GET /folders/create
     * @return \Illuminate\View\View
     */
    public function showCreateForm()
    {
        $first_folder = Folder::first();
        return view('folders/create', [
            'first_folder_id' => $first_folder->id,
        ]);
    }

    /**
     * Create folder
     * 
     * POST /folders/create
     * @param Request $request (Request class)
     * @return \Illuminate\Http\RedirectResponse
     * @var App\Http\Requests\CreateFolder
     */
    public function create(CreateFolder $request)
    {
        $folder = new Folder();
        $folder->title = $request->title;
        $folder->save();

        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }

    /**
     * Get the target folder and display folder title
     * 
     * GET /folders/{id}/edit
     * @param $id
     * @return \Illuminate\View\View
     */
    public function showEditForm($id)
    {
        $folder = Folder::findOrFail($id);

        return view('folders/edit', [
            'folder_id' => $folder->id,
            'folder_title' => $folder->title,
        ]);
    }

    /**
     * Update the title of folder
     * 
     * POST /folders/{id}/edit
     * @param $id
     * @param EditTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(int $id, EditFolder $request)
    {
        $folder = Folder::findOrFail($id);
        $folder->title = $request->title;
        $folder->save();
        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }

    /**
     * Get the target Folder to be deleted
     * 
     * GET /folders/{id}/delete
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function showDeleteForm(int $id)
    {
        $folder = Folder::findOrFail($id);

        return view('folders/delete', [
            'folder_id' => $folder->id,
            'folder_title' => $folder->title,
        ]);
    }

    /**
     * Delete the target Folder
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(int $id)
    {
        $folder = Folder::findOrFail($id);
        $folder->tasks()->delete();
        $folder->delete();
        $folder = Folder::first();

        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }
}

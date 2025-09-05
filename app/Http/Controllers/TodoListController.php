<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoListRequest;
use App\Models\TodoList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TodoListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return view('index'); 
    }

    public function getTodoListData(Request $request)
    {
        $query = TodoList::select(['id', 'title', 'description', 'status', 'due_date']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoListRequest $request)
    {
        $todo = TodoList::create([
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => $request->status,
            'due_date'    => $request->due_date 
                                ? Carbon::parse($request->due_date) 
                                : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil ditambahkan!',
            'data'    => $todo
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TodoList $todoList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TodoList $todoList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TodoListRequest $request, $id)
    {
        $task = TodoList::findOrFail($id);
        $task->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil diperbarui'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = TodoList::findOrFail($id);
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dihapus'
        ]);
    }
}

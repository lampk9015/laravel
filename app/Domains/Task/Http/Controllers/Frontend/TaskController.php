<?php

namespace App\Domains\Task\Http\Controllers\Frontend;

use App\Domains\Task\Models\Task;
use Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class TaskController
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.task.index')
            ->withTasks($tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task();

        return view('frontend.task.create')
            ->withTask($task);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $task = new Task();

        $task->title = $request->title;
        $task->description = $request->description;
        $task->deadline_at = $request->deadline_at;
        $task->user_id = Auth::id();

        $task->save();

        return redirect('/tasks')->withFlashSuccess(__('The task was successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('/tasks');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Domains\Task\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return view('frontend.task.edit')
            ->withTask($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request       $request
     * @param  \App\Domains\Task\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $task->title = $request->title;
        $task->description = $request->description;
        $task->deadline_at = $request->deadline_at;

        $task->save();

        return redirect('/tasks')->withFlashSuccess(__('The task was successfully updated.'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request       $request
     * @param  \App\Domains\Task\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function markAsCompleted(Request $request, Task $task)
    {
        $task->is_completed = true;
        $task->save();

        return redirect('/tasks')->withFlashSuccess(__('The task was successfully marked as completed.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Domains\Task\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect('/tasks')->withFlashSuccess(__('The task was successfully deleted.'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    /**
     * Display the specified board.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Board $board
     * @return \Illuminate\View\View
     */
    public function show(Request $request, Board $board)
    {
        // Delete empty tasks
        foreach($board->task_users as $user){
            foreach ($user->tasks as $task) {
                if($task->titleIsEmpty()){
                    $task->delete();
                }
            }
        }

        return view('board.show', ['board' => $board->refresh()]);
    }

    /**
     * Store board.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(empty($request->title)){
            return back()->with([
                'status' => 'error',
                'message' => 'Please add board title.',
            ]);
        }

        $request->user()->boards()->create(['title' => $request->title]);

        return back()->with([
            'status' => 'success',
            'message' => 'Scccessfully Created.',
        ]);
    }
}

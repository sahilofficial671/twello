<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\TaskUser;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskController extends Controller
{
    /**
     * Store task.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $boardId
     * @param  int $taskUserId
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $boardId, $taskUserId)
    {
        try {
            $board = Board::findOrFail($boardId);
        } catch (ModelNotFoundException $e) {
            return response()->json('Board does not exist.');
        }

        try {
            $taskUser = $board->task_users()->findOrFail($taskUserId);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Task User does not exist'], 400);
        }

        $this->authorize('update', $board);

        $task = Task::create(['title' => $request->title, 'task_user_id' => $taskUser->id]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Task Created',
            'task' => $task
        ], 200);
    }

    /**
     * Update task.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $boardId
     * @param  int $taskUserId
     * @param  int $taskId
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $boardId, $taskUserId, $taskId)
    {
        try {
            $board = Board::findOrFail($boardId);
        } catch (ModelNotFoundException $e) {
            return response()->json('Board does not exist.');
        }

        try {
            $taskUser = $board->task_users()->findOrFail($taskUserId);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Task User does not exist'], 400);
        }

        try {
            $task = $taskUser->tasks()->findOrFail($taskId);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Task does not exist'], 400);
        }

        $this->authorize('update', $board);

        $task->update(['title' => $request->title]);

        return response()->json([
            'status'  => 'success',
            'task'    => $task->refresh(),
            'message' => 'Task updated.',
        ], 200);
    }

    /**
     * Destroy the task.
     *
     * @param  int $boardId
     * @param  int $taskUserId
     * @param  int $taskId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($boardId, $taskUserId, $taskId)
    {
        try {
            $board = Board::findOrFail($boardId);
        } catch (ModelNotFoundException $e) {
            return response()->json('Board does not exist.');
        }

        try {
            $taskUser = $board->task_users()->findOrFail($taskUserId);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Task User does not exist'], 400);
        }

        try {
            $task = $taskUser->tasks()->findOrFail($taskId);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Task does not exist'], 400);
        }

        $this->authorize('delete', $board);

        $task->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Successfully Deleted.',
        ], 200);
    }
}

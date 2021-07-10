<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\TaskUser;

class TaskUserController extends Controller
{
    /**
     * Store task user.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $boardId
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $boardId)
    {
        try {
            $board = Board::findOrFail($boardId);
        } catch (ModelNotFoundException $e) {
            return response()->json('Board does not exist.');
        }

        $this->authorize('update', $board);

        $board->task_users()->create(['name' => $request->name]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Task User Created',
        ], 200);
    }

    /**
     * Destroy the task user.
     *
     * @param  int $boardId
     * @param  int $taskUserId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($boardId, $taskUserId)
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

        $this->authorize('delete', $board);

        $taskUser->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Successfully Deleted.',
        ], 200);
    }
}

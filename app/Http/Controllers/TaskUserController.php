<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\TaskUser;

class TaskUserController extends Controller
{
    /**
     * Show task user.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $boardId
     * @param  int $taskUserId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $boardId, $taskUserId)
    {
        try {
            $board = Board::findOrFail($boardId);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Board does not exist.'], 400);
        }

        try {
            $taskUser = $board->task_users()->with('tasks')->findOrFail($taskUserId);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Task User does not exist'], 400);
        }

        $this->authorize('view', $board);

        return response()->json([
            'status'   => 'success',
            'task_user' => $taskUser,
        ], 200);
    }

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
            return response()->json(['status' => 'error', 'message' => 'Board does not exist.'], 400);
        }

        $this->authorize('update', $board);

        $board->task_users()->create(['name' => $request->name]);

        return back()->with([
            'status' => 'success',
            'message' => 'Scccessfully created task user.',
        ]);
    }

    /**
     * Update task user.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $boardId
     * @param  int $taskUserId
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $boardId, $taskUserId)
    {
        try {
            $board = Board::findOrFail($boardId);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Board does not exist.'], 400);
        }

        try {
            $taskUser = $board->task_users()->findOrFail($taskUserId);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Task User does not exist'], 400);
        }

        $this->authorize('update', $board);

        $taskUser->update(['name' => $request->name]);

        return response()->json([
            'status'  => 'success',
            'task'    => $taskUser->refresh(),
            'message' => 'Task user updated.',
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
            return response()->json(['status' => 'error', 'message' => 'Board does not exist.'], 400);
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

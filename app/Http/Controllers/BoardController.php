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
     * @param  Vehicle $vehicle
     * @return \Illuminate\View\View
     */
    public function show(Request $request, Board $board)
    {
        $board = Board::with(['task_users'])->first();
        dd($board);
        return view('board.show', ['board' => $board]);
    }
}

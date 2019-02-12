<?php

namespace App\Http\Controllers\Comments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comments\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->relationships = ['creator', 'editor'];
    }

    public function byStage ($stage)
    {
        return Comment::with($this->relationships)->where('stage_id', $stage)->latest()->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required|string',
            'stage_id' => 'required|numeric'
        ]);

        return Comment::create([
            'comment' => $request->comment,
            'stage_id' => $request->stage_id
        ])->load($this->relationships);
    }

    public function count ()
    {
        return Comment::count();
    }
}

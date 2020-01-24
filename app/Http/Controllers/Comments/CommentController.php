<?php

namespace App\Http\Controllers\Comments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comments\Comment;
use App\Models\Transactions\Transaction;
use App\Models\Stages\Stage;
use App\Notifications\AddCommentToTransaction;


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

        $comment = Comment::create([
            'comment' => $request->comment,
            'stage_id' => $request->stage_id
        ])->load($this->relationships);

        $stage = Stage::find($request->stage_id);
        $transaction = Transaction::find($stage->transaction_id);
        foreach ($transaction->users as $user) {
            $user->notify(new AddCommentToTransaction($transaction));
        }

        return $comment;
    }

    public function count ()
    {
        return Comment::count();
    }
}

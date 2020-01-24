<?php

namespace App\Http\Controllers\Files;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Upload;
use App\Models\Files\File;
use App\Models\Transactions\Transaction;
use App\Models\Stages\Stage;
use App\Notifications\UploadDocToTransaction;

class FileController extends Controller
{
    public function upload (Request $request)
    {
        $upload = new Upload();
        $file = $upload->upload($request->file, 'files/'.$request->stageId)->getData();

        $file =  File::create([
            'name' => $file['name'],
            'basename' => $file['basename'],
            'type' => $file['type'],
            'size' => $file['size'],
            'stage_id' => $request->stageId
        ]);


        $stage = Stage::find($request->stageId);
        $transaction = Transaction::find($stage->transaction_id);

        foreach ($transaction->users as $user) {
            $user->notify(new UploadDocToTransaction($transaction));
        }

        return File::with('creator')->find($file->id);
    }

    public function destroy ($file)
    {
        return File::destroy($file);
    }
}

<?php

namespace App\Http\Controllers\Files;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Upload;
use App\Models\Files\File;

class StageController extends Controller
{
    public function upload (Request $request)
    {
        $upload = new Upload();
        $file = $upload->upload($request->file, 'files/'.$request->stageId)->getData();

        return File::create([
            'name' => $file['name'],
            'basename' => $file['basename'],
            'type' => $file['type'],
            'size' => $file['size'],
            'stage_id' => $request->stageId
        ]);
    }

    public function destroy ($file)
    {
        return File::destroy($file);
    }
}

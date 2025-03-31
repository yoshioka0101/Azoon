<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function getSignedUrl(Request $request)
    {
        $fileName = 'example.pdf'; // ここを動的に変更可能
        $expiration = now()->addMinutes(10); // 10分有効

        $url = Storage::disk('s3')->temporaryUrl($fileName, $expiration);

        return response()->json(['url' => $url]);
    }
}

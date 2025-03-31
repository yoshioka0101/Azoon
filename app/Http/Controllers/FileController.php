<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Aws\S3\Exception\S3Exception;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{
    public function uploadVideo(Request $request)
    {
        try {
            // バリデーション
            $request->validate([
                'video' => 'required|mimes:mp4,mpeg,quicktime|max:5120000',
            ], [
                'video.required' => 'ファイルが選択されていません。',
                'video.mimes' => 'このファイル形式はアップロードできません。',
                'video.max' => 'ファイルサイズが5GBを超えています。',
            ]);

            $file = $request->file('video');
            $fileName = time() . '_' . $file->getClientOriginalName();

            $maxRetries = 3;
            for ($attempt = 0; $attempt < $maxRetries; $attempt++) {
                try {
                    //S3 にアップロード
                    $path = Storage::disk('s3')->put("videos/{$fileName}", file_get_contents($file));
                    
                    //ETag チェック (データ整合性)
                    $etag = Storage::disk('s3')->etag("videos/{$fileName}");
                    $fileHash = md5_file($file->getRealPath());
                    if ($etag !== $fileHash) {
                        throw new Exception("アップロードした動画が破損している可能性があります。再アップロードを試してください。");
                    }
                    
                    return response()->json([
                        'message' => 'アップロード成功',
                        'file_url' => Storage::disk('s3')->url("videos/{$fileName}")
                    ], Response::HTTP_OK);
                } catch (S3Exception $e) {
                    Log::warning("S3 アップロード失敗 (" . ($attempt + 1) . "/{$maxRetries}) - " . $e->getMessage());
                    if ($attempt === $maxRetries - 1) {
                        throw $e;
                    }
                    sleep(2); // リトライ間隔
                }
            }
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], Response::HTTP_BAD_REQUEST);
        } catch (S3Exception $e) {
            return response()->json(['error' => '現在S3のサービスが一時的に利用できません。しばらくしてから再試行してください。'], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            Log::error("動画アップロードエラー: " . $e->getMessage());
            return response()->json(['error' => '予期しないエラーが発生しました。再試行してください。'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

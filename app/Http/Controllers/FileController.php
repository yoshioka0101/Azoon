<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Aws\S3\Exception\S3Exception;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use FFMpeg\FFMpeg;
use FFMpeg\Exception\RuntimeException;

class FileController extends Controller
{
    public function uploadVideo(Request $request)
    {
        try {
            // バリデーション（ファイル形式・サイズ制限）
            $request->validate([
                'video' => 'required|mimes:mp4,mpeg,quicktime|max:5120000',
            ], [
                'video.required' => 'ファイルが選択されていません。',
                'video.mimes' => 'このファイル形式はアップロードできません。',
                'video.max' => 'ファイルサイズが5GBを超えています。',
            ]);

            $file = $request->file('video');
            $fileSize = $file->getSize();
            $fileName = time() . '_' . $file->getClientOriginalName();

            //動画の長さをチェック（30分以内）
            $ffmpeg = FFMpeg::create();
            $video = $ffmpeg->open($file->getRealPath());

            try {
                $duration = $video->getFormat()->get('duration'); // 秒数
                if ($duration > 1800) { // 30分 = 1800秒
                    return response()->json(['error' => '動画の長さが30分を超えています。'], Response::HTTP_BAD_REQUEST);
                }
            } catch (RuntimeException $e) {
                Log::error("動画の長さチェックに失敗: " . $e->getMessage());
            }

            // S3 アップロード時の再試行
            $maxRetries = 3;
            for ($attempt = 0; $attempt < $maxRetries; $attempt++) {
                try {
                    // S3 にアップロード
                    $path = Storage::disk('s3')->put("videos/{$fileName}", file_get_contents($file));

                    // データ整合性チェック (ETag)
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

                    // ネットワーク切断エラーをハンドリング
                    if (strpos($e->getMessage(), 'Connection timed out') !== false) {
                        return response()->json(['error' => 'ネットワーク接続が不安定です。接続を確認して再試行してください。'], Response::HTTP_SERVICE_UNAVAILABLE);
                    }

                    // S3ストレージ容量不足 (`507`)
                    if ($e->getStatusCode() === 507) {
                        return response()->json(['error' => 'S3のストレージ容量が不足しています。しばらくしてから再試行するか、管理者に問い合わせてください。'], Response::HTTP_INSUFFICIENT_STORAGE);
                    }

                    // S3一時障害 (500/502) のリトライ処理
                    if (in_array($e->getStatusCode(), [500, 502])) {
                        if ($attempt === $maxRetries - 1) {
                            throw $e;
                        }
                        sleep(2); // リトライ間隔
                    } else {
                        throw $e;
                    }
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

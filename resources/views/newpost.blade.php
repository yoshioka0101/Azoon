@extends('layouts.app')

@section('content')

<div class="row justify-content-center ml-0 mr-0 h-100">
    <div class = "col-md-8">
        
 
    <div class="container">
        <div class="card-header"> 
 

<div class="row justify-content-center ml-0 mr-0 h-100">
    <div class="card w-100">
        <div class="card-header">新規メモ作成</div>
        <div class="card-body">
            <form method='POST' action="/store" enctype="multipart/form-data">
                @csrf
                <input type='hidden' name='user_id' value="{{ $user['id'] }}">

                <!-- タイトルの入力 -->
                <div class="form-group">
                    <input type=”text” name='title'  size=”50″ maxlength=”60″ placeholder="タイトルを入力">
                </div>

                <div class="form-group">
                     <textarea name='content' class="form-control"rows="10" placeholder="補足や備考情報を入力してください"></textarea>
                </div>

                
                <!--画像表示-->
                <div class="form-group">
                    <label for="image">動画投稿</label>
                    <input type="file" class="form-control-file" name='image' id="image">
                </div>
                <!--URLをとってくる-->
                <div class="form-group">
                <div class="mb-3">
                    <label for="url" class="form-label">URLの入力してください</label>
                    <input type="text" id="url" class="form-control" name='url'  placeholder="URL">
                </div>
            
                            </div>
</div>
        </div>
                <button type='submit' class="btn btn-primary btn-lg">保存</button>
            </form>
        </div>
    </div>
</div>
@endsection

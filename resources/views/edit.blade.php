@extends('layouts.app')

@section('content')
<div class="row justify-content-center ml-0 mr-0 h-100">
    <div class = "col-md-8">
        
 
    <div class="container">
        <div class="card-header"> 
 

<div class="row justify-content-center ml-0 mr-0 h-100">
    <div class="card w-100">

<div class="row justify-content-center ml-0 mr-0 h-100">
    <div class="card w-100">
        <div class="card-header">メモ編集</div>

        <!-- メモの内容-->
            <div class="card-body">
            <form method='POST' action="{{route('update',['id' => $memo['id']] ) }}" enctype="multipart/form-data">
                @csrf
                <input type='hidden' name='user_id' value="{{ $user['id'] }}">

                <!-- タイトルの表示 -->
                    <div class="form-group">
                    <input type=”text” name='title' class="form-control"rows="10">{{ $memo['title'] }}</input>
                    </div>

                <div class="form-group">
                     <textarea name='content' class="form-control"rows="10">
                         {{ $memo['content'] }}
                    </textarea>

                    
                    <div class="form-group">
                    <label for="image">画像のupload</label>
                      
                    <input type="file" class="form-control-file" name='image' id="image">
                </div>
                    
                        <!--URLをとってくる-->
                    <div class="mb-3">
                        <label for="disabledTextInput" class="form-label">URLの入力してください</label>  
                        <input type="text" id="disabledTextInput" class="form-control" name='url' placeholder="URL">
                    </div>

                </div>

                <div class="form-group">
                </div>
                <button type='submit' class="btn btn-primary btn-lg">更新する</button>
            </form>
            
        </div>
    </div>
</div>
@endsection



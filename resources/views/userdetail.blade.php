@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <table class="table">

                <h1>プロフィール</h1>
                <h3 class="profile"><i class="fas fa-user-alt"></i> 基本情報</h3>
                
                <p>名前  :  {{ $user->name }}</p>
                @can('admin-higher')
                <p>メールアドレス  :  {{ $user->email }}</p>
                @endcan
                    

                <h3 class="profile"><i class="fas fa-key"></i>  ユーザ権限</h3>
                <p>現在の権限 :
                    @if($user->role == 1)
                        管理者
                    @else
                        一般ユーザー
                    @endif
                </p>

                @if($user->role == 1)
                <form method = 'POST' action = "/accountdelete/{{ $user['id'] }}" id = 'accountdelete-form'>        
                    @csrf        
                <button type="submit" class="btn btn-danger" >管理者削除する</button>
                </form> 

                @else
                <form method = 'POST' action = "/account/{{ $user['id'] }}" id = 'account-form'>
                    @csrf
                <button type="submit" class="btn btn-danger" >管理者にする</button>
                </form>
                @endif
                

                <h3 class="profile"><i class="fas fa-film"></i>  研修一覧</h3>
                
            <table class="table table-striped table-hover">
            
                        <tr>
                        <th scope="col">タイトル</th>
                        <th scope="col">更新日付</th>
                        <th >削除ボタン</th>
                        </tr>
                    </thead>
                @foreach($memos AS $memo)
                    <tbody>
                        <tr>
                        <td>
                            <a href = "/content/{{ $memo['id'] }}" id="memo-title">
                            {{ $memo['title'] }}
                            </a>
                        </td>
                        <td>
                            {{ $memo['updated_at'] }}
                        </td>

                        <td>
                        <!-- 削除ボタン-->
                        @can('admin-higher')
                        <form method = 'POST' action = "/delete/{{ $memo['id'] }}" id = 'delete-form'>
                        @endcan
                            @csrf
                            <button><i id = 'delete-button' class = "fas fa-trash"></i></button>
                        </form>
                        </td>
                        </tr>
                    </tbody>
                    @endforeach
                    
            </table>

                    </table>
                    
                    <a href ='/userlist' class="btn btn-primary btn-lg" style ='width:90px'>戻る</a>

            </div>
    </div>
</div>
@endsection

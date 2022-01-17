@extends('layouts.app')

@section('content')

        <!-- Masthead-->
        <header class="masthead">
        
        <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <form action="{{route ('search')}}" method="GET">
                    <p><input type="text" name="keyword" value=""></p>
                    <p><input type="submit" value="検索"></p>
                </form>



            <table class="table table-striped table-hover">
            
                        <tr>
                        <th scope="col">研修完了</th>
                        <th scope="col">タイトル</th>
                        <th scope="col">更新日付</th>
                        <th scope="col">更新ボタン</th>
                        <th >削除ボタン</th>
                        </tr>
                    </thead>
                    @foreach($memos AS $memo)
                    <tbody>
                        <tr>
                        <th scope="row">
                        @if($memo->users()->where('user_id', Auth::id())->exists())
                        <i id = 'check-icon' class="far fa-check-square"></i>
                        @endif
                        </th>
                        <td>
                            <a href = "/content/{{ $memo['id'] }}" id="memo-title">
                            {{ $memo['title'] }}
                            </a>
                        </td>

                        <td>

                            {{ $memo['updated_at'] }}
                        </td>

                        <td>
                        @can('admin-higher')
                          <a href = "/edit/{{ $memo[ 'id' ] }}" class="btn btn-primary">編集する </a>
                        @endcan
                        </td>

                        <td>
                        <!-- 削除ボタン-->
                        @can('admin-higher')
                        <form method = 'POST' action = "/delete/{{ $memo['id'] }}" id = 'delete-form'>
                            @csrf
                            <button onclick="return confirm('削除してもよろしいですか？')"><i id = 'delete-button' class = "fas fa-trash"></i></button>
                        </form>
                        @endcan
                        </td>
                        </tr>
                    </tbody>
                    @endforeach
                    
                    
            </table>

                    </table>
                    @can('admin-higher')
                    <a href = "/newpost" class = "btn newpost">新規メモ作成</a>
                    @endcan

    @foreach($memos as $link)
            <div class = 'content'>
            </div>
        @endforeach

        {{$memos->links()}}

        </div>
    </div>
</div>
@endsection

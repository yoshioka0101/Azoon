@extends('layouts.app')

@section('content')
<div class="row justify-content-center ml-0 mr-0 h-100">
    <div class = "col-md-8">
        
 
 
    <div class="container">
        <div class="card-header"> 
            <div class="block">
            タイトル:    {{ $memo['title'] }}</div>
                     <br>
                <!-- 画像と動画で分岐する -->

                     <video width="100%" height="80%" src="{{ '/storage/' . $memo->image}}"  class = "movie" controls > 
                    </video>
                    </p>
                    <br>

                    <div class="memo-content" >
                    
                    <p>{{ $memo['content'] }} </p>

                    </div>

                
                <!-- URLをaで表示する -->
                <div class="url">
                <p>研修後のアンケートフォーム<br>
                <a href ="{{ $memo['url'] }}" class="content-a"> {{ $memo['url']}}  </a></p>
                </div>

                <br>

                <a href ='/home' class="btn btn-primary btn-lg" style ='width:90px'>戻る</a>


                                    
                @if($memo->users()->where('user_id', Auth::id())->exists())
                    <form action="{{ route('unfavorites', $memo) }}" method="POST" class="btn">
                    @csrf
                    <input type="submit" value="完了取り消し" class="fas btn btn-danger">
                    </form>

                    @else
                    <form action="{{ route('favorites', $memo) }}" method="POST" class="btn">
                    @csrf
                    <input type="submit" value=" 完了 " class="fas btn btn-success">
                    </form>

                    @endif
                    <div class="row justify-content-center">
                        <p>完了ユーザー数:{{ $memo->users()->count() }}</p>
                    </div>

                @can('admin-higher')
                    <a href = "/like" class = "btn newpost">研修済ユーザー</a>
                    @endcan


</div>
        </div>
    </div>
</div>
</div>
@endsection

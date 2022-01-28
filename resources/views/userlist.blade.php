@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <table class="table">


                    <thead class = "table-dark">
                        <tr>
                        <th scope="col">ユーザー名前</th>
                        <th scope="col">研修済</th>
                        </tr>
                    </thead>
                    <tbody style="text-align:center; vertical-align: middle;">
                    @foreach($userlist as $list)
                    <tr>
                    <td>
                        <a href = "/userdetail/{{ $list['id'] }}" id="memo-title" style="margin:0 auto;">
                                {{ $list['name'] }}
                            </a>
                    </td>

                    <th scope="row">


                <form action = "{{route('unfollow',$list)}}" method = "POST">
                    @csrf
                    <input type="submit" value=" フォロー解除 " class="fas btn btn-danger">
                </form>

                <form action = "{{route('follow',$list)}}" method = "POST">
                    @csrf
                    <input type="submit" value=" フォロー " class="fas btn btn-primary"  >
                </form>
                

                    </th>


                        </tr>
                        @endforeach

                    </tbody>

                    </table>

                </div>
    </div>
</div>
@endsection
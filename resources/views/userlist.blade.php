@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <table class="table">

                <h1>ユーザ一覧</h1>
                    <thead class = "table-dark">
                        <tr>
                        <th scope="col">ユーザー名前</th>
                        <th scope="col">研修済</th>
                        <th scope="col">研修未完</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($userlist as $list)
                    <tr>
                    <td>
                        <a href = "/userdetail/{{ $list['id'] }}" class="name" >
                                {{ $list['name'] }}
                            </a>
                    </td>

                    <th scope="row">

                    {{ $memos }}
                    </th>

                    <th scope="row">

                    </th>


                        </tr>
                        @endforeach

                    </tbody>

                    </table>

                </div>
    </div>
</div>
@endsection
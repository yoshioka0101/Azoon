@extends('layouts.app')

@section('content')


<header class="masthead">
<h1>検索</h1>

<form action="{{route ('search')}}" method="GET">
    <p><input type="text" name="keyword" value="{{$keyword}}"></p>
    <p><input type="submit" value="検索"></p>
</form>

@if($memo->count())
        
        <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">


<table class="table table-striped table-hover">
            
            <tr>
            <th scope="col">title</th>
            <th scope="col">content</th>
            </tr>
        </thead>

        @foreach($memo AS $mem)
        <tbody>
            <tr>
            <td>
            <a href = "/content/{{ $mem['id'] }}" id="memo-title">
                            {{ $mem['title'] }}
            </a>
            </td>
                <td>{{ $mem->content }}</td>
            </tr>
        </tbody>
        @endforeach
        
        
</table>



@else
<p class="notfound">見つかりませんでした。</p>
@endif

@endsection



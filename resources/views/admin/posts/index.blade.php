@extends('layouts.app')

@section('page_title', 'Lista Post')

@section('content')
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titolo</th>
                <th>Slug</th>
                <th>Contenuto</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($posts as $post)
            <tr>
                <td>{{$post->id}}</td>
                <td>{{$post->title}}</td>
                <td>{{$post->slug}}</td>
                <td>{{$post->content}}</td>
                <td>
                    <div class="d-flex gap-2">
                        <a class="btn btn-info" href="{{ route('admin.posts.show', $post->slug) }}">Dettagli</a>
                        <a class="btn btn-warning" href="{{ route('admin.posts.edit', $post->slug) }}">Modifica</a>
                        
                    </div>
                    
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
    <div class="text-center py-3">
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">Aggiungi Post</a>
    </div>
@endsection
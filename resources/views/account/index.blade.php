@extends('layouts.myLayout')

@section('content')
    <h1>Categories</h1>
    <ul>
        @foreach($categories as $category)
            <li>
                <a href="{{ route('categories.show', $category->id) }}">{{ $category->category_name }}</a>
            </li>
        @endforeach
    </ul>
@endsection

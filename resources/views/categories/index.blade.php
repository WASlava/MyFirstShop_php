@extends('layouts.myLayout')

@section('content')
    <div class="container">
        <h1>Categories</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Create New Category</a>

        @if ($categories->isEmpty())
            <p>No categories available.</p>
        @else
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Parent Category</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->category_name }}</td>
                        <td>{{ $category->parentCategory ? $category->parentCategory->category_name : 'None' }}</td>
                        <td>
                            <a href="{{ route('categories.show', $category->id) }}" class="btn btn-info btn-sm">Show</a>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

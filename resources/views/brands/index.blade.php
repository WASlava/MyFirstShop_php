@extends('layouts.myLayout')

@section('content')
    <div class="container">
        <h1>Brands List</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{ route('brands.create') }}" class="btn btn-primary mb-3">Create New Brand</a>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Brand Name</th>
                <th>Country</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($brands as $brand)
                <tr>
                    <td>{{ $brand->id }}</td>
                    <td>{{ $brand->brand_name }}</td>
                    <td>{{ $brand->country }}</td>
                    <td>
                        <a href="{{ route('brands.show', $brand->id) }}" class="btn btn-sm btn-outline-info" title="Details">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2" />
                            </svg>
                        </a> |

                        <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-sm btn-outline-success" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                                <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001" />
                            </svg>
                        </a> |

                        <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this item?')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-dash-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M11 7.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5" />
                                    <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                </svg>
                            </button>
                        </form>
                    </td>

                    {{--                    <td>--}}
{{--                        <a href="{{ route('brands.show', $brand->id) }}" class="btn btn-info">View</a>--}}
{{--                        <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-warning">Edit</a>--}}
{{--                        <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" style="display:inline-block;">--}}
{{--                            @csrf--}}
{{--                            @method('DELETE')--}}
{{--                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>--}}
{{--                        </form>--}}
{{--                    </td>--}}
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection



{{--@section('content')--}}
{{--    <div class="container">--}}
{{--        <h1>Brands</h1>--}}
{{--        <a href="{{ route('brands.create') }}" class="btn btn-primary mb-3">Create New Brand</a>--}}
{{--        <table class="table table-bordered">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th>ID</th>--}}
{{--                <th>Brand Name</th>--}}
{{--                <th>Country</th>--}}
{{--                <th>Actions</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @foreach($brands as $brand)--}}
{{--                <tr>--}}
{{--                    <td>{{ $brand->id }}</td>--}}
{{--                    <td>{{ $brand->brand_name }}</td>--}}
{{--                    <td>{{ $brand->country }}</td>--}}
{{--                    <td>--}}
{{--                        <a href="{{ route('brands.show', $brand->id) }}" class="btn btn-info">Show</a>--}}
{{--                        <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-warning">Edit</a>--}}
{{--                        <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" style="display:inline-block;">--}}
{{--                            @csrf--}}
{{--                            @method('DELETE')--}}
{{--                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>--}}
{{--                        </form>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--    </div>--}}
{{--@endsection--}}

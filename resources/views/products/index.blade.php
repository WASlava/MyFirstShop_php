
@extends('layouts.myLayout')

@section('content')
    <h1>Products</h1>

    @if (!(Auth::check()) || !(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Manager')))
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
            @foreach ($products as $product)
                <div class="col col-sm col-md">
                    <a href="{{ route('products.show', $product->id) }}">
                        @include('profile.partials._product_card', ['model' => $product])
                    </a>
                </div>
            @endforeach
        </div>
        @else

            <p><a href="{{ route('products.create') }}">Create New</a></p>

            <table class="table">
                <thead>
                <tr>
                    <th>@sortablelink('title', 'Title')</th>
                    <th>@sortablelink('price', 'Price')</th>
                    <th>@sortablelink('description', 'Description')</th>
                    <th>@sortablelink('brand.name', 'Brand')</th>
                    <th>@sortablelink('category.name', 'Category')</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->brand->brand_name }}</td>
                        <td>{{ $product->category->category_name }}</td>
                        <td class="white-space-nowrap">
                            @if (Auth::check() && (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Manager')))
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-success" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001" />
                                    </svg>
                                </a> |
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-info" title="Details">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2" />
                                    </svg>
                                </a> |
                                <a href="{{ route('products.destroy', $product->id) }}" class="btn btn-sm btn-outline-danger" title="Delete" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $product->id }}').submit();">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-dash-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M11 7.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5" />
                                        <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                    </svg>
                                </a>
                                <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @else
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-info" title="Details">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2" />
                                    </svg>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
@endsection

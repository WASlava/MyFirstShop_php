{{--@php--}}
{{--    $categories = app(\App\Http\Services\CategoryService::class)->getCategoriesMenu();--}}
{{--@endphp--}}

{{--<x-categories-menu :categories="$categories" />--}}

@foreach($categories as $category)
    <div>
        <h4>{{ $category->name }}</h4>
        @if ($category->childCategories)
            <ul>
                @foreach($category->childCategories as $childCategory)
                    <li>{{ $childCategory->name }}</li>
                    @if ($childCategory->childCategories)
                        <ul>
                            @foreach($childCategory->childCategories as $grandChildCategory)
                                <li>{{ $grandChildCategory->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                @endforeach
            </ul>
        @endif
    </div>
@endforeach

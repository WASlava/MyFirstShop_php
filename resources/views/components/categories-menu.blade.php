@php
    $currentAction = request()->route()->getName(); // Отримуємо поточний маршрут
@endphp

<nav id="second-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                @foreach ($categories as $mainCategory)
                    @if ($mainCategory->childCategories->isNotEmpty()) {{-- Якщо є дочірні категорії --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{ route($currentAction, ['categoryId' => $mainCategory->id]) }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $mainCategory->category_name }}
                        </a>
                        <ul class="dropdown-menu">
                            @foreach ($mainCategory->childCategories as $childCategory)
                                @if ($childCategory->childCategories->isNotEmpty())
                                    <li class="nav-item dropdown">
                                        <a class="dropdown-item dropdown-toggle" href="{{ route($currentAction, ['categoryId' => $childCategory->id]) }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ $childCategory->category_name }}
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach ($childCategory->childCategories as $grandChildCategory)
                                                <li>
                                                    <a class="dropdown-item" href="{{ route($currentAction, ['categoryId' => $grandChildCategory->id]) }}">
                                                        {{ $grandChildCategory->category_name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li>
                                        <a class="dropdown-item" href="{{ route($currentAction, ['categoryId' => $childCategory->id]) }}">
                                            {{ $childCategory->category_name }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route($currentAction, ['categoryId' => $mainCategory->id]) }}">
                                {{ $mainCategory->category_name }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</nav>

@extends('Dashboard.modules.frontend.layout.layout')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6 mx-auto text-center">
                        <h1 class="m-0">Categories</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container">
                <div class="row justify-content-center">
                    @foreach($categories as $category)
                        <div class="col-lg-8 col-md-8 col-sm-10 mb-2">
                            <a href="{{ route('front.products', $category->id) }}" class="category-link" style="text-decoration: none;">
                                <div class="card h-100 shadow-sm mx-auto" style="width: 60%;">
                                    <div class="card-body d-flex flex-column justify-content-between text-center">
                                        <h5 class="card-title font-weight-bold text-primary">
                                            {{ $category->name }}
                                        </h5>

                                        @if($category->description)
                                            <p class="card-text text-muted">
                                                {{ Str::limit($category->description, 100) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="row justify-content-center">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            @if ($categories->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">Previous</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $categories->previousPageUrl() }}">Previous</a></li>
                            @endif

                            @for ($i = 1; $i <= $categories->lastPage(); $i++)
                                <li class="page-item {{ ($categories->currentPage() == $i) ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $categories->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            @if ($categories->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $categories->nextPageUrl() }}">Next</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">Next</span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .category-link .card {
        transition: transform 0.3s ease;
    }

    .category-link:hover .card {
        transform: scale(1.05);
    }

    .category-link {
        display: block;
    }

    .card {
        margin-bottom: 20px;
    }
</style>
@endpush

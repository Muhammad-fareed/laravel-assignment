@extends('Dashboard.modules.frontend.layout.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-12 text-center">
                        <h1 class="m-0">Products in "{{ $category->name }}"</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <!-- Loop through products -->
                    @foreach($products as $product)
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card h-100 shadow-sm border-0">
                                <!-- Display product image or fallback to placeholder if not available -->
                                <img src="{{ $product->images[0]->image_path ? asset('storage/' . $product->images[0]->image_path) : 'https://via.placeholder.com/400x200?text=No+Image+Available' }}"
                                     class="card-img-top img-fluid"
                                     alt="{{ $product->name }}"
                                     style="max-height: 200px; object-fit: cover;">

                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text text-muted">
                                        Price: <strong>{{ $product->price }}</strong><br>
                                        {{ $product->description ?? 'No description available' }}
                                    </p>
                                </div>
                                <div class="card-footer bg-transparent border-0 text-center">
                                    <a href="{{ route('product.detail', $product->id) }}" class="btn btn-primary btn-block">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- /.row -->

                <!-- If no products available -->
                @if($products->isEmpty())
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <h5 class="text-muted">No products available in this category.</h5>
                        </div>
                    </div>
                @endif
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection

@push('styles')
    <style>
        /* Card adjustments for better appearance */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        /* Ensuring uniform height */
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Make product images responsive */
        .card-img-top {
            border-bottom: 1px solid #f0f0f0;
        }

        /* Product text styling */
        .card-text {
            font-size: 0.9rem;
        }

        /* Category title styling */
        h1 {
            font-weight: bold;
            margin-bottom: 40px;
            color: #333;
        }
    </style>
@endpush

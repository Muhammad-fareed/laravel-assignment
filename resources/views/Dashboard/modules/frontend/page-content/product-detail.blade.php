@extends('Dashboard.modules.frontend.layout.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $product->name }}</h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Product Detail Card -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <!-- Product Images -->
                                <div id="productImages" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner" style="max-height: 300px;">
                                        @if($product->images->isNotEmpty())
                                            @foreach($product->images as $index => $image)
                                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                    <img src="{{ asset('storage/' . $image->image_path) }}" class="d-block w-100" alt="{{ $product->name }}" style="object-fit: cover; height: 300px;">
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="carousel-item active">
                                                <img src="https://via.placeholder.com/800x400" class="d-block w-100" alt="No Image Available" style="object-fit: cover; height: 300px;">
                                            </div>
                                        @endif
                                    </div>
                                    <a class="carousel-control-prev" href="#productImages" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#productImages" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>

                                <h5 class="mt-4">Description</h5>
                                <p>{{ $product->description ?? 'No description available' }}</p>

                                <h5>Price</h5>
                                <p>{{ $product->price }}</p>

                                <h5>Categories</h5>
                                @foreach($product->categories as $category)
                                    <span class="badge badge-secondary">{{ $category->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <!-- Comment Section -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5>Comments</h5>

                                <!-- Show comments -->
                                @foreach($product->comments->take(5) as $comment) <!-- Show latest 5 comments -->
                                    <div class="card mb-2">
                                        <div class="card-body p-2">
                                            <h6 class="card-title">{{ $comment->user->name }}</h6>
                                            <p class="card-text">{{ $comment->content }}</p>
                                            <p class="text-muted small">{{ $comment->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Add Comment Form (only for logged-in users) -->
                                @auth
                                    <form action="{{ route('comment.store', $product->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="comment">Leave a comment</label>
                                            <textarea name="message" id="comment" class="form-control" rows="3" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit Comment</button>
                                    </form>
                                @else
                                    <p class="text-muted">You must be logged in to provide comments.</p>
                                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                                @endauth
                            </div>
                        </div>

                        <!-- Feedback Section -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5>Feedback</h5>

                                <!-- Show feedback -->
                                @foreach($product->feedback->take(5) as $feedback) <!-- Show latest 5 feedbacks -->
                                    <div class="card mb-2">
                                        <div class="card-body p-2">
                                            <h6 class="card-title">{{ $feedback->user->name }}</h6>
                                            <p class="card-text">{{ $feedback->message }}</p>
                                            <p class="text-muted small">{{ $feedback->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Add Feedback Form (only for logged-in users) -->
                                @auth
                                    <form action="{{ route('feedback.store', $product->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="feedback">Leave your feedback</label>
                                            <textarea name="message" id="feedback" class="form-control" rows="3" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit Feedback</button>
                                    </form>
                                @else
                                    <p class="text-muted">You must be logged in to provide feedback.</p>
                                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

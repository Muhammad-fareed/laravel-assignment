@extends('Dashboard.layout.layout2')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Products</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#createproductModal">
                            Create
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <div id="success_message"></div>
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Description</th>
                                            <th>Images</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productTableBody">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- create model start --}}
    <div class="modal fade" id="createproductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div id="error_list"></div>
                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="name form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="price">Price</label>
                        <input type="number" name="price" class="price form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="description">Description</label>
                        <textarea class="form-control description" name="description" rows="3" placeholder="Enter ..."></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Category</label>
                        <select multiple="" name="category[]" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="files">files</label>
                        <input type="file" name="files[]" multiple class="files form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary create_product">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    {{-- create model end --}}

    {{-- edit model start --}}
    <div class="modal fade" id="edit_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div id="edit_error_list"></div>
                    <input type="hidden" id="product_id">
                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="edit_name">
                    </div>
                    <div class="form-group mb-3">
                        <label for="price">Price</label>
                        <input type="number" name="price" class="form-control" id="edit_price">
                    </div>
                    <div class="form-group mb-3">
                        <label for="description">Description</label>
                        <textarea class="form-control description" id="edit_description" name="description" rows="3"
                            placeholder="Enter ..."></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Category</label>
                        <select multiple="" name="category[]" class="form-control" id="edit_category">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="files">files</label>
                        <input type="file" name="files[]" multiple class="form-control" id="edit_files">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update_product">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    {{-- edit model end --}}
    {{-- Delete model starts --}}
    <div class="modal fade" id="delete_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this!</p>
                    <input type="hidden" id="delete_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary destroy_product">Delete</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Delete model ends --}}
@endsection

@section('footer')
    @include('Dashboard.includes.product-scripts')
@endsection

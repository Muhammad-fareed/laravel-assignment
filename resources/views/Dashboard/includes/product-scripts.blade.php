<script>
    $(document).ready(function() {
        fetchproducts();

        function fetchproducts() {
            // Get the DataTable instance
            var table = $('#example1').DataTable();

            // Fetch new data
            $.ajax({
                type: "GET",
                url: "{{ route('product.fetch.products') }}", // Adjust with your correct route
                dataType: "json",
                success: function(response) {
                    // Clear the current data from DataTable
                    table.clear().draw();

                    // Iterate through the new data and append to DataTable
                    $.each(response.products, function(key, product) {
                        // Ensure product description exists, otherwise handle null/undefined cases
                        var description = product.description ? product.description :
                            'No description available';

                        // Initialize an empty string for images
                        var imagesHtml = '';

                        // Loop through each image associated with the product
                        if (product.images && product.images.length > 0) {
                            $.each(product.images, function(index, image) {
                                // Assuming 'image.url' contains the URL of the image
                                imagesHtml +=
                                    `<img src="{{ url('storage/${image.image_path}') }}" alt="Product Image" style="width: 50px; height: 50px; margin-right: 5px;">`;
                            });
                        } else {
                            imagesHtml = 'No images available';
                        }

                        // Add new rows to the DataTable
                        table.row.add([
                            product.name,
                            product.price,
                            description,
                            imagesHtml, // Add the images HTML here
                            `<button value="${product.id}" class="btn btn-success edit_product">Edit</button>
                 <button value="${product.id}" class="btn btn-danger delete_product">Delete</button>`
                        ]).draw(false); // Draw the table without resetting paging
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Failed to fetch products:", error);
                }
            });
        }
        $(document).on('click', '.delete_product', function(e) {
            $('#delete_product').modal('show');
            var id = $(this).val();
            $("#delete_id").val(id);

        });
        $(document).on('click', '.destroy_product', function(e) {
            e.preventDefault();
            var id = $('#delete_id').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "DELETE",
                url: `{{ route('product.destroy', ['product' => ':id']) }}`.replace(':id',
                    id),
                dataType: "json",
                success: function(response) {
                    if (response.status == "200") {
                        console.log('here');

                        $('#success_message').html('');
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        setTimeout(() => {
                            $('#success_message').fadeOut(500, function() {
                                $(this).html('').removeClass(
                                        'alert alert-success')
                                    .show(); // Clear content after fading out
                            });
                        }, 2000);
                        $('#delete_product').modal('hide');
                        fetchproducts();
                    }
                }
            });

        });
        //editing product
        $(document).on('click', '.edit_product', function(e) {
            $('#edit_product').modal('show');
            var id = $(this).val();
            $.ajax({
                type: "GET",
                url: `{{ route('product.edit', ['product' => ':id']) }}`.replace(':id', id),
                dataType: "json",
                success: function(response) {
                    if (response.status == "200") {
                        $('#edit_name').val(response.product.name);
                        $('#edit_price').val(response.product.price);
                        $('#edit_description').val(response.product.description);
                        $('#product_id').val(response.product.id);

                        // Clear the existing options
                        $('#edit_category').empty();

                        // Dynamically create options using JavaScript's forEach method
                        response.categories.forEach(function(category) {
                            let option = new Option(category.name, category.id,
                                false, false);
                            $('#edit_category').append(option);
                        });

                        // Select the categories associated with the product
                        response.product.categories.forEach(function(category) {
                            $('#edit_category option[value="' + category.id + '"]')
                                .prop('selected', true);
                        });

                        // Re-initialize Select2 (if you are using it)

                        $('#edit_category').val(response.product.categories.map(category =>
                            category.id)).trigger('change');
                    }
                }
            });
        });
        $(document).on('click', '.update_product', function(e) {
            e.preventDefault();

            var id = $('#product_id').val();
            var editFormData = new FormData();

            // Append form fields to editFormData
            editFormData.append('name', $('#edit_name').val().trim());
            editFormData.append('price', $('#edit_price').val().trim());
            editFormData.append('description', $('#edit_description').val().trim());

            // Append selected categories
            $('#edit_category option:selected').each(function() {
                editFormData.append('category[]', $(this).val());
            });

            // Append images
            var imageInput = document.querySelector('#edit_files');
            if (imageInput && imageInput.files.length > 0) {
                var images = imageInput.files;
                for (var i = 0; i < images.length; i++) {
                    editFormData.append('files[]', images[i]);
                }
            }

            // This is the key step: Append the '_method' field to simulate a PUT request
            editFormData.append('_method', 'PUT');

            // Setup CSRF token for the request
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Make the AJAX request to update the product
            $.ajax({
                type: "POST",
                url: `{{ route('product.update', ['product' => ':id']) }}`.replace(':id', id),
                data: editFormData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.status == 400) {
                        $('#edit_error_list').html('');
                        $('#edit_error_list').addClass('alert alert-danger');
                        $.each(response.errors, function(key, err_value) {
                            $('#edit_error_list').append('<li>' + err_value +
                                '</li>');
                        });
                    } else {
                        $('#edit_error_list').html('');
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        setTimeout(() => {
                            $('#success_message').fadeOut(500, function() {
                                $(this).html('').removeClass(
                                        'alert alert-success')
                                    .show(); // Clear content after fading out
                            });
                        }, 2000);
                        $('#edit_product').modal('hide');
                        $('#edit_product').find('input, textarea').val(
                            ''); // Clear input fields
                        fetchproducts(); // Refresh the product list
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error occurred:', error);
                    $('#edit_error_list').html(
                            '<li>An error occurred while updating the product.</li>')
                        .addClass('alert alert-danger');
                }
            });
        });
        $(document).on('click', '.create_product', function(e) {
            e.preventDefault();
            // Create a new FormData instance
            var formData = new FormData();
            formData.append('name', $('.name').val());
            formData.append('price', $('.price').val());
            formData.append('description', $('.description').val());

            var categories = [];
            $('select[name="category[]"] option:selected').each(function() {
                formData.append('category[]', $(this).val());
                categories.push($(this).val());
            });
            console.log('Selected categories:', categories);

            var imageInput = document.querySelector(
                '.files');
            console.log(imageInput);

            if (imageInput && imageInput.files.length > 0) {
                var images = imageInput.files;
                for (var i = 0; i < images.length; i++) {
                    formData.append('files[]', images[i]);
                    console.log('Adding image to form data:', images[i].name);
                }
            } else {
                console.log('No images selected or input not found');
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                type: "POST",
                url: "{{ route('product.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list').html('').addClass('alert alert-danger');
                        $.each(response.errors, function(key, err_value) {
                            $('#error_list').append('<li>' + err_value + '</li>');
                        });
                    } else {
                        $('#success_message').html('').addClass('alert alert-success').text(
                            response.message);
                        setTimeout(() => {
                            $('#success_message').fadeOut(500, function() {
                                $(this).html('').removeClass(
                                        'alert alert-success')
                                    .show();
                            });
                        }, 2000);
                        $('#createproductModal').modal('hide');
                        $('.name').val('');
                        $('.price').val('');
                        $('.description').val('');
                        $('select[name="category[]"]').val([]);
                        $('.files').val('');
                        fetchproducts();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $('#error_list').html('').addClass('alert alert-danger');
                        $.each(errors, function(key, err_value) {
                            $('#error_list').append('<li>' + err_value[0] +
                                '</li>');
                        });
                    }
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        fetchCategories();


        function fetchCategories() {
            // Get the DataTable instance
            var table = $('#example1').DataTable();

            // Fetch new data
            $.ajax({
                type: "GET",
                url: "{{ route('category.fetch.categories') }}", // Adjust with your correct route
                dataType: "json",
                success: function(response) {
                    // Clear the current data from DataTable
                    table.clear().draw();

                    // Iterate through the new data and append to DataTable
                    $.each(response.categories, function(key, value) {
                        // Add new rows to the DataTable
                        table.row.add([
                            value.name,
                            `<button value="${value.id}" class="btn btn-success edit_category">Edit</button>
                 <button value="${value.id}" class="btn btn-danger delete_category">Delete</button>`
                        ]).draw(false); // Draw the table without resetting paging
                    });
                }
            });
        }
        $(document).on('click', '.delete_category', function(e) {
            $('#delete_category').modal('show');
            var id = $(this).val();
            $("#delete_id").val(id);

        });
        $(document).on('click', '.destroy_category', function(e) {
            e.preventDefault();
            var id = $('#delete_id').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "DELETE",
                url: `{{ route('category.destroy', ['category' => ':id']) }}`.replace(':id',
                    id),
                dataType: "json",
                success: function(response) {
                    if (response.status == "200") {
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
                        $('#delete_category').modal('hide');
                        fetchCategories();
                    }
                }
            });

        });
        //editing category
        $(document).on('click', '.edit_category', function(e) {
            $('#edit_category').modal('show');
            var id = $(this).val();

            $.ajax({
                type: "GET",
                url: `{{ route('category.edit', ['category' => ':id']) }}`.replace(':id', id),
                dataType: "json",
                success: function(response) {
                    if (response.status == "200") {
                        $('#edit_name').val(response.category.name)
                        $('#category_id').val(response.category.id)
                    }

                }
            });

        });

        $(document).on('click', '.update_category', function(e) {
            e.preventDefault();
            var id = $('#category_id').val();
            var data = {
                'name': $('#edit_name').val()
            }
            console.log(data);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "PUT",
                url: `{{ route('category.update', ['category' => ':id']) }}`.replace(':id', id),
                data: data,
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    if (response.status == 400) {
                        $('#edit_error_list').html('');
                        $('#edit_error_list').addClass('alert alert-danger');
                        $.each(response.errors, function(key, err_value) {
                            $('#edit_error_list').append('<li>' + err_value +
                                '</li>')
                        });
                    } else {
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
                        $('#edit_category').modal('hide');
                        $('#update_category').find('input').val();
                        fetchCategories();
                    }
                }
            });
        });
        // creating new record
        $(document).on('click', '.create_category', function(e) {
            e.preventDefault();
            var data = {
                'name': $('.name').val()
            };
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('category.store') }}",
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.status == 400) {
                        $('#error_list').html('');
                        $('#error_list').addClass('alert alert-danger');
                        $.each(response.errors, function(key, err_value) {
                            $('#error_list').append('<li>' + err_value + '</li>')
                        });
                    } else {
                        $('#error_list').html('');
                        $('#error_list').removeClass('alert alert-danger');
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
                        $('#createCategoryModal').modal('hide');
                        $('#name').val('');
                        fetchCategories();
                    }

                }
            });
        });
    });
</script>

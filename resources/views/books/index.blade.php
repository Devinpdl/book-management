@extends('layouts.app')

@section('title', 'Book Management')

@section('content')
<div class="row">
    <!-- Left side - Book Entry Form -->
    <div class="col-md-5">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add New Book</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="bookForm">
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" required>
                    </div>
                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" class="form-control" id="author" name="author" placeholder="Enter author" required>
                    </div>
                    <div class="form-group">
                        <label for="isbn">ISBN</label>
                        <input type="text" class="form-control" id="isbn" name="isbn" placeholder="Enter ISBN">
                    </div>
                    <div class="form-group">
                        <label for="publisher">Publisher</label>
                        <input type="text" class="form-control" id="publisher" name="publisher" placeholder="Enter publisher">
                    </div>
                    <div class="form-group">
                        <label for="publication_year">Publication Year</label>
                        <input type="number" class="form-control" id="publication_year" name="publication_year" placeholder="Enter publication year">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="student_id">Student ID</label>
                        <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Enter student ID if borrowed">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="available">Available</option>
                            <option value="borrowed">Borrowed</option>
                        </select>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Right side - Book List -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Book List</h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" id="searchStudentId" class="form-control float-right" placeholder="Search by Student ID">
                        <div class="input-group-append">
                            <button type="button" id="searchBtn" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Student ID</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="booksTableBody">
                        @foreach($books as $book)
                        <tr>
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->student_id ?? 'N/A' }}</td>
                            <td>
                                @if($book->status == 'available')
                                    <span class="badge badge-success">Available</span>
                                @else
                                    <span class="badge badge-warning">Borrowed</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info view-book" data-id="{{ $book->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-primary edit-book" data-id="{{ $book->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger delete-book" data-id="{{ $book->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

<!-- View/Edit Book Modal -->
<div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="bookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookModalLabel">Book Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editBookForm">
                    <input type="hidden" id="edit_book_id" name="book_id">
                    <div class="form-group">
                        <label for="edit_title">Title</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_author">Author</label>
                        <input type="text" class="form-control" id="edit_author" name="author" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_isbn">ISBN</label>
                        <input type="text" class="form-control" id="edit_isbn" name="isbn">
                    </div>
                    <div class="form-group">
                        <label for="edit_publisher">Publisher</label>
                        <input type="text" class="form-control" id="edit_publisher" name="publisher">
                    </div>
                    <div class="form-group">
                        <label for="edit_publication_year">Publication Year</label>
                        <input type="number" class="form-control" id="edit_publication_year" name="publication_year">
                    </div>
                    <div class="form-group">
                        <label for="edit_description">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_student_id">Student ID</label>
                        <input type="text" class="form-control" id="edit_student_id" name="student_id">
                    </div>
                    <div class="form-group">
                        <label for="edit_status">Status</label>
                        <select class="form-control" id="edit_status" name="status">
                            <option value="available">Available</option>
                            <option value="borrowed">Borrowed</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveBookChanges">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Add new book
    $('#bookForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '{{ route("books.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 1500
                    });
                    
                    // Reset form
                    $('#bookForm')[0].reset();
                    
                    // Reload page to update book list
                    location.reload();
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var errorMessage = '';
                
                $.each(errors, function(key, value) {
                    errorMessage += value[0] + '<br>';
                });
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    html: errorMessage
                });
            }
        });
    });
    
    // View book details
    $(document).on('click', '.view-book', function() {
        var bookId = $(this).data('id');
        
        $.ajax({
            url: '/books/' + bookId,
            method: 'GET',
            success: function(book) {
                $('#edit_book_id').val(book.id);
                $('#edit_title').val(book.title);
                $('#edit_author').val(book.author);
                $('#edit_isbn').val(book.isbn);
                $('#edit_publisher').val(book.publisher);
                $('#edit_publication_year').val(book.publication_year);
                $('#edit_description').val(book.description);
                $('#edit_student_id').val(book.student_id);
                $('#edit_status').val(book.status);
                
                // Make fields readonly for view mode
                $('#editBookForm input, #editBookForm textarea, #editBookForm select').prop('readonly', true);
                $('#saveBookChanges').hide();
                
                $('#bookModalLabel').text('View Book Details');
                $('#bookModal').modal('show');
            }
        });
    });
    
    // Edit book
    $(document).on('click', '.edit-book', function() {
        var bookId = $(this).data('id');
        
        $.ajax({
            url: '/books/' + bookId,
            method: 'GET',
            success: function(book) {
                $('#edit_book_id').val(book.id);
                $('#edit_title').val(book.title);
                $('#edit_author').val(book.author);
                $('#edit_isbn').val(book.isbn);
                $('#edit_publisher').val(book.publisher);
                $('#edit_publication_year').val(book.publication_year);
                $('#edit_description').val(book.description);
                $('#edit_student_id').val(book.student_id);
                $('#edit_status').val(book.status);
                
                // Make fields editable for edit mode
                $('#editBookForm input, #editBookForm textarea, #editBookForm select').prop('readonly', false);
                $('#saveBookChanges').show();
                
                $('#bookModalLabel').text('Edit Book');
                $('#bookModal').modal('show');
            }
        });
    });
    
    // Save book changes
    $('#saveBookChanges').on('click', function() {
        var bookId = $('#edit_book_id').val();
        
        $.ajax({
            url: '/books/' + bookId,
            method: 'PUT',
            data: $('#editBookForm').serialize(),
            success: function(response) {
                if(response.success) {
                    $('#bookModal').modal('hide');
                    
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 1500
                    });
                    
                    // Reload page to update book list
                    location.reload();
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var errorMessage = '';
                
                $.each(errors, function(key, value) {
                    errorMessage += value[0] + '<br>';
                });
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    html: errorMessage
                });
            }
        });
    });
    
    // Delete book
    $(document).on('click', '.delete-book', function() {
        var bookId = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/books/' + bookId,
                    method: 'DELETE',
                    success: function(response) {
                        if(response.success) {
                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                timer: 1500
                            });
                            
                            // Reload page to update book list
                            location.reload();
                        }
                    }
                });
            }
        });
    });
    
    // Search books by student ID
    $('#searchBtn').on('click', function() {
        var studentId = $('#searchStudentId').val();
        
        if(studentId) {
            $.ajax({
                url: '{{ route("books.search") }}',
                method: 'GET',
                data: { student_id: studentId },
                success: function(books) {
                    // Clear table body
                    $('#booksTableBody').empty();
                    
                    if(books.length > 0) {
                        // Append books to table
                        $.each(books, function(index, book) {
                            var statusBadge = book.status == 'available' 
                                ? '<span class="badge badge-success">Available</span>' 
                                : '<span class="badge badge-warning">Borrowed</span>';
                                
                            var studentIdText = book.student_id ? book.student_id : 'N/A';
                            
                            var row = '<tr>' +
                                '<td>' + book.id + '</td>' +
                                '<td>' + book.title + '</td>' +
                                '<td>' + book.author + '</td>' +
                                '<td>' + studentIdText + '</td>' +
                                '<td>' + statusBadge + '</td>' +
                                '<td>' +
                                    '<button type="button" class="btn btn-sm btn-info view-book" data-id="' + book.id + '">' +
                                        '<i class="fas fa-eye"></i>' +
                                    '</button> ' +
                                    '<button type="button" class="btn btn-sm btn-primary edit-book" data-id="' + book.id + '">' +
                                        '<i class="fas fa-edit"></i>' +
                                    '</button> ' +
                                    '<button type="button" class="btn btn-sm btn-danger delete-book" data-id="' + book.id + '">' +
                                        '<i class="fas fa-trash"></i>' +
                                    '</button>' +
                                '</td>' +
                            '</tr>';
                            
                            $('#booksTableBody').append(row);
                        });
                    } else {
                        // No books found
                        $('#booksTableBody').append('<tr><td colspan="6" class="text-center">No books found with this student ID</td></tr>');
                    }
                }
            });
        } else {
            // If search field is empty, reload the page to show all books
            location.reload();
        }
    });
});
</script>
@endsection
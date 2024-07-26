@extends('layouts.main')

@section('content')
<div class="w-50 center border px-3 py-3 mx-auto bg-light p-3 ktk mt-5">
    <h1>Edit Event</h1>
    <form action="{{ route('event.update', ['id' => $eventList->id]) }}" method="POST" enctype="multipart/form-data" id="updateEventForm">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name Event</label>
            <input class="form-control form-control-sm" type="text" name="name_event" id="name" value="{{ $eventList->name_event }}">
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input class="form-control form-control-sm" type="text" name="location" id="location" value="{{ $eventList->location }}">
        </div>

        <div class="d-flex mb-3">
            <div class="row form-group">
                <label for="date" class="">Date</label>
                <div class="col-sm-7">
                    <input class="form-control" type="date" name="date" id="date" value="{{ $eventList->date }}">
                </div>
                <div class="col-sm-7">
                    <label for="image" class="form-label mb-3">Upload Logo</label>
                    <input type="file" class="form-control" id="event_image" name="image" accept="image/*">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description Event</label>
            <textarea class="form-control" name="description_event" id="description">{{ $eventList->description_event }}</textarea>
        </div>

        <div class="d-flex justify-content-center gap-2">
            <button class="btn btn-warning" type="submit">Update</button>
            <button class="btn btn-danger" type="button" id="cancelButton">Cancel</button>
        </div>
    </form>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
</div>

<!-- Include SweetAlert2 Library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script to Handle Form Submission -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById('updateEventForm');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(form);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: formData,
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Network response was not ok');
                    });
                }
                return response.json();
            })
            .then(data => {
                Swal.fire({
                    title: 'Success!',
                    text: 'Event has been updated successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/event";
                    }
                });
            })
            .catch(error => {
                console.error('There was an error!', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an error while updating the event.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });

        document.getElementById('cancelButton').addEventListener('click', function() {
            window.location.href = "/event";
        });
    });
</script>
@endsection

@extends('layouts.main')

@section('content')
    <br>
    <br>
    <br>
    <div class="w-50 center border px-3 py-3 mx-auto bg-light p-3 ktk">
        <h1>Create Event</h1>
        <form action="/event" method="POST" id="eventForm" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name Event</label>
                <br>
                <input class="form-control form-control-sm" type="string" name="name_event" id="name" required
                    aria-label=".form-control-sm">
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <br>
                <input class="form-control form-control-sm" type="text" name="location" id="location" required
                    aria-label=".form-control-sm">
            </div>

            <div class="d-flex mb-3">
                <div class="row form-group">
                    <div class="col-sm-3">
                        <label for="date" class="">Date</label>
                    </div>
                <input type="date" name="date" id="date" class="form-control">
                </div>
                <div class="row mb-3 mx-4">
                    <label for="image" class="form-label mb-3">Upload Logo</label>
                    <input type="file" class="form-control" id="event_image" name="image" accept="image/*">
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description Event</label>
                <br>
                <textarea class="form-control" type="text" name="description_event" id="description" required rows="3"></textarea>
            </div>

            <div class="d-flex justify-content-center gap-2">
                <button class="btn btn-success" type="submit">Create</button>
                <a href="/dashboard"> <button class="btn btn-danger">Cancel</button> </a>
            </div>
        </form>
    </div>
 <!-- Include SweetAlert2 Library -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Script to Handle Form Submission -->
        <script>
        // Pastikan ini dijalankan setelah DOM selesai dimuat
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil formulir
            const form = document.getElementById('updateEventForm');

            // Tambahkan event listener untuk pengiriman formulir
            form.addEventListener('submit', function(event) {
                // Hentikan aksi default pengiriman formulir
                event.preventDefault();

                // Kirim data formulir menggunakan fetch atau AJAX
                fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                })
                .then(response => {
                    // Periksa status respons
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    // Jika berhasil, tampilkan SweetAlert
                    return Swal.fire({
                        title: 'Success!',
                        text: 'Event has been updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        // Redirect ke halaman event setelah menekan tombol OK
                        if (result.isConfirmed) {
                            window.location.href = "/event";
                        }
                    });
                })
                .catch(error => {
                    // Tangani kesalahan jika ada
                    console.error('There was an error!', error);
                    // Tampilkan SweetAlert jika terjadi kesalahan
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an error while updating the event.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            });
        });
    </script>   
@endsection

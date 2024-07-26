<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Link -->
    <link rel="stylesheet" href="{{ '../css/dashboard.css' }}">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
</head>

<body>
    @extends('layouts.main')
    @section('content')
        <div class="slide-container">
            <div class="slide-content">
                <br>
                <br>
                <br>

                <!-- Slider -->
                <div class="judul2">
                    <h1><b>Hi, {{ session('account')['name'] }}!</b></h1>
                </div>
                <br>
                <section class="container">
                    <div class="slide-wrapper">
                        <div class="slider">
                            <img id="slide-1" src="img/1.png" alt="" class="card-img">
                            <img id="slide-2" src="img/2.png" alt="" class="card-img">
                            <img id="slide-3" src="img/3.png" alt="" class="card-img">
                        </div>
                        <div class="slider-nav">
                            <a href="#slide-1"></a>
                            <a href="#slide-2"></a>
                            <a href="#slide-3"></a>
                        </div>
                    </div>
                </section>
                <!-- End Slider -->

                <!-- Upcoming -->
                <br>
                <br>
                <div class="heading">
                    <h1><b>Upcoming Event</b></h1>
                </div>
                <!-- End Upcoming -->

                <!-- Card -->
                <br>
                <div class="card-wrapper d-grid grid-template-columns: repeat(3, 1fr) gap-5 flex-wrap: wrap " style="max-height: 100vh">

                    @foreach ($events as $event)
                        <div class="card-container">

                            <div class="image-content">
                                <span class="overlay"> </span>

                                <div class="card-image">
                                    <img src="{{ asset('storage/' . $event->event_image) }}" alt="Event Image" class="card-img">
                                </div>
                            </div>

                            <!-- Card Regist -->
                            <div class="card-content">
                                <h2 class="name_event">
                                    <br>{{ $event->name_event }}
                                </h2>
                            
                                <a href="/event/show/{{ $event->id }}"><button class="button">View More</button></a>
                                <button class="button" data-toggle="modal"
                                    data-target="#modalEventRegist{{ $event->id }}">Volunteer</button>
                                <div class="modal fade" id="modalEventRegist{{ $event->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="modalEventRegistLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalEventRegistLabel">Registration Form</h5>
                                            </div>

                                            <div class="modal-body">
                                                <form name="formEventRegist" id="formEventRegist"
                                                    action="{{ route('regist.event', ['event' => $event->id]) }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf


                                                    <p>
                                                    <div class="form-group row">
                                                        <label for="phone" class="col-sm-4 col-form-label">HP</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="phone"
                                                                name="phone" placeholder="Masukan Nomor Telepon Anda">
                                                        </div>
                                                    </div>

                                                    <p>
                                                    <div class="form-group row">
                                                        <label for="experience"
                                                            class="col-sm-4 col-form-label">Pengalaman</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="experience"
                                                                name="experience" placeholder="Masukkan Pengalaman Anda">
                                                        </div>
                                                    </div>

                                                    <p>
                                                    <div class="modal-footer">
                                                        <button type="button" name="tutup" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                        <button type="submit" name="eventRegist"
                                                            class="btn btn-success">Register</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    @endforeach
                </div>
                  <!-- Include SweetAlert2 Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script to Handle Form Submission -->
<script>
    // Ambil semua formulir event regist
    const eventRegistForms = document.querySelectorAll('form[name="formEventRegist"]');

    // Tambahkan event listener untuk setiap formulir
    eventRegistForms.forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Hentikan aksi default pengiriman formulir

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
                Swal.fire({
                    title: 'Success!',
                    text: 'You have successfully registered for the event.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/dashboard";
                    }
                });
            })
            .catch(error => {
                // Tangani kesalahan jika ada
                console.error('There was an error!', error);
                // Tampilkan SweetAlert jika terjadi kesalahan
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an error while registering for the event.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    });
</script>
    @endsection
</body>

</html>

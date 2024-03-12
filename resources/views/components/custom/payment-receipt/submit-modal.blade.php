@props(['receipt'])

<button type="button" class="btn btn-sm btn-primary temporary-edit mb-2 mt-2" id="submit_button">
    <i data-feather="file-text"></i> Ajukan Verifikasi
</button>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#submit_button').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Konfirmasi",
                icon: "warning",
                text: "Data akan dikirimkan ke Verifikator, apakah anda yakin ?!",
                width: 600,
                confirmButtonText: "Ya, Kirimkan!",
                showCancelButton: true,
                cancelButtonText: "Batalkan!",
                padding: "3em",
                color: "#716add",
                background: "#fff",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Swal.fire({
                    //     title: "Deleted!",
                    //     text: "Your file has been deleted.",
                    //     icon: "success"
                    // });

                    // Swal.fire({
                    //     title: "Are you sure?",
                    //     text: "You won't be able to revert this!",
                    //     icon: "warning",
                    //     showCancelButton: true,
                    //     confirmButtonColor: "#3085d6",
                    //     cancelButtonColor: "#d33",
                    //     confirmButtonText: "Yes, delete it!"
                    // }).then((result) => {
                    //     if (result.isConfirmed) {
                    //         Swal.fire({
                    //             title: "Deleted!",
                    //             text: "Your file has been deleted.",
                    //             icon: "success"
                    //         });
                    //     }
                    // });
                    var swalLoading = Swal.fire({
                        title: 'Loading...',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    $.ajax({
                        url: '{{ route('payment-receipt.submit', $receipt) }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Pengajuan berhasil',
                                icon: 'success',
                                confirmButtonText: 'OK',
                            }).then((result) => {
                                location.reload();
                                window.location.href = window.location
                                    .href + '#document';
                            });
                        },
                        error: function(response, status, error) {

                            console.log(response.responseJSON.message);
                            Swal.fire({
                                title: 'Error!',
                                text: response.responseJSON.message,
                                icon: 'error',
                                confirmButtonText: 'OK',
                            });
                        },
                        complete: function() {
                            swalLoading.close();
                        }
                    });
                }
                return;
            });
        });
    });
</script>

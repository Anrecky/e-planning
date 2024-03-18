@props(['receipt'])

<button type="button" class="btn btn-sm btn-success temporary-edit mb-2 mt-2 approval_btn_ppk" data-res="Y">
    <i data-feather="file-text"></i> Terima
</button>

<button type="button" class="btn btn-sm btn-danger temporary-edit mb-2 mt-2 approval_btn_ppk" data-res="N">
    <i data-feather="file-text"></i> Tolak
</button>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('.approval_btn_ppk').on('click', function(e) {
            e.preventDefault();
            var res = $(this).data('res');
            if (res == 'Y') {
                text = "Yakin akan melalukan Approv data ini?"
            } else if (res == 'N') {
                text = "Yakin akan melalukan Menolak data ini? masukkan alasan penolakan"
            }
            Swal.fire({
                title: "Konfirmasi",
                icon: "warning",
                text: text,
                width: 600,
                confirmButtonText: "Ya!",
                showCancelButton: true,
                cancelButtonText: "Batalkan!",
                padding: "3em",
                color: "#716add",
                background: "#fff",
                input: (res == 'N') ? "textarea" : false,
                inputLabel: (res == 'N') ? "Masukkan alasan penolakan" : false,
            }).then((result) => {
                if (result.isConfirmed) {
                    var swalLoading = Swal.fire({
                        title: 'Loading...',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    $.ajax({
                        url: '{{ route('receipt-action.spi', $receipt) }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            res: res,
                            description: ((res == 'N') ? result.value : '')
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                // text: 'berhasil',
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

@props(['receipt'])

<button type="button" class="btn btn-sm btn-primary  mb-2 mt-2" data-bs-target="#uploadModal" data-bs-toggle="modal">
    <i data-feather="upload"></i> Form Status Aplikasi Keuangan
</button>

<div class="modal fade c-modal-bg" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalTitle"
    aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalTitle">Status Aplikasi Keuangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form-money-app" action="{{ route('receipt-action.change-status-money-app', $receipt) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <input name="receipt" value="{{ $receipt->id }}" type="hidden">
                    <div class="mb-4 row">
                        <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">Pilih File</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="status_money_app" id="status_money_app">
                                <option value="N">Belum Entri</option>
                                <option value="Y">Sudah Entri</option>
                            </select>
                        </div>
                    </div>
                    <button id="submitFormupload" class="btn btn-warning text-center align-items-center mt-2 py-auto"
                        type="submit">
                        <span class="icon-name">Simpan</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#form-money-app').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var url = $(this).attr('action');

            var swalLoading = Swal.fire({
                title: 'Loading...',
                showConfirmButton: false,
                allowOutsideClick: false,
                showCancelButton: true,
                // cancelButtonText: 'Batal Unggah',
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: url,
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    Swal.fire({
                        title: 'Success',
                        text: 'successfully',
                        icon: 'success',
                        confirmButtonText: 'OK',
                    }).then((result) => {
                        location.reload();
                        window.location.href = window.location.href + '#document';
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

        });
    });
</script>

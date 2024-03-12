@props(['receipt'])

<button type="button" class="btn btn-sm btn-primary temporary-edit mb-2 mt-2" data-bs-target="#uploadModal"
    data-bs-toggle="modal" data-update-url="{{ route('payment-receipt.upload', $receipt) }}">
    <i data-feather="upload"></i> Upload Berkas / Ganti Berkas
</button>

<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalTitle" aria-hidden="true"
    data-bs-focus="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalTitle">Upload Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form-upload" action="{{ route('payment-receipt.upload', $receipt) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <input name="receipt" value="{{ $receipt->id }}" type="hidden">
                    <div class="mb-4 row">
                        <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">Pilih File</label>
                        <div class="col-sm-8">
                            <input accept=".pdf" class="form-control" type="file" name="file_upload"
                                id="file_upload"></input>
                            <span class="text-danger">*max 20Mb</span>
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
        $('#form-upload').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            var url = $(this).attr('action');

            // Tampilkan loading modal sebelum proses pengiriman dimulai
            var swalLoading = Swal.fire({
                title: 'Loading...',
                html: 'Upload Progress: <b></b>%',
                showConfirmButton: false,
                allowOutsideClick: false,
                showCancelButton: true,
                cancelButtonText: 'Batal Unggah',
                willOpen: () => {
                    // Swal.showLoading();
                }
            });

            var xhr = new XMLHttpRequest();

            xhr.upload.addEventListener('progress', function(event) {
                if (event.lengthComputable) {
                    var percent = (event.loaded / event.total) * 100;
                    // Perbarui teks pada SweetAlert dengan persentase yang sesuai
                    // Swal.getHtmlContainer().textContent =
                    //     'Upload Progress: ' + percent.toFixed(2) + '%';
                    const b = Swal.getHtmlContainer().querySelector('b')
                    // timerInterval = setInterval(() => {
                    b.textContent = percent.toFixed(2)
                    // }, 100)
                }
            });

            xhr.addEventListener('load', function(event) {
                if (xhr.status === 200) {
                    Swal.fire({
                        title: 'Success',
                        text: 'File uploaded successfully',
                        icon: 'success',
                        confirmButtonText: 'OK',
                    }).then((result) => {
                        location
                            .reload();
                        window.location.href = window.location.href +
                            '#document';
                    });
                } else {
                    var errorResponse = JSON.parse(xhr.responseText);
                    Swal.fire({
                        title: 'Error!',
                        text: errorResponse.message,
                        icon: 'error',
                        confirmButtonText: 'OK',
                    });
                }
            });

            xhr.addEventListener('error', function(event) {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while uploading the file',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });
            });

            xhr.open('POST', url);
            swalLoading.then((result) => {
                if (result.dismiss === Swal.DismissReason.cancel) {
                    xhr.abort(); // Batalkan pengiriman Ajax jika tombol "Batal Unggah" diklik
                }
            });
            xhr.send(formData);

        });
    });
</script>

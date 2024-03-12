@props(['receipt'])

<button type="button" class="btn btn-sm btn-primary temporary-edit mb-2 mt-2" data-bs-target="#verificationModal"
    data-bs-toggle="modal" data-update-url="{{ route('payment-receipt.verification', $receipt) }}">
    <i data-feather="file-text"></i> Form Verifikasi
</button>

<div class="modal fade" id="verificationModal" tabindex="-1" role="dialog" aria-labelledby="verificationModalTitle"
    aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verificationModalTitle">Verification Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form-verification" action="{{ route('payment-receipt.verification', $receipt) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <input name="receipt" value="{{ $receipt->id }}" type="hidden">
                    <div class="col-lg-12">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-4 row">
                                    <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">Tanggal
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="date" name="verification_date"
                                            id="verification_date"></input>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-4 row">
                                    <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">Hasil
                                    </label>
                                    <div class="col-sm-8 mt-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="verification_result"
                                                id="verification_result1" value="Y">
                                            <label class="form-check-label" for="verification_result1">Lengkap</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="verification_result"
                                                id="verification_result2" value="N">
                                            <label class="form-check-label" for="verification_result2">Tidak
                                                Lengkap</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-4 row">
                                    <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">Keterangan
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" type="date" name="verification_description" id="verification_description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-4 row">
                                    <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">File Form
                                        Verifikasi
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="file" accept=".pdf"
                                            name="verification_file_upload" id="verification_file_upload"></input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-lg-12 ">
                        <h6>2. BUKTI KELENGKAPAN BERKAS PENCAIRAN MELALUI GUP BENDAHARA / LS PIHAK KE TIGA</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="item_2_a">
                                    <label class="form-check-label" for="item_2_a">
                                        a. SPBy/Kwitansi LS
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="item_2_b">
                                    <label class="form-check-label" for="item_2_b">
                                        b. NOTA / INVOICE
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="item_2_c">
                                    <label class="form-check-label" for="item_2_c">
                                        c. NMR, TGL, TANDATANGAN DAN CAP PADA DOKUMEN
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="item_2_d">
                                    <label class="form-check-label" for="item_2_d">
                                        d. FOTOCOPY NPWP (SUPLIER BARU)
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="item_2_e">
                                    <label class="form-check-label" for="item_2_e">
                                        e. FOTOCOPY BUKU REKENING (SUPLIER BARU)
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="item_2_f">
                                    <label class="form-check-label" for="item_2_f">
                                        f. DOKUMENTASI
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h6>3. BUKTI KELENGKAPAN BERKAS PENCAIRAN HONORARIUM</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="item_3_a">
                                    <label class="form-check-label" for="item_3_a">
                                        a. DAFTAR HONOR
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="item_3_b">
                                    <label class="form-check-label" for="item_3_b">
                                        b. SK
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="item_3_c">
                                    <label class="form-check-label" for="item_3_c">
                                        c. RUNDOWN ACARA (PENCAIRAN HONOR NARASUMBER)
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="item_3_d">
                                    <label class="form-check-label" for="item_3_d">
                                        d. SURAT TUGAS NARASUMBER
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="item_3_e">
                                    <label class="form-check-label" for="item_3_e">
                                        e. DOKUMENTASI
                                    </label>
                                </div>
                            </div>

                        </div>

                        <h6>4. BUKTI KELENGKAPAN BERKAS PENCAIRAN PERJALANAN DINAS</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="item_4_a">
                                    <label class="form-check-label" for="item_3_a">
                                        a. SURAT TUGAS
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="item_3_b">
                                    <label class="form-check-label" for="item_3_b">
                                        b. SPD
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="item_3_c">
                                    <label class="form-check-label" for="item_3_c">
                                        c. KUITANSI LS
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="item_3_d">
                                    <label class="form-check-label" for="item_3_d">
                                        d. DAFTAR RAMPUNG
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="item_3_e">
                                    <label class="form-check-label" for="item_3_e">
                                        e. INVOICE HOTEL
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="item_3_f">
                                    <label class="form-check-label" for="item_3_f">
                                        f. TIKET PP
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="item_3_g">
                                    <label class="form-check-label" for="item_3_g">
                                        g. DAFTAR RILL
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="item_3_h">
                                    <label class="form-check-label" for="item_3_h">
                                        h. UNDANGAN / MEMO
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="item_3_i">
                                    <label class="form-check-label" for="item_3_i">
                                        i. LAPORAN PERJALANAN DINAS
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="item_3_j">
                                    <label class="form-check-label" for="item_3_j">
                                        j. DOKUMENTASI
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <button id="submitFormverification"
                        class="btn btn-warning text-center align-items-center mt-2 py-auto" type="submit">
                        <span class="icon-name">Simpan</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#form-verification').submit(function(e) {
            e.preventDefault();

            // var formData = $(this).serialize();
            var formData = new FormData(this);

            var url = $(this).attr('action');

            // Tampilkan loading modal sebelum proses pengiriman dimulai
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
                        text: 'verificationed successfully',
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

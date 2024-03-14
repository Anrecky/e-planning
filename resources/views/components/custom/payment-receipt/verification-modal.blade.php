@props(['receipt'])
@props(['dataVerif'])
@php
    if (!empty($dataVerif->items)) {
        $items = json_decode($dataVerif->items);
    }
@endphp
<button type="button" class="btn btn-sm btn-primary temporary-edit mb-2 mt-2"
    data-bs-target="#verificationModal{{ $dataVerif->id ?? '' }}" data-bs-toggle="modal"
    data-update-url="{{ route('payment-receipt.verification', $receipt) }}">
    <i data-feather="file-text"></i> Form Verifikasi
</button>

<div class="modal fade" id="verificationModal{{ $dataVerif->id ?? '' }}" tabindex="-1" role="dialog"
    aria-labelledby="verificationModalTitle" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verificationModalTitle">Verification Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x-square"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-verification-{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}"
                    action="{{ route('payment-receipt.verification', $receipt) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <input name="receipt" value="{{ $receipt->id }}" type="hidden">
                    <input name="idVerification" value="{{ $dataVerif->id ?? '' }}" type="hidden">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-4 row">
                                            <label for="inputDisbursementDescription"
                                                class="col-sm-2 col-form-label">Tanggal
                                            </label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="date" name="verification_date"
                                                    {{ Auth::user()->hasRole('SUPER ADMIN PERENCANAN') ? '' : 'readonly' }}
                                                    value="{{ Auth::user()->hasRole('SUPER ADMIN PERENCANAN') ? $receipt->date ?? date('Y-m-d') : date('Y-m-d') }}"
                                                    id="verification_date"></input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-4 row">
                                            <label for="inputDisbursementDescription"
                                                class="col-sm-2 col-form-label">Hasil
                                            </label>
                                            <div class="col-sm-8 mt-2">
                                                <div class="form-check form-check-inline">
                                                    <input class="" type="radio" name="verification_result"
                                                        id="{{ $dataVerif->id ?? '' }}verification_result1"
                                                        value="Y"
                                                        {{ ($dataVerif->result ?? false) == 'Y' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="{{ $dataVerif->id ?? '' }}verification_result1">Lengkap</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="" type="radio" name="verification_result"
                                                        id="{{ $dataVerif->id ?? '' }}verification_result2"
                                                        value="N"
                                                        {{ ($dataVerif->result ?? false) == 'N' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="{{ $dataVerif->id ?? '' }}verification_result2">Tidak
                                                        Lengkap</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-4 row">
                                            <label for="inputDisbursementDescription"
                                                class="col-sm-2 col-form-label">Keterangan
                                            </label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" type="date" name="verification_description" id="verification_description">{{ $dataVerif->description ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-12">
                                            <div class="mb-4 row">
                                                <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">File Form
                                                    Verifikasi
                                                </label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="file" accept=".pdf"
                                                        name="verification_file_upload" id="verification_file_upload"></input>
                                                </div>
                                            </div>
                                        </div> --}}
                                    <div class="col-lg-12 checklist">
                                        <hr>
                                        <h6>2. Bukti Kelengkapan Berkas Pencairan
                                        </h6>
                                        <div class="row checklist">
                                            <div class="input-group mb-3">
                                                <div class="input-group-text ">
                                                    <input class="s cl-box" type="checkbox" value="Y"
                                                        id="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_2_a"
                                                        name="item_2_a"
                                                        {{ !empty($items->item_2_a) ? 'checked' : '' }}>
                                                </div>
                                                <label class="form-control mb-0"
                                                    for="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_2_a">
                                                    a. SPBy/Kuitansi LS
                                                </label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text ">
                                                    <input class=" cl-box" type="checkbox" value="Y"
                                                        id="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_2_b"
                                                        name="item_2_b"
                                                        {{ !empty($items->item_2_b) ? 'checked' : '' }}>
                                                </div>
                                                <label class="form-control mb-0"
                                                    for="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_2_b">
                                                    b. Nota / Invoice dengan Nomor, Tanggal, Tanda Tangan dan Cap
                                                </label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text ">
                                                    <input class=" cl-box" type="checkbox" value="Y"
                                                        id="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_2_c"
                                                        name="item_2_c"
                                                        {{ !empty($items->item_2_c) ? 'checked' : '' }}>
                                                </div>
                                                <label class="form-control mb-0"
                                                    for="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_2_c">
                                                    c. Fotocopy NPWP (Suplier Baru) </label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text ">
                                                    <input class=" cl-box" type="checkbox" value="Y"
                                                        id="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_2_d"
                                                        name="item_2_d"
                                                        {{ !empty($items->item_2_d) ? 'checked' : '' }}>
                                                </div>
                                                <label class="form-control mb-0"
                                                    for="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_2_d">
                                                    d. Fotocopy Buku Rekening (Suplier Baru)
                                                </label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text ">
                                                    <input class=" cl-box" type="checkbox" value="Y"
                                                        id="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_2_e"
                                                        name="item_2_e"
                                                        {{ !empty($items->item_2_e) ? 'checked' : '' }}>
                                                </div>
                                                <label class="form-control mb-0"
                                                    for="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_2_e">
                                                    e. Dokumentasi
                                                </label>
                                            </div>
                                        </div>
                                        <hr>
                                        <h6>3. Bukti Kelengkapan Berkas Pencairan Honorarium</h6>
                                        <div class="row">
                                            <div class="input-group mb-3">
                                                <div class="input-group-text ">
                                                    <input class=" cl-box" type="checkbox" value="Y"
                                                        id="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_3_a"
                                                        name="item_3_a"
                                                        {{ !empty($items->item_3_a) ? 'checked' : '' }}>
                                                </div>
                                                <label class="form-control mb-0"
                                                    for="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_3_a">
                                                    a. Daftar Honor
                                                </label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text ">
                                                    <input class=" cl-box" type="checkbox" value="Y"
                                                        id="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_3_b"
                                                        name="item_3_b"
                                                        {{ !empty($items->item_3_b) ? 'checked' : '' }}>
                                                </div>
                                                <label class="form-control mb-0"
                                                    for="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_3_b">
                                                    b. SK
                                                </label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text ">
                                                    <input class=" cl-box" type="checkbox" value="Y"
                                                        id="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_3_c"
                                                        name="item_3_c"
                                                        {{ !empty($items->item_3_c) ? 'checked' : '' }}>
                                                </div>
                                                <label class="form-control mb-0"
                                                    for="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_3_c">
                                                    c. Rundown Acara (Pencairan Honorarium Narasumber)

                                                </label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text ">
                                                    <input class=" cl-box" type="checkbox" value="Y"
                                                        id="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_3_d"
                                                        name="item_3_d"
                                                        {{ !empty($items->item_3_d) ? 'checked' : '' }}>
                                                </div>
                                                <label class="form-control mb-0"
                                                    for="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_3_d">
                                                    d. Surat Tugas Narasumber
                                                </label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text ">
                                                    <input class=" cl-box" type="checkbox" value="Y"
                                                        id="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_3_e"
                                                        name="item_3_e"
                                                        {{ !empty($items->item_3_e) ? 'checked' : '' }}>
                                                </div>
                                                <label class="form-control mb-0"
                                                    for="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_3_e">
                                                    e. Dokumentasi

                                                </label>
                                            </div>
                                        </div>

                                        <h6>4. BUKTI KELENGKAPAN BERKAS PENCAIRAN PERJALANAN DINAS</h6>
                                        <div class="row">
                                            <div class="input-group mb-3">
                                                <div class="input-group-text ">
                                                    <input class=" cl-box" type="checkbox" value="Y"
                                                        id="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_4_a"
                                                        name="item_4_a"
                                                        {{ !empty($items->item_4_a) ? 'checked' : '' }}>
                                                </div>
                                                <label class="form-control mb-0"
                                                    for="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_4_a">
                                                    a. Surat Tugas
                                                </label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text ">
                                                    <input class=" cl-box" type="checkbox" value="Y"
                                                        id="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_4_b"
                                                        name="item_4_b"
                                                        {{ !empty($items->item_4_b) ? 'checked' : '' }}>
                                                </div>
                                                <label class="form-control mb-0"
                                                    for="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_4_b">
                                                    b. SPD
                                                </label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text ">
                                                    <input class=" cl-box" type="checkbox" value="Y"
                                                        id="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_4_c"
                                                        name="item_4_c"
                                                        {{ !empty($items->item_4_c) ? 'checked' : '' }}>
                                                </div>
                                                <label class="form-control mb-0"
                                                    for="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_4_c">
                                                    c. Kuitansi LS
                                                </label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text ">
                                                    <input class=" cl-box" type="checkbox" value="Y"
                                                        id="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_4_d"
                                                        name="item_4_d"
                                                        {{ !empty($items->item_4_d) ? 'checked' : '' }}>
                                                </div>
                                                <label class="form-control mb-0"
                                                    for="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_4_d">
                                                    d. Daftar Rampung

                                                </label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text ">
                                                    <input class=" cl-box" type="checkbox" value="Y"
                                                        id="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_4_e"
                                                        name="item_4_e"
                                                        {{ !empty($items->item_4_e) ? 'checked' : '' }}>
                                                </div>
                                                <label class="form-control mb-0"
                                                    for="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_4_e">
                                                    e. Invoice Hotel


                                                </label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text ">
                                                    <input class=" cl-box" type="checkbox" value="Y"
                                                        id="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_4_f"
                                                        name="item_4_f"
                                                        {{ !empty($items->item_4_f) ? 'checked' : '' }}>
                                                </div>
                                                <label class="form-control mb-0"
                                                    for="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_4_f">
                                                    f. Tiket PP

                                                </label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text ">
                                                    <input class=" cl-box" type="checkbox" value="Y"
                                                        id="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_4_g"
                                                        name="item_4_g"
                                                        {{ !empty($items->item_4_g) ? 'checked' : '' }}>
                                                </div>
                                                <label class="form-control mb-0"
                                                    for="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_4_g">
                                                    g. Daftar Rill

                                                </label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text ">
                                                    <input class=" cl-box" type="checkbox" value="Y"
                                                        id="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_4_h"
                                                        name="item_4_h"
                                                        {{ !empty($items->item_4_h) ? 'checked' : '' }}>
                                                </div>
                                                <label class="form-control mb-0"
                                                    for="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_4_h">
                                                    h. Undangan / Memo

                                                </label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text ">
                                                    <input class=" cl-box" type="checkbox" value="Y"
                                                        id="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_4_i"
                                                        name="item_4_i"
                                                        {{ !empty($items->item_4_i) ? 'checked' : '' }}>
                                                </div>
                                                <label class="form-control mb-0"
                                                    for="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_4_i">
                                                    i. Laporan Perjalanan Dinas

                                                </label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-text ">
                                                    <input class=" cl-box" type="checkbox" value="Y"
                                                        id="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_4_j"
                                                        name="item_4_j"
                                                        {{ !empty($items->item_4_j) ? 'checked' : '' }}>
                                                </div>
                                                <label class="form-control mb-0"
                                                    for="{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}-item_4_j">
                                                    j. Dokumentasi

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <embed type="application/pdf"
                                    src="{{ url('storage/berkas_receipt/' . $receipt->berkas) }}" width="100%"
                                    height="100%"></embed>
                            </div>
                        </div>
                    </div>


                    <button id="submitFormverification" class="btn btn-warning text-center" type="submit">
                        <span class="icon-name"> <i data-feather="save"></i> Simpan</span>
                    </button>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i> Batal
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#form-verification-{{ $receipt->id }}-{{ $dataVerif->id ?? '' }}').submit(function(e) {
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

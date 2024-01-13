<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalTitle">Edit Data Penerimaan</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Tutup"><i
                        data-feather="x-circle" class="feather-24"></i></button>
            </div>
            <div class="modal-body">
                <form id="form-edit" action="" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3 row">
                        <label for="accountCode" class="col-sm-3 col-form-label">Kode Akun</label>
                        <div class="col-sm-7">
                            <select name="accountCode" id="editSelectAccountCode" class="form-control"></select>
                        </div>
                    </div>
                    <div class="mb row">
                        <label for="description" class="col-sm-3 col-form-label">Uraian</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="description" id="description" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="mb-3 row align-items-center">
                        <p class="col-sm-3 col-form-label text-dark">Jenis</p>
                        <div class="col-sm-7">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" checked name="type[]"
                                    id="umum-checkbox" value="umum">
                                <label class="form-check-label mb-0" for="umum-checkbox">Umum</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="type[]" id="fungsional-checkbox"
                                    value="fungsional">
                                <label class="form-check-label mb-0" for="fungsional-checkbox">Fungsional</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="type[]" id="pajak-checkbox"
                                    value="pajak">
                                <label class="form-check-label mb-0" for="pajak-checkbox">Pajak</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="target" class="col-sm-3 col-form-label">Target Pendapatan</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="editTarget" name="target">
                        </div>
                    </div>
                    <button class="btn btn-primary text-center align-items-center mt-1 mt-2 py-auto" type="submit">
                        <span class="icon-name">Simpan</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

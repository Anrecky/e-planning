<div class="modal fade c-modal-bg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
    aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalTitle">Edit Data Kuitansi Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form-edit" action="" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4 row">
                        <label for="selectTypeReceipt" class="col-sm-2 col-form-label">Jenis Kuitansi</label>
                        <div class="col-sm-8">
                            <select name="type" class="form-select" id="selectTypeReceipt">
                                <option selected disabled value="">Pilih Jenis Kuitansi...</option>
                                <option value="direct">Pembayaran Langsung</option>
                                <option value="treasurer">Pembayaran Langsung (Bendahara)</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="selectPerjadinReceipt" class="col-sm-2 col-form-label">Perjalanan Dinas</label>
                        <div class="col-sm-8">
                            <select name="perjadin" class="form-select" id="selectPerjadinReceipt">
                                <option selected disabled value="">Pilih ...</option>
                                <option value="Y">Perjalanan Dinas</option>
                                <option value="N">Non Perjalanan Dinas</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">Uraian
                            Pencairan</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="description"
                                id="inputDisbursementDescription">
                        </div>
                    </div>
                    <div class="mb-4 row pelaksanaWrapper ">
                        <label for="selectActivityExecutor" class="col-sm-2 col-form-label">Pelaksana Kegiatan</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="activity_implementer" id="editSelectPelaksana">
                                <option selected disabled value="">Pilih Pelaksana...</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="inputActivityDate" class="col-sm-2 col-form-label">Tanggal Kegiatan</label>
                        <div class="col-sm-8 flatpickr">
                            <input id="basicFlatpickr" name="activity_date"
                                class="form-control flatpickr flatpickr-input active text-dark" type="text"
                                placeholder="Pilih tanggal..">
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="inputAmount" class="col-sm-2 col-form-label">Jumlah</label>
                        <div class="col-sm-8">
                            <input type="text" name="amount" class="form-control mask-number" id="inputAmount">
                        </div>
                    </div>
                    <div class="mb-4 row treasurerWrapper ">
                        <label for="selectActivityExecutor" class="col-sm-2 col-form-label">Bendahara</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="treasurer" id="editSelectTreasurer">
                                <option selected disabled value="">Pilih Bendahara...</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4 row ppkWrapper">
                        <label for="selectVerifier" class="col-sm-2 col-form-label">PPK</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="ppk" id="editSelectPPK">
                                <option selected disabled value="">Pilih PPK...</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="inputSupplierName" class="col-sm-2 col-form-label">Penyedia PIC</label>
                        <div class="col-sm-8">
                            <input type="text" name="provider" class="form-control" id="inputSupplierName">
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="inputSupplierOrganizationName" class="col-sm-2 col-form-label">Penyedia
                            Badan</label>
                        <div class="col-sm-8">
                            <input type="text" name="provider_organization" class="form-control"
                                id="inputSupplierOrganizationName">
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="selectApprove" class="col-sm-2 col-form-label">Detail COA</label>
                        <div class="col-sm-8">
                            <input hidden type="number" class="form-control" name="detail" id="selectApproveId">
                            <input readonly disabled type="text" class="form-control" id="selectApproveName">
                        </div>
                        <div class="col-sm-2">
                            <button id="editCOABtn" type="button" data-bs-target="#COAModal" data-bs-toggle="modal"
                                class="btn btn-primary btn-lg">...</button>
                        </div>
                    </div>
                    <button id="submitFormedit" class="btn btn-warning text-center align-items-center mt-2 py-auto"
                        type="submit">
                        <span class="icon-name">Edit</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

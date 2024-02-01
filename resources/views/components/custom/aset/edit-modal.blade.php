<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalTitle">Edit Aset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18">
                        </line>
                        <line x1="6" y1="6" x2="18" y2="18">
                        </line>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-edit" action="" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4 row">
                        <label for="inputCategory" class="col-sm-2 col-form-label">Kategori</label>
                        <div class="col-sm-8">
                            <div class="form-check form-check-inline">
                                <input checked class="form-check-input" type="radio" name="asset_item_category"
                                    id="asset_item_category_1" value="IT">
                                <label class="form-check-label" for="asset_item_category_1">IT</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="asset_item_category"
                                    id="asset_item_category_2" value="NonIT">
                                <label class="form-check-label" for="asset_item_category_2">Non IT</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="selectAssetItem" class="col-sm-2 col-form-label">Barang Aset</label>
                        <div class="col-sm-8">
                            <select required class="form-select" aria-label="Pilih Barang Aset" name="asset_item"
                                id="selectAssetItem">
                                <option selected value="">Pilih Barang Aset</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="inputBrand" class="col-sm-2 col-form-label">Merek</label>
                        <div class="col-sm-8">
                            <input name="brand" type="text" class="form-control" id="inputBrand">
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="selectAcquisitionYear" class="col-sm-2 col-form-label">Tahun Perolehan</label>
                        <div class="col-sm-8">
                            <select required name="year_acquisition" class="form-select" id="selectAcquisitionYear">
                                <option selected disabled value="">Pilih Tahun...</option>
                                @for ($year = 2000; $year <= 2035; $year++)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="inputCodeAssets" class="col-sm-2 col-form-label">Kode Aset</label>
                        <div class="col-sm-8">
                            <input required name="code" type="text" class="form-control" id="inputCodeAssets">
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="inputCondition" class="col-sm-2 col-form-label">Kondisi</label>
                        <div class="col-sm-8">
                            <div class="form-check form-check-inline">
                                <input checked class="form-check-input" type="radio" name="condition"
                                    id="asset_condition_1" value="good">
                                <label class="form-check-label" for="asset_condition_1">Baik</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="condition"
                                    id="asset_condition_2" value="slightly">
                                <label class="form-check-label" for="asset_condition_2">Rusak Ringan</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="condition"
                                    id="asset_condition_3" value="heavy">
                                <label class="form-check-label" for="asset_condition_3">Rusak Berat</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="enable-textarea-checkbox" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-1 col-form-label">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0 description-checkbox" type="checkbox"
                                    value="" aria-label="Enable textarea checkbox">
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="form-floating">
                                <textarea readonly class="form-control" name="description" placeholder="Isikan keterangan disini" id="description"
                                    style="height: 20vh"></textarea>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-warning mt-1 mt-2 py-auto" type="submit">
                        <span class="icon-name">Update</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

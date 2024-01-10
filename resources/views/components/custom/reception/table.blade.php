<div class="table-responsive my-4">
    <div class="d-flex flex-wrap justify-content-between py-2 my-2 me-1">
        <div class="d-flex flex-wrap gap-1 my-2">
            <button id="add-activity_btn" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                data-bs-target="#createModal">Rekam Data Penerimaan</button>
            <button id="add-account_code_btn" data-bs-toggle="modal" data-bs-target="#createModal"
                class="btn btn-primary shadow-sm">Rekam Akun</button>
            <button id="add-expenditure_detail_btn" data-bs-toggle="modal" data-bs-target="#createModal"
                class="btn btn-primary shadow-sm">Rekam
                Detail</button>
        </div>
        <div class="d-flex flex-wrap gap-2 my-2">
            <button id="save-dipa" class="btn btn-outline-success shadow-sm bs-tooltip">Simpan</button>
            <button id="edit-dipa" class="btn btn-outline-warning shadow-sm bs-tooltip">Ubah</button>
            <button id="delete-dipa" class="btn btn-outline-danger shadow-sm bs-tooltip">Hapus</button>
        </div>
    </div>
    <table id="reception-table" class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th scope="col">KD Akun</th>
                <th scope="col">Uraian</th>
                <th scope="col">Perpajakan</th>
                <th scope="col">Umum</th>
                <th scope="col">Fungsional</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>

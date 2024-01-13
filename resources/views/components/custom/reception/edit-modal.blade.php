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
                <form id="form-edit" action="{{ route('budget_implementation.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div id="edit-input_container" class="input-group my-2">
                    </div>
                    <button class="btn btn-primary text-center align-items-center mt-1 mt-2 py-auto" type="submit">
                        <span class="icon-name">Simpan</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

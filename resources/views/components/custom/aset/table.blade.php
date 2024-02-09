<div class="table-responsive px-4 my-4">
    <div class="d-flex flex-wrap justify-content-sm-between justify-content-center my-2 me-1 align-items-center">
        <div class="d-flex flex-wrap gap-1 my-2">
            <button id="addBtn" class="btn btn-primary shadow-sm">Rekam Data Aset
            </button>
        </div>
        {{-- <div class="d-flex flex-wrap gap-2 my-2">
            <button id="save-dipa" class="btn btn-outline-success shadow-sm bs-tooltip">Simpan</button>
            <button id="edit-dipa" class="btn btn-outline-warning shadow-sm bs-tooltip">Ubah</button>
            <button id="delete-dipa" class="btn btn-outline-danger shadow-sm bs-tooltip">Hapus</button>
        </div> --}}
    </div>
    <table id="assets-table" class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th scope="col">Kategori</th>
                <th scope="col">Jenis</th>
                <th scope="col">Merek</th>
                <th scope="col">Tahun Perolehan</th>
                <th scope="col">Kode Aset</th>
                <th scope="col">Kondisi</th>
                <th scope="col">Keterangan</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assets as $asset)
            <tr>
                <td>{{ $asset->assetItem->category === 'IT' ? 'IT' : 'Non IT' }}</td>
                <td>{{ $asset->assetItem->name }}</td>
                <td>{{ $asset->brand }}</td>
                <td>{{ $asset->year_acquisition }}</td>
                <td>{{ $asset->code }}</td>
                <td>{{ __(ucfirst($asset->condition)) }}</td>
                <td class="text-wrap">{{ \Str::limit($asset->description, 90) }}</td>
                <td class="text-center ">
                    <button type="button" class="btn btn-sm btn-primary editBtn" data-id="{{ $asset->id }}">
                        <i class="text-white" data-feather="edit-2"></i>
                    </button>

                    <a href="javascript:void(0);" class="btn btn-danger btn-sm" role="button" onclick="confirmDelete({{ $asset->id }});">
                        <i class="text-white" data-feather="trash-2"></i>
                    </a>
                    <!-- Hidden form for delete request -->
                    <form id="delete-form-{{ $asset->id }}" action="{{ route('asset.destroy', $asset->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
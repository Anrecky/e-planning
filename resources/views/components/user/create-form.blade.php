<form id="form-create" action="{{ route('user.store') }}" method="POST" novalidate>
    @csrf
    <div class="mb-4 row align-items-center">
        <label for="selectTypeRole" class="col-sm-3 col-form-label">Pilih Role</label>
        <div class="col-sm-8">
            <select class="form-select @error('user_role') is-invalid @enderror" id="selectTypeRole" name="user_role"
                required>
                <option selected disabled value="">Pilih Jenis Role...</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}" {{ old('user_role') == $role->name ? 'selected' : '' }}>
                        {{ $role->name }}</option>
                @endforeach
            </select>
            @error('user_role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="mb-4 row align-items-center staffWrapper">
        <label for="selectVerifier" class="col-sm-3 col-form-label">Atasan (opsional)</label>
        <div class="col-sm-8">
            <select class="form-select" style=" width: 100% !important" name="head_id" id="createSelectStaff">
                <option selected disabled value="">Pilih Staff...</option>
            </select>
        </div>
    </div>
    <div class="mb-4 row align-items-center">
        <label for="letter_reference" class="col-sm-3 col-form-labe">Referensi Nomor Surat</label>
        <div class="col-sm-8">
            <input type="text" class="form-control @error('letter_reference') is-invalid @enderror"
                id="letter_reference" name="letter_reference" value="{{ old('letter_reference') }}">
            @error('letter_reference')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="mb-4 row align-items-center">
        <label for="inputFullName" class="col-sm-3 col-form-label">Nama Lengkap</label>
        <div class="col-sm-8">
            <input type="text" class="form-control @error('user_name') is-invalid @enderror" id="inputFullName"
                name="user_name" value="{{ old('user_name') }}" required>
            @error('user_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <!-- Employee Section -->
    <div class="mb-4 row align-items-center">
        <label for="inputPosition" class="col-sm-3 col-form-label">Jabatan</label>
        <div class="col-sm-8">
            <input type="text" class="form-control @error('position') is-invalid @enderror" id="inputPosition"
                name="position" value="{{ old('position') }}" required>
            @error('position')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="mb-4 row align-items-center">
        <label for="inputNumberId" class="col-sm-3 col-form-label">Jenis Identitas</label>
        <div class="col-sm-8">
            <select class="form-select @error('identity_type') is-invalid @enderror" id="selectIdentityType"
                name="identity_type" required>
                <option selected disabled value="">Jenis Identitas </option>
                @foreach ($identityTypes as $identity_type)
                    <option value="{{ $identity_type }}"
                        {{ old('identity_type') == $identity_type ? 'selected' : '' }}>
                        {{ strtoupper($identity_type) }}</option>
                @endforeach
            </select>
            @error('identity_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="mb-4 row align-items-center">
        <label for="inputNumberId" class="col-sm-3 col-form-label">Nomor Identitas</label>
        <div class="col-sm-8">
            <input type="text" class="form-control @error('identity_number') is-invalid @enderror" id="inputNumberId"
                name="identity_number" value="{{ old('identity_number') }}" required>
            @error('identity_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="mb-4 row align-items-center">
        <label for="inputNumberId" class="col-sm-3 col-form-label">Unit Kerja</label>
        <div class="col-sm-8">
            <select class="form-select @error('work_unit') is-invalid @enderror" id="selectWorkUnit" name="work_unit"
                required>
                <option selected disabled value="">Pilih Unit Kerja...</option>
                @foreach ($workUnits as $work_unit)
                    <option value="{{ $work_unit->id }}" {{ old('work_unit') == $work_unit->name ? 'selected' : '' }}>
                        {{ $work_unit->name }}</option>
                @endforeach
            </select>
            @error('work_unit')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-4 row align-items-center">
        <label for="inputEmail" class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-8">
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail"
                name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="d-flex justify-content-end">
        <button id="submitButton" class="btn btn-primary" type="submit">
            <span class="icon-name">Simpan</span>
        </button>
    </div>
</form>

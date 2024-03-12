<form id="form-create" action="{{ route('user.store') }}" method="POST" novalidate>
    @csrf
    <div class="mb-4 row align-items-center">
        <label for="selectTypeRole" class="col-sm-4 col-form-label">Pilih Role</label>
        <div class="col-sm-8">
            <select class="form-select @error('user_role') is-invalid @enderror" id="selectTypeRole" name="user_role"
                required>
                <option selected disabled value="">Pilih Jenis Role...</option>
                @foreach ($formattedRoles as $role)
                    <option value="{{ $role['name'] }}" {{ old('user_role') == $role['name'] ? 'selected' : '' }}>
                        {{ $role['formatted_name'] }}</option>
                @endforeach
            </select>
            @error('user_role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="mb-4 row align-items-center">
        <label for="inputFullName" class="col-sm-4 col-form-label">Nama Lengkap</label>
        <div class="col-sm-8">
            <input type="text" class="form-control @error('user_name') is-invalid @enderror" id="inputFullName"
                name="user_name" value="{{ old('user_name') }}" required>
            @error('user_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="mb-4 row align-items-center">
        <label for="inputNumberId" class="col-sm-4 col-form-label">NIP/NIK/NIDN</label>
        <div class="col-sm-8">
            <input type="text" class="form-control @error('identity_number') is-invalid @enderror" id="inputNumberId"
                name="identity_number" value="{{ old('identity_number') }}" required>
            @error('identity_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="mb-4 row align-items-center">
        <label for="inputEmail" class="col-sm-4 col-form-label">Email</label>
        <div class="col-sm-8">
            <input type="email" class="form-control @error('user_email') is-invalid @enderror" id="inputEmail"
                name="user_email" value="{{ old('user_email') }}" required>
            @error('user_email')
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

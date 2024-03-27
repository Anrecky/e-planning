@props(['receipt'])

<button type="button" class="btn btn-sm btn-primary  mb-2 mt-2" data-bs-target="#rampungModal" data-bs-toggle="modal">
    <i data-feather="upload"></i> Form Rampung
</button>

<div class="modal fade c-modal-bg" id="rampungModal" tabindex="-1" role="dialog" aria-labelledby="rampungModalTitle"
    aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rampungModalTitle">Form Rampung</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form-money-app" action="{{ route('receipt-action.update-rampung', $receipt) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <input name="receipt" value="{{ $receipt->id }}" type="hidden">
                    @foreach ($receipt->pengikut as $pengikut)
                        {{-- @dd($pengikut) --}}
                        {{-- @php
                            echo json_encode($pengikut->datas, true);
                            die();
                        @endphp --}}
                        <div class="form-group d-flex align-items-center">
                            <button type="button" data-target="{{ $pengikut->id }}" id="add_rampung"
                                class="add_rampung btn btn-sm btn-primary py-0 px-2">
                                <i data-feather="plus"></i>
                            </button>
                            <label for="iku" class="ms-2 py-0 mb-0">{{ $pengikut->user->name }}</label>
                        </div>
                        <div id="rampung_{{ $pengikut->id }}" class="mt-2">

                        </div>
                    @endforeach
                    <button id="submitFormupload" class="btn btn-warning text-center align-items-center mt-2 py-auto"
                        type="submit">
                        <span class="icon-name">Simpan</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let count_row = [];

        function render_row(id, data = false) {
            if (!count_row[id]) {
                count_row[id] = {
                    'row': 1
                };
            }
            html = `         <div class="input-group mb-2" id="rampung_row_${id}_${count_row[id]['row']}">
                                <span class="input-group-text">${count_row[id]['row']}.</span>
                                <input type="text" placeholder="Perincian" value="${data.rinc??''}" name="rinc_${id}[]"
                                    class="form-control">
                                    <input type="text"  placeholder="Keterangan" value="${data.desc??''}" name="desc_${id}[]"
                                    class="form-control">
                                    <input type="text" placeholder="Jumlah" value="${data.amount??''}" name="amount_${id}[]"
                                        class="form-control amount_rampung">
                                <button type="button" data-parent="${id}" data-row="${count_row[id]['row']}" class="remove_rampung btn btn-danger remove-iku">
                                    <i data-feather="trash"></i>
                                </button>
                            </div>
                       `;

            $('#rampung_' + id).append(html);
            count_row[id]['row']++;

            feather.replace()

            $('.amount_rampung').inputmask({
                alias: 'numeric',
                groupSeparator: '.',
                autoGroup: true,
                digits: 0,
                prefix: 'Rp ',
                placeholder: '0'
            });
        }
        $('.add_rampung').on('click', function(ev) {
            let id = $(this).data('target');
            render_row(id)

            $('.remove_rampung').on('click', function(ev) {
                let parent = $(this).data('parent');
                let row = $(this).data('row');
                $(`#rampung_row_${parent}_${row}`).remove()
            })

        })


        @foreach ($receipt->pengikut as $p)
            @if (!empty($p->datas))
                tmp_data = JSON.parse(@json($p->datas));
                Object.keys(tmp_data).forEach(function(key) {
                    render_row({{ $p->id }}, tmp_data[key])
                });
            @else
                render_row({{ $p->id }})
            @endif
        @endforeach

        $('#form-money-app').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var url = $(this).attr('action');

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
                        text: 'successfully',
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

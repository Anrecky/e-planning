import.meta.glob([
    '../images/**',
]);
import './import.plugins'


function formatAsIDRCurrency(value) {
    if (!isNaN(value)) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(value);
    }
    return '';
}

function enforceNumericInput(event) {
    const charCode = (event.which) ? event.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        event.preventDefault();
    }
}
function confirmDelete(id) {
    Swal.fire({
        title: 'Anda yakin ingin hapus?',
        text: "Data tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

window.formatAsIDRCurrency = formatAsIDRCurrency;
window.enforceNumericInput = enforceNumericInput;
window.confirmDelete = confirmDelete;

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

window.formatAsIDRCurrency = formatAsIDRCurrency;
window.enforceNumericInput = enforceNumericInput;

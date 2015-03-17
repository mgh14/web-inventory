$(document).ready(function() {
    // set barcode onchange actions
    $('#barcodeValue').keyup(function() {
       alert('val: ' + $('#barcodeValue').val());
    });

    // set auto-scan actions
    $('#autoAction').change(function() {
        var checked = $('#autoAction').prop('checked');
        $("#submitScan").prop("disabled", checked);
    });

    $('#submitScan').click(function() {
       alert('submit');
    });

});
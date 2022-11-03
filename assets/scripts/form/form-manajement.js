$(document).ready(() => {
    var nmInput = $('#nickname').val();
    var unInput = $('#username').val();
    var emInput = $('#email').val();
    var tpInput = $('#telp').val();

    if (nmInput != '' && unInput != '' && emInput != '' && tpInput != '') {
        $('.sub-btn').attr('type', 'submit');
    }
});
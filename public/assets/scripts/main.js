$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})

class requestData {
    post(params) {
        let url = params.url
        let data = params.data

        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'POST',
                url: url,
                dataType: "json",
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function (result) {
                    resolve(result)
                },
                error: function (result) {
                    if (result.status == 401) {
                        alert('Your session has expired !!\nPlease relogin')
                        window.location.href = "/"
                    }
                    toastr.options = {
                        "timeOut": false,
                        "closeButton": true
                    }
                    toastr["error"]('Sorry there is a problem, Please try again later, or <br> <a href="https://defriant.com/" target="_blank">Contact Developer</a>')
                }
            })
        })
    }

    get(params) {
        let url = params.url

        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: "json",
                contentType: 'application/json',
                success: function (result) {
                    resolve(result)
                },
                error: function (result) {
                    if (result.status == 401) {
                        alert('Your session has expired !!\nPlease relogin')
                        window.location.href = "/"
                    }
                    toastr.options = {
                        "timeOut": false,
                        "closeButton": true
                    }
                    toastr["error"]('Sorry there is a problem, Please try again later, or <br> <a href="https://defriant.com/" target="_blank">Contact Developer</a>')
                }
            })
        })
    }

    getView(params) {
        let url = params.url

        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'GET',
                url: url,
                success: function (result) {
                    resolve(result)
                },
                error: function (result) {
                    toastr.options = {
                        "timeOut": false,
                        "closeButton": true
                    }
                    toastr["error"]('Sorry there is a problem, Please try again later, or <br> <a href="https://defriant.com/" target="_blank">Contact Developer</a>')
                }
            })
        })
    }
}

const ajaxRequest = new requestData()
const base_url = window.location.origin

$('.date-picker').datetimepicker({
    timepicker: false,
    format: 'Y-m-d'
})

$('.date-picker.today').datetimepicker({
    timepicker: false,
    minDate: 'today',
    format: 'Y-m-d'
})

$('.time-picker').datetimepicker({
    datepicker: false,
    timepicker: true,
    format: 'H:i'
})

$('.month-picker').datepicker({
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: 'MM yy',
    onClose: function (dateText, inst) {
        $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
    }
})

$('.input-number').on('keypress', function (e) {
    let charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
})

let _URL = window.URL || window.webkitURL;

function displayPreview(file, width, height) {
    return new Promise((resolve, reject) => {
        let img = new Image();
        // var sizeKB = file.size / 1024;
        img.src = _URL.createObjectURL(file);
        img.onload = function () {
            if (img.width >= width && img.height >= height) {
                resolve("valid")
            } else {
                resolve("invalid")
            }
        }
    })
}

function formatCurrency(angka) {
    let number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;
    return rupiah;
}

$('.input-currency').on('keyup', function () {
    $(this).val(formatCurrency($(this).val()))
})

$('[data-toggle="tooltip"]').tooltip()

$('#btn-change-password').on('click', function () {
    $('#btn-change-password').attr('disabled', true)

    let params = {
        "oldPass": $('#old-pass').val(),
        "newPass": $('#new-pass').val()
    }

    ajaxRequest.post({
        "url": "/user/change-password",
        "data": params
    }).then(function (result) {
        if (result.response == "success") {
            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
            $('#modalChangePassword').modal('hide')
        } else if (result.response == "failed") {
            $('#old-pass').parent().find('.input-invalid-message').addClass('fadeIn')
        }
    })
})

$('#change-password .required').on('input', function () {
    changePassFieldValidate()
    $(this).parent().find('.input-invalid-message').removeClass('fadeIn')
})

$('#confirm-pass').on('input', function () {
    changePassFieldValidate()
    if ($(this).val() !== $('#new-pass').val()) {
        $(this).parent().find('.input-invalid-message').addClass('fadeIn')
    } else {
        $(this).parent().find('.input-invalid-message').removeClass('fadeIn')
    }
})

function changePassFieldValidate() {
    let valid = true

    $.each($('#change-password .required'), function (i, v) {
        if ($(this).val().length == 0) {
            valid = false
            return false
        }
    })

    if ($('#confirm-pass').val() !== $('#new-pass').val()) {
        valid = false
    }

    if (valid == true) {
        $('#btn-change-password').removeAttr('disabled')
    } else {
        $('#btn-change-password').attr('disabled', true)
    }
}

$('#modalChangePassword').on('hide.bs.modal', function () {
    $('#old-pass').val('')
    $('#new-pass').val('')
    $('#confirm-pass').val('')
    $('#change-password .input-invalid-message').removeClass('fadeIn')
})

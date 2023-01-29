$(window).on('load', function () {
    $('#table-distributor').DataTable({
        'ajax': '/distributor/get',
        'columns': [
            { 'data': 'nama' },
            { 'data': 'wilayah' },
            { 'data': 'instagram' },
            {
                data: null,
                render: function (data) {
                    return `<div style="width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                ${data.whatsapp}
                            </div>`
                }
            },
            {
                data: null,
                render: function (data) {
                    return `<div style="width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                ${data.alamat}
                            </div>`
                }
            },
            {
                data: null,
                render: function (data) {
                    return `<div style="display: flex; gap: 3px;">
                                <button class="btn-table-action edit" data-toggle="modal" data-target="#modalEdit"
                                    data-id="${data.id}"
                                    data-nama="${data.nama}"
                                    data-wilayah="${data.wilayah}"
                                    data-instagram="${data.instagram}"
                                    data-whatsapp="${data.whatsapp}"
                                    data-alamat="${data.alamat}">
                                    <i class="fas fa-cog"></i>
                                </button>
                                <button class="btn-table-action delete" data-toggle="modal" data-target="#modalDelete"
                                    data-id="${data.id}"
                                    data-nama="${data.nama}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>`
                }
            }
        ],
        "fnInitComplete": function () {
            $('.panel-loader').hide()
        },
        "language": {
            "paginate": {
                "next": '&#8594;',
                "previous": '&#8592;'
            }
        }
    })

    $('#add-data .required').on('input', function () {
        addDataValidate()
    })

    $('#btn-add-data').on('click', function () {
        $('#btn-add-data').attr('disabled', true)

        let params = {
            "nama": $('#add-data #nama').val(),
            "wilayah": $('#add-data #wilayah').val(),
            "instagram": $('#add-data #instagram').val(),
            "whatsapp": $('#add-data #whatsapp').val(),
            "alamat": $('#add-data #alamat').val()
        }

        ajaxRequest.post({
            "url": "/distributor/add",
            "data": params
        }).then(function (result) {
            $('#table-distributor').DataTable().ajax.reload()
            $('#modalAdd').modal('hide')

            $('#add-data #nama').val('')
            $('#add-data #wilayah').val('')
            $('#add-data #instagram').val('')
            $('#add-data #whatsapp').val('')
            $('#add-data #alamat').val('')

            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
        })
    })

    $('#table-distributor tbody').on('click', '[class*=edit]', function () {
        $('#edit-data #distributor-id').val($(this).data('id'))
        $('#edit-data #nama').val($(this).data('nama'))
        $('#edit-data #wilayah').val($(this).data('wilayah'))
        $('#edit-data #instagram').val($(this).data('instagram'))
        $('#edit-data #whatsapp').val($(this).data('whatsapp'))
        $('#edit-data #alamat').val($(this).data('alamat'))
    })

    $('#edit-data .required').on('input', function () {
        editDataValidate()
    })

    $('#btn-edit-data').on('click', function () {
        $('#btn-edit-data').attr('disabled', true)

        let params = {
            "id": $('#edit-data #distributor-id').val(),
            "nama": $('#edit-data #nama').val(),
            "wilayah": $('#edit-data #wilayah').val(),
            "instagram": $('#edit-data #instagram').val(),
            "whatsapp": $('#edit-data #whatsapp').val(),
            "alamat": $('#edit-data #alamat').val()
        }

        ajaxRequest.post({
            "url": "/distributor/edit",
            "data": params
        }).then(function (result) {
            $('#table-distributor').DataTable().ajax.reload()
            $('#modalEdit').modal('hide')
            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
        })
    })

    $('#table-distributor tbody').on('click', '[class*=delete]', function () {
        $('#delete-data #distributor-id').val($(this).data('id'))
        $('#delete-data #nama').val($(this).data('nama'))
        $('#delete-warning-message').html(`Delete distributor ${$(this).data('nama')} ?`)
    })

    $('#btn-delete-data').on('click', function () {
        $('#btn-delete-data').attr('disabled', true)

        let params = {
            "id": $('#delete-data #distributor-id').val(),
            "nama": $('#delete-data #nama').val()
        }

        ajaxRequest.post({
            "url": "/distributor/delete",
            "data": params
        }).then(function (result) {
            $('#table-distributor').DataTable().ajax.reload()
            $('#modalDelete').modal('hide')
            $('#btn-delete-data').removeAttr('disabled')
            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
        })
    })
})

function addDataValidate() {
    let valid = true
    $.each($('#add-data .required'), function (i, v) {
        let thisEl = $(this)
        if (thisEl.val().length == 0) {
            valid = false
            return false
        }
    })

    if (valid != true) {
        $('#btn-add-data').attr('disabled', true)
    } else {
        $('#btn-add-data').removeAttr('disabled')
    }
}

function editDataValidate() {
    let valid = true
    $.each($('#edit-data .required'), function (i, v) {
        let thisEl = $(this)
        if (thisEl.val().length == 0) {
            valid = false
            return false
        }
    })

    if (valid != true) {
        $('#btn-edit-data').attr('disabled', true)
    } else {
        $('#btn-edit-data').removeAttr('disabled')
    }
}
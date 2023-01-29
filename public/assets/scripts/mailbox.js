let mailboxActive = null

$(window).on('load', function(){
    tableMailbox = $('#table-mailbox').DataTable({
        'ajax' : '/mailbox/get',
        'columns' : [
            {
                data:null,
                render:function(data){
                    return `<div style="width: 10px;">
                                <label class="fancy-checkbox mailbox-check" style="margin: 0">
                                    <input type="checkbox" class="mail-checkbox" value="${data.id}">
                                    <span style="width: 0"></span>
                                </label>
                            </div>`
                }
            },
            {
                data:null,
                render:function(data) {
                    return `${(data.is_read == 0) ? `<div style="display: flex; gap: 7px;">
                                                            <div style="width: 40px">
                                                                <span class="label label-danger new-message">NEW</span>
                                                            </div>
                                                            <div style="width: max-content">
                                                                ${data.date}
                                                            </div>
                                                        </div>`
                                                        :
                                                        `<div style="display: flex; gap: 7px; width: max-content;">
                                                            <div style="width: 40px"></div>
                                                            <div style="width: max-content;">
                                                                ${data.date}
                                                            </div>
                                                        </div>`}`
                }
            },
            {
                data:null,
                render:function(data) {
                    return `<div style="width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${data.name}</div>`
                }
            },
            {
                data:null,
                render:function(data) {
                    return `<span style="font-size: 13px;" >${data.time}</span>`
                }
            }
        ],
        "fnInitComplete": function(){
            $('.panel-loader').hide()
        },
        "language": {
            "paginate": {
                "next": '&#8594;',
                "previous": '&#8592;'
            },
            "emptyTable": "Mailbox is empty"
        },
        "bAutoWidth": false,
        "ordering": false,
        "bInfo" : false,
        "drawCallback": function(){
            $('#table-mailbox tbody tr').removeClass('row-active')
            $(`#table-mailbox tbody tr[data-id="${mailboxActive}"]`).addClass('row-active')
            mailCheckbox()
        },
        "fnCreatedRow": function(row, data){
            $(row).attr('data-id', data.id)
        }
    })

    $('#table-mailbox tbody').on('click', 'tr', function(e){
        let btnDelete = $(this).find('.mailbox-check')[0]
        if (!btnDelete.contains(e.target)) {
            mailboxActive = $(this).data('id')
            $('#loader-mailbox-data').show()
            $('#table-mailbox tbody tr').removeClass('row-active')
            $(this).addClass('row-active')

            let newMailboxBadge = $(this).find('.new-message')
            let data = tableMailbox.row($(this)).data()

            let mailboxData = `<div class="header">
                                    <h4>${data.date}</h4>
                                    <span>${data.time}</span>
                                </div>
                                <div class="sender">
                                    <div>
                                        <i class="far fa-user"></i>
                                        <p>${data.name}</p>
                                    </div>
                                    <div>
                                        <i class="far fa-phone"></i>
                                        <p>${data.phone}</p>
                                    </div>
                                    <div>
                                        <i class="far fa-envelope"></i>
                                        <p>${(data.email != null) ? data.email : '-'}</p>
                                    </div>
                                </div>
                                <div class="message">
                                    <p>Message :</p>
                                    <p>${data.message}</p>
                                </div>`

            ajaxRequest.post({
                "url": "/mailbox/read",
                "data": {
                    "id": data.id
                }
            }).then(result => {
                newMailboxBadge.remove()
                $('#mailbox-data').empty()
                $('#mailbox-data').html(mailboxData)
                $('#loader-mailbox-data').hide()
            })
        }
    })

    $('#btn-refresh').on('click', function(){
        mailboxActive = null
        $('#btn-refresh').attr('disabled', true)
        $('#table-mailbox').DataTable().ajax.reload(function(){
            $('#btn-refresh').removeAttr('disabled')
            $('#mailbox-data').empty()
            $('#mailbox-data').html(`<div class="null-data-wrapper">
                                        <i class="far fa-info-circle"></i> <h4>Mailbox data</h4>
                                    </div>`)
        })
    })

    $('#delete-mail').on('click', function(){
        $('#delete-mail').attr('disabled', true)

        let mailId = []
        $.each($('.mail-checkbox:checked'), function(i, v){
            mailId.push(v.value)
        })

        if (mailboxActive != null) {
            if (mailId.includes(mailboxActive.toString())) {
                $('#mailbox-data').empty()
                $('#mailbox-data').html(`<div class="null-data-wrapper">
                                            <i class="far fa-info-circle"></i> <h4>Mailbox data</h4>
                                        </div>`)
            }
        }

        let params = {
            "id": mailId
        }

        ajaxRequest.post({
            "url": "/mailbox/delete",
            "data": params
        }).then(result => {
            $('#table-mailbox').DataTable().ajax.reload()
            $('#modalDeleteMailbox').modal('hide')
            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
            $('#delete-mail').removeAttr('disabled')
            $('#btn-delete-mail').attr('disabled', true)
        })
    })
})

function mailCheckbox() {
    $('.mail-checkbox').unbind('change')
    $('.mail-checkbox').on('change', function(){
        if ($('.mail-checkbox:checked').length > 0) {
            $('#btn-delete-mail').removeAttr('disabled')
        }else{
            $('#btn-delete-mail').attr('disabled', true)
        }
    })
}
$(window).on('load', function () {
    getAlbum()

    let imgDefault = base_url + "/assets/images/grey.jpg"

    $('.choose-image').on('click', function () {
        $(this).parent().children('.choose-image-file').click()
    })

    $('#post-album-image').on('change', function () {
        let thisEl = $(this)
        let parent = $(this).parent()
        let file = this.files[0]
        displayPreview(file, 400, 400).then(function (result) {
            if (result == "valid") {
                let fileReader = new FileReader()
                fileReader.readAsDataURL(file)
                fileReader.onload = function () {
                    let result = fileReader.result
                    parent.children('.image-preview').attr('src', result)
                    thisEl.attr('data-value', result)
                    postAlbumValidate()
                }
            }
        }).catch(err => {
            alert(err)
            thisEl.attr('data-value', '')
            thisEl.val('')
            parent.children('.image-preview').attr('src', imgDefault)
            postAlbumValidate()
        })
    })

    $('#post-album-caption').on('input', function () {
        postAlbumValidate()
    })

    $('#edit-album-image').on('change', function () {
        let thisEl = $(this)
        let parent = $(this).parent()
        let file = this.files[0]
        displayPreview(file, 400, 400).then(function (result) {
            if (result == "valid") {
                let fileReader = new FileReader()
                fileReader.readAsDataURL(file)
                fileReader.onload = function () {
                    let result = fileReader.result
                    parent.children('.image-preview').attr('src', result)
                    thisEl.attr('data-value', result)
                }
            }
        }).catch(err => {
            alert(err)
            thisEl.attr('data-value', '')
            thisEl.val('')
        })
    })

    $('#edit-album-caption').on('input', function () {
        editAlbumValidation()
    })

    $('#btn-post-album').on('click', function () {
        $('.panel-loader').show()
        $('#btn-post-album').attr('disabled', true)

        let params = {
            "image": $('#post-album-image').attr('data-value'),
            "caption": $('#post-album-caption').val()
        }

        ajaxRequest.post({
            "url": "/album/add",
            "data": params
        }).then(function (result) {
            $('.panel-loader').show()
            getAlbum()
            $('#add-post-image-preview').attr('src', imgDefault)
            $('#post-album-image').val('')
            $('#post-album-image').attr('data-value', '')
            $('#post-album-caption').val('')

            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
        })
    })

    $('#btn-edit-album').on('click', function () {
        $('.panel-loader').show()
        $('#btn-edit-album').attr('disabled', true)

        let params = {
            "id": $('#edit-album-id').val(),
            "image": $('#edit-album-image').attr('data-value'),
            "caption": $('#edit-album-caption').val()
        }

        ajaxRequest.post({
            "url": "/album/edit",
            "data": params
        }).then(function (result) {
            $('.panel-loader').show()
            getAlbum()
            $('#btn-edit-album').removeAttr('disabled')
            $('#modalUpdateAlbum').modal('hide')
            $('#edit-album-image').attr('data-value', '')
            $('#edit-album-image').val('')

            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
        })
    })

    $('#btn-delete-album').on('click', function () {
        $('#btn-delete-album').attr('disabled', true)

        ajaxRequest.post({
            "url": "/album/delete",
            "data": {
                "id": $('#delete-album-id').val()
            }
        }).then(function (result) {
            $('.panel-loader').show()
            getAlbum()
            $('#modalDeleteAlbum').modal('hide')
            $('#btn-delete-album').removeAttr('disabled')

            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
        })
    })

    $('#btn-update-description').on('click', function () {
        if ($('#album-description').val().replaceAll(' ', '').length === 0) {
            return alert('Please enter description')
        }

        $('#btn-update-description').attr('disabled', true)

        const data = {
            description: $('#album-description').val(),
            displayed: $('#show-description').is(':checked')
        }

        ajaxRequest.post({
            url: 'album/description/update',
            data: data
        }).then(res => {
            $('#btn-update-description').removeAttr('disabled')
            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](res.message)
        })
    })

    $('#show-description').on('change', function () {
        const data = {
            displayed: $(this).is(':checked')
        }

        ajaxRequest.post({
            url: 'album/description/display',
            data: data
        })
    })
})

function getAlbum() {
    ajaxRequest.get({
        "url": "/album/get"
    }).then(function (result) {
        if (result.description) {
            $('#album-description').val(result.description.description)
            if (result.description.displayed) {
                $('#show-description').attr('checked', true)
            } else {
                $('#show-description').attr('checked', false)
            }
        } else {
            $('#album-description').val('')
            $('#show-description').removeAttr('checked')
        }

        if (result.data.length > 0) {
            let albumData = ``

            $.each(result.data, function (i, v) {
                albumData = albumData + `<li>
                                            <i class="fa fa-comment activity-icon"></i>
                                            <img src="${base_url}/assets/images/${v.image}" alt="">
                                            <p>${v.caption}
                                                <span class="timestamp">${v.posted_at}</span>
                                            </p>
                                            <div class="album-tools">
                                                <i class="far fa-pen edit-album" data-toggle="modal" data-target="#modalUpdateAlbum"
                                                    data-id="${v.id}"
                                                    data-caption="${v.caption}"
                                                    data-image="${base_url}/assets/images/${v.image}"></i>
                                                <i class="far fa-trash-alt delete-album" data-id="${v.id}" data-toggle="modal" data-target="#modalDeleteAlbum"></i>
                                            </div>
                                        </li>`
            })

            $('#album-data').html(albumData)
            albumToolsAction()
        } else {
            $('#album-data').html(`<div class="null-data-wrapper">
                                            <i class="far fa-info-circle"></i> <h4>There's no data</h4>
                                        </div>`)
        }
    })
}

function postAlbumValidate() {
    let valid = true

    $.each($('#post-album .required'), function (i, v) {
        if ($(this).val().length == 0) {
            valid = false
            return false
        }
    })

    if (valid == true) {
        $('#btn-post-album').removeAttr('disabled')
    } else {
        $('#btn-post-album').attr('disabled', true)
    }
}

function editAlbumValidation() {
    let valid = true

    $.each($('#edit-album .required'), function (i, v) {
        if ($(this).val().length == 0) {
            valid = false
            return false
        }
    })

    if (valid == true) {
        $('#btn-edit-album').removeAttr('disabled')
    } else {
        $('#btn-edit-album').attr('disabled', true)
    }
}

function albumToolsAction() {
    $('.edit-album').on('click', function () {
        let thisEl = $(this)

        $('#edit-album-image').val('')
        $('#edit-album-image').attr('data-value', '')

        $('#edit-album-id').val(thisEl.data('id'))
        $('#edit-album-image-preview').attr('src', thisEl.data('image'))
        $('#edit-album-caption').val(thisEl.data('caption'))
    })

    $('.delete-album').on('click', function () {
        $('#delete-album-id').val($(this).data('id'))
    })
}

$(document).ajaxStop(function () {
    $('.panel-loader').hide()
})
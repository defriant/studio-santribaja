$(window).on('load', function () {
    getGallery()

    let imgDefault = base_url + "/assets/images/grey.jpg"

    $('.choose-image').on('click', function () {
        $(this).parent().children('.choose-image-file').click()
    })

    $('#add-thumbnail-gallery').on('change', function () {
        let thisEl = $(this)
        let parent = $(this).parent()
        let file = this.files[0]
        displayPreview(file, 400, 200).then(function (result) {
            if (result == "valid") {
                let fileReader = new FileReader()
                fileReader.readAsDataURL(file)
                fileReader.onload = function () {
                    let result = fileReader.result
                    parent.children('.image-preview').attr('src', result)
                    thisEl.attr('data-value', result)
                    addGalleryValidate()
                }
            }
        }).catch(err => {
            alert(err)
            thisEl.attr('data-value', '')
            thisEl.val('')
            parent.children('.image-preview').attr('src', imgDefault)
            addGalleryValidate()
        })
    })

    $('#link-youtube').on('input', function () {
        addGalleryValidate()
    })

    $('#edit-thumbnail-gallery').on('change', function () {
        let thisEl = $(this)
        let parent = $(this).parent()
        let file = this.files[0]
        displayPreview(file, 400, 200).then(function (result) {
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

    $('#edit-link-youtube').on('input', function () {
        editGalleryValidate()
    })

    $('#btn-add-gallery').on('click', function () {
        $('.panel-loader').show()
        $('#btn-add-gallery').attr('disabled', true)

        let params = {
            "thumbnail": $('#add-thumbnail-gallery').attr('data-value'),
            "link_youtube": $('#link-youtube').val()
        }

        ajaxRequest.post({
            "url": "/gallery/add",
            "data": params
        }).then(function (result) {
            getGallery()
            $('#modalAddGallery').modal('hide')
            $('#add-thumbnail-gallery-preview').attr('src', imgDefault)
            $('#add-thumbnail-gallery').val('')
            $('#add-thumbnail-gallery').attr('data-value', '')
            $('#link-youtube').val('')

            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
        })
    })

    $('#btn-edit-gallery').on('click', function () {
        $('.panel-loader').show()
        $('#btn-edit-gallery').attr('disabled', true)

        let params = {
            "id": $('#edit-gallery-id').val(),
            "thumbnail": $('#edit-thumbnail-gallery').attr('data-value'),
            "link_youtube": $('#edit-link-youtube').val()
        }

        ajaxRequest.post({
            "url": "/gallery/edit",
            "data": params
        }).then(function (result) {
            getGallery()
            $('#btn-edit-gallery').removeAttr('disabled')
            $('#modalEditGallery').modal('hide')
            $('#edit-thumbnail-gallery').attr('data-value', '')
            $('#edit-thumbnail-gallery').val('')

            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
        })
    })

    $('#btn-delete-gallery').on('click', function () {
        $('#btn-delete-gallery').attr('disabled', true)

        ajaxRequest.post({
            "url": "/gallery/delete",
            "data": {
                "id": $('#delete-gallery-id').val()
            }
        }).then(function (result) {
            getGallery()
            $('#modalDeleteGallery').modal('hide')
            $('#btn-delete-gallery').removeAttr('disabled')

            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
        })
    })

    $('#btn-update-description').on('click', function () {
        if ($('#gallery-description').val().replaceAll(' ', '').length === 0) {
            return alert('Please enter description')
        }

        $('#btn-update-description').attr('disabled', true)

        const data = {
            description: $('#gallery-description').val(),
            displayed: $('#show-description').is(':checked')
        }

        ajaxRequest.post({
            url: 'gallery/description/update',
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
            url: 'gallery/description/display',
            data: data
        })
    })
})

function getGallery() {
    $('.panel-loader').show()

    ajaxRequest.get({
        "url": "/gallery/get"
    }).then(function (result) {
        if (result.description) {
            $('#gallery-description').val(result.description.description)
            if (result.description.displayed) {
                $('#show-description').attr('checked', true)
            } else {
                $('#show-description').attr('checked', false)
            }
        } else {
            $('#gallery-description').val('')
            $('#show-description').removeAttr('checked')
        }

        if (result.data.length > 0) {
            let galleryData = ``

            $.each(result.data, function (i, v) {
                galleryData = galleryData + `<div class="gallery" style="background-image: url('${base_url}/assets/images/${v.thumbnail}');">
                                                        <div class="overlay">
                                                            <a href="${v.link_youtube}" target="_blank" class="btn-overlay add gallery-play"><i class="far fa-play"></i></a>
                                                            <button class="btn-overlay edit edit-gallery" data-toggle="modal" data-target="#modalEditGallery"
                                                                data-id="${v.id}"
                                                                data-thumbnail="${base_url}/assets/images/${v.thumbnail}"
                                                                data-linkyoutube="${v.link_youtube}">
                                                                <i class="far fa-pen"></i>
                                                            </button>
                                                            <button class="btn-overlay delete delete-gallery" data-toggle="modal" data-target="#modalDeleteGallery"
                                                                data-id="${v.id}">
                                                                <i class="far fa-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    </div>`
            })

            $('#gallery-data').html(galleryData)
            galleryToolsAction()
        } else {
            $('#gallery-data').html(`<div class="null-data-wrapper">
                                            <i class="far fa-info-circle"></i> <h4>There's no data</h4>
                                        </div>`)
        }
    })
}

function addGalleryValidate() {
    let valid = true

    $.each($('#add-gallery .required'), function (i, v) {
        if ($(this).val().length == 0) {
            valid = false
            return false
        }
    })

    if (valid == true) {
        $('#btn-add-gallery').removeAttr('disabled')
    } else {
        $('#btn-add-gallery').attr('disabled', true)
    }
}

function editGalleryValidate() {
    let valid = true

    $.each($('#edit-gallery .required'), function (i, v) {
        if ($(this).val().length == 0) {
            valid = false
            return false
        }
    })

    if (valid == true) {
        $('#btn-edit-gallery').removeAttr('disabled')
    } else {
        $('#btn-edit-gallery').attr('disabled', true)
    }
}

function galleryToolsAction() {
    $('.edit-gallery').on('click', function () {
        let thisEl = $(this)

        $('#edit-gallery-id').val(thisEl.data('id'))
        $('#edit-thumbnail-gallery-preview').attr('src', thisEl.data('thumbnail'))
        $('#edit-link-youtube').val(thisEl.data('linkyoutube'))
    })

    $('.delete-gallery').on('click', function () {
        $('#delete-gallery-id').val($(this).data('id'))
    })
}

$(document).ajaxStop(function () {
    $('.panel-loader').hide()
})
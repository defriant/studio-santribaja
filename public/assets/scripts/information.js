let aboutImgWidth = $('.about-image').width()

$(window).on('load', function () {
    getInformation()

    let imgDefault = base_url + "/assets/images/grey.jpg"

    $('.about-image').css('height', `${(aboutImgWidth * 75) / 100}px`)
    $('.about-image img').css('width', `${aboutImgWidth}px`)
    $('.about-image img').css('height', `${(aboutImgWidth * 75) / 100}px`)
    // $('#about-us').css('height', `${((aboutImgWidth * 75) / 100) - 50}px`)

    $('.img-btn').on('click', function () {
        let parent = $(this).parent().parent()
        parent.find('.img-file').click()
    })

    $('.img-file').on('change', function () {
        let thisEl = $(this)
        let thisVal = $(this).val()
        let parent = $(this).parent()
        let file = this.files[0]
        let imgWidth = $(this).data('width')
        let imgHeight = $(this).data('height')
        displayPreview(file, imgWidth, imgHeight).then(function (result) {
            if (result == "valid") {
                let accept = thisEl.attr('data-accept').split(" ")
                let formatValid = false

                $.each(accept, function (i, v) {
                    if (thisVal.substr(thisVal.length - v.length, v.length).toLowerCase() == v.toLowerCase()) {
                        formatValid = true
                        return false
                    }
                })

                if (formatValid == false) {
                    alert('Format gambar tidak sesuai')
                } else if (formatValid == true) {
                    let fileReader = new FileReader()
                    fileReader.readAsDataURL(file)
                    fileReader.onload = function () {
                        let result = fileReader.result
                        parent.find('.img-preview').attr('src', result)
                        thisEl.attr('data-value', result)
                    }
                }
            } else if (result == "invalid") {
                alert(`Image resolution doesn't match`)
            }
        })
    })

    $('#logo').on('change', function () {
        generalValidate()
    })

    $('#general-information .required').on('input', function () {
        generalValidate()
    })

    $('#btn-general-save').on('click', function () {
        $('#panel-loader-general').show()

        // if ($('#logo').attr('data-value') != '') {
        //     $('.logo-wrapper .img-preview').attr('src', `${base_url}/assets/images/grey.jpg`)
        // }

        let params = {
            "email": $('#email').val(),
            "telepon": $('#telepon').val(),
            "facebook": $('#facebook').val(),
            "instagram": $('#instagram').val(),
            "youtube": $('#youtube').val(),
            "whatsapp": $('#whatsapp').val(),
            "logo": $('#logo').attr('data-value')
        }

        ajaxRequest.post({
            "url": "/content-manager/information/general/update",
            "data": params
        }).then(function (result) {
            // $('.logo-wrapper .img-preview').attr('src', `${base_url}/assets/images/logo.png`)
            $('#logo').attr('data-value', '')

            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
            getInformation()
        })
    })

    $("#about-us").on('input', function () {
        aboutValidate()
    })

    $('#btn-about-save').on('click', function () {
        $('#panel-loader-about').show()

        let params = {
            "about": $('#about-us').val()
        }

        ajaxRequest.post({
            "url": "/content-manager/information/about/update",
            "data": params
        }).then(function (result) {
            $('#btn-about-save').attr('disabled', true)

            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
            getInformation()
        })
    })

    $('.choose-image').on('click', function () {
        $(this).parent().children('.choose-image-file').click()
    })

    $('#add-about-image').on('change', function () {
        let thisEl = $(this)
        let parent = $(this).parent()
        let file = this.files[0]
        displayPreview(file, 500, 500).then(function (result) {
            if (result == "valid") {
                let fileReader = new FileReader()
                fileReader.readAsDataURL(file)
                fileReader.onload = function () {
                    let result = fileReader.result
                    parent.children('.image-preview').attr('src', result)
                    thisEl.attr('data-value', result)
                    addAboutImageValidation()
                }
            } else if (result == "invalid") {
                alert(`Image resolution doesn't match`)
                thisEl.attr('data-value', '')
                thisEl.val('')
                parent.children('.image-preview').attr('src', imgDefault)
                addAboutImageValidation()
            }
        })
    })

    $('#modalAddAboutImages').on('hide.bs.modal', function () {
        $('#add-about-image-preview').attr('src', imgDefault)
        $('#add-about-image').attr('data-value', '')
        addAboutImageValidation()
    })

    $('#btn-add-about-image').on('click', function () {
        const data = {
            'image': $('#add-about-image').attr('data-value')
        }

        $('#btn-add-about-image').attr('disabled', true)

        ajaxRequest.post({
            url: '/content-manager/about/image/add',
            data: data
        }).then(res => {
            $('#modalAddAboutImages').modal('hide')
            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](res.message)
            getInformation()
        })
    })

    $('#btn-delete-about-image').on('click', function () {
        $('#btn-delete-about-image').attr('disabled', true)
        ajaxRequest.get({
            url: `/content-manager/about/image/${$('#delete-about-image-id').val()}/delete`
        }).then(res => {
            $('#btn-delete-about-image').removeAttr('disabled')
            $('#modalDeleteAboutImages').modal('hide')
            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](res.message)
            getInformation()
        })
    })

    $('#update-about-image').on('change', function () {
        let thisEl = $(this)
        let parent = $(this).parent()
        let file = this.files[0]
        displayPreview(file, 500, 500).then(function (result) {
            if (result == "valid") {
                let fileReader = new FileReader()
                fileReader.readAsDataURL(file)
                fileReader.onload = function () {
                    let result = fileReader.result
                    parent.children('.image-preview').attr('src', result)
                    thisEl.attr('data-value', result)
                    updateAboutImageValidation()
                }
            } else if (result == "invalid") {
                alert(`Image resolution doesn't match`)
                thisEl.attr('data-value', '')
                thisEl.val('')
                parent.children('.image-preview').attr('src', $('#update-about-image-current').val())
                updateAboutImageValidation()
            }
        })
    })

    $('#modalUpdateAboutImage').on('hide.bs.modal', function () {
        $('#update-about-image-id').val('')
        $('#update-about-image-current').val('')
        $('#update-about-image-preview').attr('src', imgDefault)
        $('#update-about-image').attr('data-value', '')
        updateAboutImageValidation()
    })

    $('#btn-update-about-image').on('click', function () {
        const data = {
            'image': $('#update-about-image').attr('data-value')
        }

        $('#btn-update-about-image').attr('disabled', true)

        ajaxRequest.post({
            url: `/content-manager/about/image/${$('#update-about-image-id').val()}/update`,
            data: data
        }).then(res => {
            $('#modalUpdateAboutImage').modal('hide')
            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](res.message)
            getInformation()
        })
    })
})

function getInformation() {
    ajaxRequest.get({
        "url": "/content-manager/information/get"
    }).then(function (result) {
        $('#email').val(result.data.email)
        $('#telepon').val(result.data.telepon)
        $('#facebook').val(result.data.facebook)
        $('#instagram').val(result.data.instagram)
        $('#youtube').val(result.data.youtube)
        $('#whatsapp').val(result.data.whatsapp)

        $('#about-us').val(result.data.about)

        let about_image_el = result.data.about_images.map(v => {
            return `<div class="gallery" style="background-image: url('${base_url}/assets/images/${v.filename}'); width: 250px; height: 250px">
                        <div class="overlay">
                            <button class="btn-overlay edit edit-about-image" data-toggle="modal" data-target="#modalUpdateAboutImage" data-id="${v.id}" data-image="${base_url}/assets/images/${v.filename}">
                                <i class="far fa-pen"></i>
                            </button>
                            <button class="btn-overlay delete delete-about-image" data-toggle="modal" data-target="#modalDeleteAboutImages" data-id="${v.id}">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>`
        })

        $('#about-images').html(about_image_el)
        $('.delete.delete-about-image').on('click', function () {
            $('#delete-about-image-id').val($(this).data('id'))
        })

        $('.edit.edit-about-image').on('click', function () {
            $('#update-about-image-id').val($(this).data('id'))
            $('#update-about-image-current').val($(this).data('image'))

            $('#update-about-image-preview').attr('src', $(this).data('image'))
        })
    })
}

function generalValidate() {
    let valid = true

    $.each($('#general-information .required'), function (i, v) {
        if ($(this).val().length == 0) {
            valid = false
            return false
        }
    })

    if (valid == true) {
        $('#btn-general-save').removeAttr('disabled')
    } else {
        $('#btn-general-save').attr('disabled', true)
    }
}

function aboutValidate() {
    let valid = true

    if ($("#about-us").val().length == 0) {
        valid = false
    }

    if (valid == true) {
        $('#btn-about-save').removeAttr('disabled')
    } else {
        $('#btn-about-save').attr('disabled', true)
    }
}

function addAboutImageValidation() {
    if (!$('#add-about-image').attr('data-value')) return $('#btn-add-about-image').attr('disabled', true)
    return $('#btn-add-about-image').removeAttr('disabled')
}

function updateAboutImageValidation() {
    if (!$('#update-about-image').attr('data-value')) return $('#btn-update-about-image').attr('disabled', true)
    return $('#btn-update-about-image').removeAttr('disabled')
}

$(document).ajaxStop(function () {
    $('.panel-loader').hide()
})
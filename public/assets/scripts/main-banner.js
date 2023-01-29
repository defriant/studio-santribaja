let mainBannerWrapperWidth = $('#main-banner-width').width()
let mainBannerImages = null

function setMainBannerSize() {
    $('#main-banner-wrapper').css('height', `${mainBannerWrapperWidth / 2}px`)
    $('#img-main-banner').css('height', `${mainBannerWrapperWidth / 2}px`)
    $('#main-banner-overlay').css('height', `${mainBannerWrapperWidth / 2}px`)
    $('#main-banner-overlay').css('width', `${mainBannerWrapperWidth}px`)
}

$(window).on('load', function () {
    getMainBannerData()

    setMainBannerSize()
    $('#img-main-banner').attr('src', `${base_url}/assets/images/grey.jpg`)

    new ResizeSensor($('#main-banner-width'), function () {
        mainBannerWrapperWidth = $('#main-banner-width').width()
        setMainBannerSize()
    });

    $('#main-banner-edit-choose-file').on('click', function () {
        $('#main-banner-edit-file').click()
    })

    $('#main-banner-edit-file').on('change', function () {
        let file = this.files[0]
        displayPreview(file, 1920, 1080).then(function (result) {
            if (result == "valid") {
                let fileReader = new FileReader()
                fileReader.readAsDataURL(file)
                fileReader.onload = function () {
                    let result = fileReader.result
                    $('#img-main-banner').attr('src', result)
                    mainBannerImages = file
                }
            } else if (result == "invalid") {
                alert(`Image resolution doesn't match`)
                // $('#btn-save-banner-edit').attr('disabled', true)
            }
        })
    })

    $('#modalEditMainBanner').on('hide.bs.modal', function () {
        $('.img-file-invalid').removeClass('show')
        $('#btn-save-banner-edit').attr('disabled', true)
    })

    $('#btn-save-banner-edit').on('click', function () {
        // $('#btn-save-banner-edit').attr('disabled', true)
        // $('.panel-loader').show()
        // $('#modalEditMainBanner').modal('hide')

        let params = {
            "title": $('#title').val(),
            "description": $('#description').val()
        }

        function sendUpdate(data) {
            ajaxRequest.post({
                "url": "/content-manager/main-banner/update",
                "data": data
            }).then(function (result) {
                mainBannerImages = null
                toastr.option = {
                    "timeout": "5000"
                }
                toastr["success"](result.message)
                getMainBannerData()
            })
        }

        if (mainBannerImages) {
            let reader = new FileReader()
            reader.readAsDataURL(mainBannerImages)
            reader.onload = function () {
                let main_banner = reader.result
                params.main_banner = main_banner

                sendUpdate(params)
            }
        } else {
            sendUpdate(params)
        }

        // let reader = new FileReader()
        // reader.readAsDataURL($('#main-banner-edit-file')[0].files[0])
        // reader.onload = function () {
        //     let main_banner = reader.result
        //     let params = {
        //         "title": $('#title').val(),
        //         "description": $('#description').val(),
        //         "main_banner": main_banner
        //     }

        //     ajaxRequest.post({
        //         "url": "/content-manager/main-banner/update",
        //         "data": params
        //     }).then(function (result) {
        //         toastr.option = {
        //             "timeout": "5000"
        //         }
        //         toastr["success"](result.message)
        //         getMainBannerData()
        //     })
        // }
    })

    $('#btn-delete-banner').on('click', function () {
        $('#btn-delete-banner').attr('disabled', true)
        $('.panel-loader').show()
        $('#modalDeleteMainBanner').modal('hide')

        let params = {
            "id": $('#delete-banner-id').val()
        }

        ajaxRequest.post({
            "url": "/content-manager/main-banner/delete",
            "data": params
        }).then(function (result) {
            $('#btn-delete-banner').removeAttr('disabled')
            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
            getMainBannerData()
        })
    })
})

function getMainBannerData() {
    ajaxRequest.get({
        "url": "/content-manager/main-banner/get"
    }).then(function (result) {
        console.log(result)
        $('#title').val(result.data.title)
        $('#description').val(result.data.description)
        $('#img-main-banner').attr('src', `${base_url}/assets/images/${result.data.filename}`)

        // if (result.data.length > 0) {
        //     let mainBannerData = result.data

        //     let mainBannerHtml = ``
        //     let bannerUrl = base_url + '/assets/images/'

        //     $.each(mainBannerData, function (i, v) {
        //         mainBannerHtml = mainBannerHtml + `<div class="main-banner-wrapper" style="height: ${mainBannerWrapperWidth / 3}px">
        //                                                 <img src="${bannerUrl + v.filename}" class="img-banner" style="height: ${mainBannerWrapperWidth / 3}px">
        //                                                 <div class="main-banner-overlay" style="width: ${mainBannerWrapperWidth}px; height: ${mainBannerWrapperWidth / 3}px">
        //                                                     <button class="btn-overlay edit" data-toggle="modal" data-target="#modalEditMainBanner" data-image="${bannerUrl + v.filename}" data-idbanner="${v.id}"><i class="far fa-pen"></i></button>
        //                                                     <button class="btn-overlay delete" data-toggle="modal" data-target="#modalDeleteMainBanner" data-image="${bannerUrl + v.filename}" data-idbanner="${v.id}"><i class="far fa-trash-alt"></i></button>
        //                                                 </div>
        //                                             </div>`
        //     })

        //     $('#main-banner-data').empty()
        //     $('#main-banner-data').html(mainBannerHtml)
        //     btnBannerOverlay()
        // } else {
        //     $('#main-banner-data').empty()
        //     $('#main-banner-data').html(`<div class="null-data-wrapper">
        //                                     <i class="far fa-info-circle"></i> <h4>Belum ada banner yang ditambahkan</h4>
        //                                 </div>`)
        // }

    })
}

function btnBannerOverlay() {
    $('.btn-overlay.edit').unbind('click')
    $('.btn-overlay.edit').on('click', function () {
        $('.img-banner-modal').attr('src', $(this).data('image'))
        $('#edit-banner-id').val($(this).data('idbanner'))
    })

    $('.btn-overlay.delete').unbind('click')
    $('.btn-overlay.delete').on('click', function () {
        $('.img-banner-modal').attr('src', $(this).data('image'))
        $('#delete-banner-id').val($(this).data('idbanner'))
    })
}

$(document).ajaxStop(function () {
    $('.panel-loader').hide()
})
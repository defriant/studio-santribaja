let modalEditWidth = $('.modal-banner-content').width()

let grid3BannerWrapperWidth
let grid3BannerWrapperHeight
let grid3ChildBannerHeight

if (window.matchMedia( "(max-width: 768px)" ).matches) {
    grid3BannerWrapperWidth = $('.panel-body').width() - 20
}else {
    grid3BannerWrapperWidth = ($('.panel-body').width() / 2) - 20
}

console.log(modalEditWidth);

grid3BannerWrapperHeight = grid3BannerWrapperWidth / 2
grid3ChildBannerHeight = (grid3BannerWrapperHeight / 2) - 10

$(window).on('load', function(){
    getBanner()

    $('.grid3-main, .grid3-main img, .grid3-main .main-banner-overlay').css('width', `${grid3BannerWrapperWidth}px`)
    $('.grid3-main, .grid3-main img, .grid3-main .main-banner-overlay').css('height', `${grid3BannerWrapperHeight}px`)

    $('.grid3-child, .grid3-child img, .grid3-child .main-banner-overlay').css('width', `${grid3BannerWrapperWidth}px`)
    $('.grid3-child, .grid3-child img, .grid3-child .main-banner-overlay').css('height', `${grid3ChildBannerHeight}px`)

    $('.grid2-main, .grid2-main img, .grid2-main .main-banner-overlay').css('width', `${grid3BannerWrapperWidth}px`)
    $('.grid2-main, .grid2-main img, .grid2-main .main-banner-overlay').css('height', `${grid3BannerWrapperHeight}px`)

    $('#modalEditBanner .img-banner-modal').css('height', `${modalEditWidth / 2}px`)
    $('#modalEditChildBanner .img-banner-modal').css('height', `${(modalEditWidth / 2) / 2}px`)

    $('#edit-banner-choose-file').on('click', function(){
        $('#edit-banner-file').click()
    })

    $('#edit-banner-file').on('change', function(){
        let file = this.files[0]
        displayPreview(file, 1000, 500).then(function(result){
            if (result == "valid") {
                $('#edit-banner-file-invalid').removeClass('show')
                $('#btn-save-banner-edit').removeAttr('disabled')
                let fileReader = new FileReader()
                fileReader.readAsDataURL(file)
                fileReader.onload = function(){
                    let result = fileReader.result
                    $('#modalEditBanner .img-banner-modal').attr('src', result)
                }
            }else if (result == "invalid") {
                $('#edit-banner-file-invalid').addClass('show')
                $('#btn-save-banner-edit').attr('disabled', true)
            }
        })
    })

    $('#modalEditBanner').on('hide.bs.modal', function(){
        $('#edit-banner-file-invalid').removeClass('show')
        $('#btn-save-banner-edit').attr('disabled', true)
    })

    $('#btn-save-banner-edit').on('click', function(){
        $('#btn-save-banner-edit').attr('disabled', true)

        let reader = new FileReader()
        reader.readAsDataURL($('#edit-banner-file')[0].files[0])
        reader.onload = function(){
            let banner = reader.result
            let params = {
                "type": $('#modalEditBanner .banner_type').val(),
                "banner_order": $('#modalEditBanner .banner_order').val(),
                "banner": banner
            }

            ajaxRequest.post({
                "url": "/content-manager/other-banner/update",
                "data": params
            }).then(function(result){
                getBanner()
                $('#edit-banner-file').val('')
                $('#modalEditBanner').modal('hide')
                toastr.option = {
                    "timeout": "5000"
                }
                toastr["success"](result.message)
            })
        }
    })

    $('#edit-child-banner-choose-file').on('click', function(){
        $('#edit-child-banner-file').click()
    })

    $('#edit-child-banner-file').on('change', function(){
        let file = this.files[0]
        displayPreview(file, 1000, 240).then(function(result){
            if (result == "valid") {
                $('#edit-child-banner-file-invalid').removeClass('show')
                $('#btn-save-child-banner-edit').removeAttr('disabled')
                let fileReader = new FileReader()
                fileReader.readAsDataURL(file)
                fileReader.onload = function(){
                    let result = fileReader.result
                    $('#modalEditChildBanner .img-banner-modal').attr('src', result)
                }
            }else if (result == "invalid") {
                $('#edit-child-banner-file-invalid').addClass('show')
                $('#btn-save-child-banner-edit').attr('disabled', true)
            }
        })
    })

    $('#modalEditChildBanner').on('hide.bs.modal', function(){
        $('#edit-child-banner-file-invalid').removeClass('show')
        $('#btn-save-child-banner-edit').attr('disabled', true)
    })

    $('#btn-save-child-banner-edit').on('click', function(){
        $('#btn-save-child-banner-edit').attr('disabled', true)

        let reader = new FileReader()
        reader.readAsDataURL($('#edit-child-banner-file')[0].files[0])
        reader.onload = function(){
            let banner = reader.result
            let params = {
                "type": $('#modalEditChildBanner .banner_type').val(),
                "banner_order": $('#modalEditChildBanner .banner_order').val(),
                "banner": banner
            }

            ajaxRequest.post({
                "url": "/content-manager/other-banner/update",
                "data": params
            }).then(function(result){
                getBanner()
                $('#edit-child-banner-file').val('')
                $('#modalEditChildBanner').modal('hide')
                toastr.option = {
                    "timeout": "5000"
                }
                toastr["success"](result.message)
            })
        }
    })
})

function getBanner() {
    ajaxRequest.get({
        "url": "/content-manager/other-banner/get"
    }).then(function(result){
        $.each(result.banner_grid_3, function(i, v){
            $(`.banner-grid3-wrapper .banner-order-${i} .img-banner`).attr('src', `${base_url}/assets/images/${v.filename}`)
            $(`.banner-grid3-wrapper .banner-order-${i} .btn-overlay.edit`).attr('data-banner', `${base_url}/assets/images/${v.filename}`)
        })

        $.each(result.banner_grid_2, function(i, v){
            $(`.banner-grid2-wrapper .banner-order-${i} .img-banner`).attr('src', `${base_url}/assets/images/${v.filename}`)
            $(`.banner-grid2-wrapper .banner-order-${i} .btn-overlay.edit`).attr('data-banner', `${base_url}/assets/images/${v.filename}`)
        })

        btnBannerOverlay()
    })
}

function btnBannerOverlay() {
    $('.btn-overlay.edit').unbind('click')
    $('.btn-overlay.edit').on('click', function(){
        $('.banner_type').val($(this).data('type'))
        $('.banner_order').val($(this).data('order'))
        $('.img-banner-modal').attr('src', $(this).data('banner'))
    })
}

$(document).ajaxStop(function(){
    $('.panel-loader').hide()
})
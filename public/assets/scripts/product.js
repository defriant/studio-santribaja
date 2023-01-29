$(window).on('load', function () {
    getKategori()
    getProduct()

    $('#modalAddKategori').on('show.bs.modal', function () {
        setTimeout(() => {
            $('#add-kategori-name').focus()
        }, 500);

        $('#add-product-to-category-loader').show()

        ajaxRequest.get({
            "url": "/product/independent-category/get"
        }).then(function (result) {
            $('#add-product-to-category-loader').hide()

            if (result.data.length > 0) {
                let productIndependentData = ``

                $.each(result.data, function (i, v) {
                    productIndependentData = productIndependentData + `<label class="fancy-checkbox">
                                                                            <input type="checkbox" value="${v.id}" class="add-product-to-category">
                                                                            <span>${v.name}</span>
                                                                        </label>`
                })

                $('#add-product-to-category-data').html(productIndependentData)
            } else {
                $('#add-product-to-category-data').html(`<div class="null-data-wrapper">
                                                            <i class="far fa-info-circle"></i> <h4>Tidak ada produk untuk ditambahkan</h4>
                                                        </div>`)
            }
        })
    })

    $('#btn-add-kategori').on('click', function () {
        if ($('#add-kategori-name').val().length == 0) {
            alert('Please enter category name')
        } else if (!$('#category-image').attr('data-value')) {
            alert('Please choose image for this category')
        } else {
            let products = []

            $.each($('.add-product-to-category:checked'), function (i, v) {
                products.push($(this).val())
            })

            let params = {
                'name': $('#add-kategori-name').val(),
                'products': products,
                'image': $('#category-image').attr('data-value')
            }

            $('#btn-add-kategori').attr('disabled', true)

            ajaxRequest.post({
                'url': '/product/kategori/add',
                'data': params
            }).then(function (result) {
                $('#btn-add-kategori').removeAttr('disabled')
                if (result.status == 'success') {
                    getKategori()
                    getProduct()
                    $('#modalAddKategori').modal('hide')
                    $('#add-kategori-name').val('')
                    toastr.option = {
                        'timeout': '5000'
                    }
                    toastr['success'](result.message)
                    $('#modalAddKategori .choose-image-file-category').val('')
                    $('#modalAddKategori .choose-image-file-category').attr('data-value', '')
                    $('#modalAddKategori #category-image-preview').attr('src', imgDefault)
                } else if (result.status == 'failed') {
                    toastr.option = {
                        'timeout': '5000'
                    }
                    toastr['info'](result.message)
                }
            })
        }
    })

    $('#btn-save-kategori').on('click', function () {
        if ($('#update-kategori-name').val().length == 0) {
            alert('Please enter category name')
        } else {
            let params = {
                'id': $('#update-kategori-id').val(),
                'name': $('#update-kategori-name').val(),
                'image': $('#update-category-image').attr('data-value') ? $('#update-category-image').attr('data-value') : null
            }

            $('#btn-save-kategori').attr('disabled', true)

            ajaxRequest.post({
                'url': '/product/kategori/update',
                'data': params
            }).then(function (result) {
                getKategori()
                getProduct()
                $('#modalUpdateKategori').modal('hide')
                $('#btn-save-kategori').removeAttr('disabled')
                toastr.option = {
                    'timeout': '5000'
                }
                toastr['success'](result.message)
            })
        }
    })

    $('#btn-delete-kategori').on('click', function () {
        $('#btn-delete-kategori').attr('disabled', true)

        let params = {
            "id": $('#delete-kategori-id').val(),
            "name": $('#delete-kategori-name').val()
        }

        ajaxRequest.post({
            "url": "/product/kategori/delete",
            "data": params
        }).then(function (result) {
            getKategori()
            $('#modalDeleteKategori').modal('hide')
            $('#btn-delete-kategori').removeAttr('disabled')
            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
        })
    })

    let imgDefault = base_url + "/assets/images/grey.jpg"

    $('.choose-image').on('click', function () {
        let parent = $(this).parent()
        parent.children('.choose-image-file').click()
    })

    $('.modal-add-product .choose-image-file').on('change', function () {
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
                    addProductValidate()
                }
            } else if (result == "invalid") {
                alert(`Image resolution doesn't match`)
                thisEl.attr('data-value', '')
                thisEl.val('')
                parent.children('.image-preview').attr('src', imgDefault)
                addProductValidate()
            }
        })
    })

    $('.modal-add-product .produk-detail .required').on('input', function () {
        addProductValidate()
    })

    $('#add-popular-product').on('change', function () {
        if ($(this).is(':checked')) {
            $('#add-popular-product-notice').fadeIn(300)
        } else {
            $('#add-popular-product-notice').fadeOut(300)
        }
    })

    $('#add-specification-choose-file').on('click', function () {
        $('#add-specification').click()
    })

    $('#add-specification').on('change', function () {
        const file = this.files[0]

        if (file) {
            const filename = file.name

            const fileReader = new FileReader()
            fileReader.readAsDataURL(file)
            fileReader.onload = function () {
                const res = fileReader.result
                $('#add-specification').attr('data-filename', filename.replaceAll(' ', '-').replace(/\.[^/.]+$/, ""))
                $('#add-specification').attr('data-value', res)
                $('#add-specification-choose-file input').val(filename)
            }
        }
    })

    $('#btn-add-product').on('click', function () {
        let params = {
            "name": $('#add-name').val(),
            "category": $('#add-category').val(),
            "description": $('#add-description').val(),
            "image_1": $('#add-image-1').attr('data-value'),
            "specification": $('#add-specification').attr('data-value') ? {
                content: $('#add-specification').attr('data-value'),
                filename: $('#add-specification').attr('data-filename')
            } : ''
        }

        $('#btn-add-product').attr('disabled', true)

        ajaxRequest.post({
            "url": "/product/add",
            "data": params
        }).then(function (result) {
            $('#modalAddProduct').modal('hide')

            $('.modal-add-product .choose-image-file').val('')
            $('.modal-add-product .choose-image-file').attr('data-value', '')
            $('.modal-add-product .image-preview').attr('src', imgDefault)

            $('.modal-add-product .produk-detail .required').val('')
            $('#add-category').val('')

            $('#add-specification-choose-file input').val('')
            $('#add-specification').attr('data-value', '')
            $('#add-specification').val('')

            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
            getProduct()
        })
    })

    $('#modalAddProduct').on('hide.bs.modal', function () {
        $('.modal-add-product .choose-image-file').val('')
        $('.modal-add-product .choose-image-file').attr('data-value', '')
        $('.modal-add-product .image-preview').attr('src', imgDefault)

        $('.modal-add-product .produk-detail .required').val('')
        $('#add-category').val('')

        $('#add-specification-choose-file input').val('')
        $('#add-specification').attr('data-value', '')
        $('#add-specification').val('')
    })

    $('.modal-update-product .choose-image-file').on('change', function () {
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
                }
            } else if (result == "invalid") {
                alert(`Image resolution doesn't match`)
            }
        })
    })

    $('.modal-update-product .produk-detail .required').on('input', function () {
        updateProductValidate()
    })

    $('#modalUpdateProduct').on('show.bs.modal', function () {
        $('.modal-update-product .choose-image-file').attr('data-value', '')
    })

    $('#update-popular-product').on('change', function () {
        if ($(this).is(':checked')) {
            $('#update-popular-product-notice').fadeIn(300)
        } else {
            $('#update-popular-product-notice').fadeOut(300)
        }
    })

    $('#update-specification-choose-file').on('click', function () {
        $('#update-specification').click()
    })

    $('#update-specification').on('change', function () {
        const file = this.files[0]

        if (file) {
            const filename = file.name

            const fileReader = new FileReader()
            fileReader.readAsDataURL(file)
            fileReader.onload = function () {
                const res = fileReader.result
                $('#update-specification').attr('data-filename', filename.replaceAll(' ', '-').replace(/\.[^/.]+$/, ""))
                $('#update-specification').attr('data-value', res)
                $('#update-specification-choose-file input').val(filename)
            }
        }
    })

    $('#btn-update-product').on('click', function () {
        let isPopular = false
        if ($('#update-popular-product').is(':checked')) {
            isPopular = true
        }

        let params = {
            "id": $('#update-id').val(),
            "name": $('#update-name').val(),
            "category": $('#update-category').val(),
            "description": $('#update-description').val(),
            "image_1": $('#update-image-1').attr('data-value'),
            "specification": $('#update-specification').attr('data-value') ? {
                content: $('#update-specification').attr('data-value'),
                filename: $('#update-specification').attr('data-filename')
            } : ''
        }

        $('#btn-update-product').attr('disabled', true)

        ajaxRequest.post({
            "url": "/product/update",
            "data": params
        }).then(function (result) {
            $('#modalUpdateProduct').modal('hide')

            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
            getProduct()
        })
    })

    $('#btn-delete-product').on('click', function () {
        $('#btn-delete-product').attr('disabled', true)

        let params = {
            "id": $('#delete-product-id').val(),
            "name": $('#delete-product-name').val()
        }

        ajaxRequest.post({
            "url": "/product/delete",
            "data": params
        }).then(function (result) {
            $('#modalDeleteProduct').modal('hide')
            $('#btn-delete-product').removeAttr('disabled')

            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
            getProduct()
        })
    })

    $('#btn-update-description').on('click', function () {
        if ($('#category-description').val().replaceAll(' ', '').length === 0) {
            return alert('Please enter description')
        }

        $('#btn-update-description').attr('disabled', true)

        const data = {
            description: $('#category-description').val(),
            displayed: $('#show-description').is(':checked')
        }

        ajaxRequest.post({
            url: 'product/kategori/description/update',
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
            url: 'product/kategori/description/display',
            data: data
        })
    })

    $('.choose-image-category').on('click', function () {
        let parent = $(this).parent()
        parent.children('.choose-image-file-category').click()
    })

    $('#modalAddKategori .choose-image-file-category').on('change', function () {
        let thisEl = $(this)
        let parent = $(this).parent()
        let file = this.files[0]
        displayPreview(file, 525, 700).then(function (result) {
            if (result == "valid") {
                let fileReader = new FileReader()
                fileReader.readAsDataURL(file)
                fileReader.onload = function () {
                    let result = fileReader.result
                    parent.children('.image-preview').attr('src', result)
                    thisEl.attr('data-value', result)
                }
            } else if (result == "invalid") {
                alert(`Image resolution doesn't match`)
                thisEl.attr('data-value', '')
                thisEl.val('')
                parent.children('.image-preview').attr('src', imgDefault)
            }
        })
    })

    $('.choose-image-update-category').on('click', function () {
        let parent = $(this).parent()
        parent.children('.choose-image-update-file-category').click()
    })

    $('#modalUpdateKategori .choose-image-update-file-category').on('change', function () {
        let thisEl = $(this)
        let parent = $(this).parent()
        let file = this.files[0]
        displayPreview(file, 525, 700).then(function (result) {
            if (result == "valid") {
                let fileReader = new FileReader()
                fileReader.readAsDataURL(file)
                fileReader.onload = function () {
                    let result = fileReader.result
                    parent.children('.image-preview').attr('src', result)
                    thisEl.attr('data-value', result)
                }
            } else if (result == "invalid") {
                alert(`Image resolution doesn't match`)
                thisEl.attr('data-value', '')
                thisEl.val('')
                parent.children('.image-preview').attr('src', `${base_url}/assets/images/${$('#current-category-image').val()}`)
            }
        })
    })
})

// =========================================

function getKategori() {
    $('.panel-loader').show()

    ajaxRequest.get({
        "url": "/product/kategori/get"
    }).then(function (result) {
        if (result.description) {
            $('#category-description').val(result.description.description)
            if (result.description.displayed) {
                $('#show-description').attr('checked', true)
            } else {
                $('#show-description').attr('checked', false)
            }
        } else {
            $('#category-description').val('')
            $('#show-description').removeAttr('checked')
        }

        let dataKategori = ``
        let selectKategori = `<option></option>`

        $.each(result.data, function (i, v) {
            dataKategori = dataKategori + `<div class="category-data">
                                                <img class="category-data-image" src="${base_url}/assets/images/${v.image}">
                                                <div class="category-data-overlay">
                                                    <span class="category-data-name">${v.name}</span>
                                                </div>
                                                <div class="category-data-tools">
                                                    <i
                                                        class="far fa-pen edit-category"
                                                        data-toggle="modal"
                                                        data-target="#modalUpdateKategori"
                                                        data-id="${v.id}"
                                                        data-name="${v.name}"
                                                        data-image="${v.image}"
                                                    ></i>
                                                    <i
                                                        class="far fa-trash-alt delete-category"
                                                        data-toggle="modal"
                                                        data-target="#modalDeleteKategori"
                                                        data-id="${v.id}"
                                                        data-name="${v.name}"
                                                    ></i>
                                                </div>
                                            </div>`

            selectKategori = selectKategori + `<option value="${v.id}">${v.name}</option>`
        })

        $('#add-category').html(selectKategori)
        $('#update-category').html(selectKategori)

        $('#kategori-data').empty()
        $('#kategori-data').html(dataKategori)

        $('.edit-category').unbind('click')
        $('.edit-category').on('click', function () {
            $('#update-kategori-name').val($(this).data('name'))
            $('#update-kategori-id').val($(this).data('id'))

            $('#modalUpdateKategori #current-category-image').val($(this).data('image'))
            $('#modalUpdateKategori .choose-image-update-file-category').val('')
            $('#modalUpdateKategori .choose-image-update-file-category').attr('data-value', '')
            $('#modalUpdateKategori #update-category-image-preview').attr('src', `${base_url}/assets/images/${$(this).data('image')}`)
        })

        $('.delete-category').unbind('click')
        $('.delete-category').on('click', function () {
            $('#delete-warning-message').html(`Delete category ${$(this).data('name')} ?`)
            $('#delete-kategori-id').val($(this).data('id'))
            $('#delete-kategori-name').val($(this).data('name'))
            setTimeout(() => {
                $('#update-kategori-name').focus()
            }, 500);
        })
    })
}

function getProduct() {
    $('.panel-loader').show()

    ajaxRequest.get({
        "url": "/product/get"
    }).then(function (result) {

        if (result.data.length > 0) {
            let productCard = ``

            $.each(result.data, function (i, v) {
                let productOrder = ``
                for (let i = 1; i <= result.data.length; i++) {
                    if (i == v.product_order) {
                        productOrder = productOrder + `<option value="${i}" selected>${i}</option>`
                    } else {
                        productOrder = productOrder + `<option value="${i}">${i}</option>`
                    }
                }

                productCard = productCard + `<div class="product">
                                                <img src="${base_url}/assets/images/${v.image[0].filename}" alt="" class="product-img">
                                                <div class="product-detail">
                                                    <p class="product-name">${v.name}</p>
                                                    <div class="product-tools">
                                                        <i class="far fa-pen edit-product" data-toggle="modal" data-target="#modalUpdateProduct"
                                                            data-firstimage="${v.image[0].filename}"
                                                            data-id="${v.id}"
                                                            data-name="${v.name}"
                                                            data-category="${(v.category != null) ? v.category.id : ''}"
                                                            data-description="${v.description}"
                                                            data-specification="${v.specification}"></i>
                                                        <i class="far fa-trash-alt delete-product" data-toggle="modal" data-target="#modalDeleteProduct"
                                                            data-id="${v.id}"
                                                            data-name="${v.name}"></i>
                                                        <select class="form-control product-order" data-id="${v.id}">
                                                            ${productOrder}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>`
            })

            $('#product-data').html(productCard)

            $('.edit-product').unbind('click')
            $('.edit-product').on('click', function () {
                $('#btn-update-product').removeAttr('disabled')

                let thisEl = $(this)
                $('#update-image-1').parent().children('.image-preview').attr('src', `${base_url}/assets/images/${thisEl.data('firstimage')}`)
                $('#update-image-1').attr('data-value', '')
                // $('#update-image-2').parent().children('.image-preview').attr('src', `${base_url}/assets/images/${thisEl.data('secondimage')}`)
                // $('#update-image-2').attr('data-value', '')
                // $('#update-image-3').parent().children('.image-preview').attr('src', `${base_url}/assets/images/${thisEl.data('thirdimage')}`)
                // $('#update-image-3').attr('data-value', '')

                $('#update-id').val(thisEl.data('id'))
                $('#update-name').val(thisEl.data('name'))
                $('#update-category').val(thisEl.data('category'))
                $('#update-description').val(thisEl.data('description'))
                $('#update-specification-choose-file input').val(thisEl.data('specification') ? thisEl.data('specification') : '')
                $('#update-specification').attr('data-filename', '')
                $('#update-specification').attr('data-value', '')

                if (thisEl.data('specification')) {
                    $('#update-specification-download').on('click', function () {
                        window.open(`${base_url}/assets/files/${thisEl.data('specification')}`)
                    })
                    $('#update-specification-download').show()
                } else {
                    $('#update-specification-download').unbind('click')
                    $('#update-specification-download').hide()
                }
            })

            $('.delete-product').unbind('click')
            $('.delete-product').on('click', function () {
                let thisEl = $(this)

                $('#delete-product-id').val(thisEl.data('id'))
                $('#delete-product-name').val(thisEl.data('name'))

                $('#delete-product-warning-message').html(`Delete product ${thisEl.data('name')} ?`)
            })

            $('.product-order').unbind('change')
            $('.product-order').on('change', function () {
                $('.panel-loader').show()

                let params = {
                    "id": $(this).data('id'),
                    "product_order": $(this).val()
                }

                ajaxRequest.post({
                    "url": "/product/switch-order",
                    "data": params
                }).then(result => {
                    getProduct()
                })
            })
        } else {
            $('#product-data').html(`<div class="null-data-wrapper">
                                            <i class="far fa-info-circle"></i> <h4>There's no data</h4>
                                        </div>`)
        }

    })
}

function addProductValidate() {
    let valid = true

    $.each($('.modal-add-product .required'), function (i, v) {
        if ($(this).val().length == 0) {
            valid = false
            return false
        }
    })

    if (valid == true) {
        $('#btn-add-product').removeAttr('disabled')
    } else {
        $('#btn-add-product').attr('disabled', true)
    }
}

function updateProductValidate() {
    let valid = true

    $.each($('.modal-update-product .produk-detail .required'), function (i, v) {
        if ($(this).val().length == 0) {
            valid = false
            return false
        }
    })

    if (valid == true) {
        $('#btn-update-product').removeAttr('disabled')
    } else {
        $('#btn-update-product').attr('disabled', true)
    }
}

// $(document).ajaxStart(function(){
//     $('.panel-loader').show()
// })

$(document).ajaxStop(function () {
    $('.panel-loader').hide()
})

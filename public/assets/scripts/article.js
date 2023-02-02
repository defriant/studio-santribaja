$(window).on('load', function () {
    getArticle()

    let imgDefault = base_url + "/assets/images/grey.jpg"

    $('.choose-image').on('click', function () {
        $(this).parent().children('.choose-image-file').click()
    })

    $('#post-article #article-image').on('change', function () {
        let thisEl = $(this)
        let parent = $(this).parent()
        let file = this.files[0]
        displayPreview(file, 960, 480).then(function (result) {
            if (result == "valid") {
                let fileReader = new FileReader()
                fileReader.readAsDataURL(file)
                fileReader.onload = function () {
                    let result = fileReader.result
                    parent.children('.image-preview').attr('src', result)
                    thisEl.attr('data-value', result)
                    postArticleValidate()
                }
            }
        }).catch(err => {
            alert(err)
            thisEl.attr('data-value', '')
            thisEl.val('')
            parent.children('.image-preview').attr('src', imgDefault)
            postArticleValidate()
        })
    })

    $('#post-article .required').on('input', function () {
        postArticleValidate()
    })

    $('#btn-post-article').on('click', function () {
        $('.panel-loader').show()
        $('#btn-post-article').attr('disabled', true)

        let params = {
            "image": $('#post-article #article-image').attr('data-value'),
            "description": $('#post-article #article-description').val(),
            "source": $('#post-article #article-source').val()
        }

        ajaxRequest.post({
            "url": "/article/add",
            "data": params
        }).then(function (result) {
            $('.panel-loader').show()
            getArticle()
            $('#post-article #article-image-preview').attr('src', imgDefault)
            $('#post-article #article-image').val('')
            $('#post-article #article-image').attr('data-value', '')
            $('#post-article #article-description').val('')
            $('#post-article #article-source').val('')

            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
        })
    })

    $('#edit-article #article-image').on('change', function () {
        let thisEl = $(this)
        let parent = $(this).parent()
        let file = this.files[0]
        displayPreview(file, 960, 480).then(function (result) {
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

    $('#edit-article .required').on('input', function () {
        editArticleValidate()
    })

    $('#btn-edit-article').on('click', function () {
        $('.panel-loader').show()
        $('#btn-edit-article').attr('disabled', true)

        let params = {
            "id": $('#edit-article #article-id').val(),
            "image": $('#edit-article #article-image').attr('data-value'),
            "description": $('#edit-article #article-description').val(),
            "source": $('#edit-article #article-source').val()
        }

        ajaxRequest.post({
            "url": "/article/edit",
            "data": params
        }).then(function (result) {
            $('.panel-loader').show()
            getArticle()
            $('#btn-edit-article').removeAttr('disabled')
            $('#modalUpdate').modal('hide')
            $('#edit-article #article-image').val('')
            $('#edit-article #article-image').attr('data-value', '')

            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
        })
    })

    $('#btn-delete-article').on('click', function () {
        $('#btn-delete-article').attr('disabled', true)

        ajaxRequest.post({
            "url": "/article/delete",
            "data": {
                "id": $('#delete-article #article-id').val()
            }
        }).then(function (result) {
            $('.panel-loader').show()
            getArticle()
            $('#modalDelete').modal('hide')
            $('#btn-delete-article').removeAttr('disabled')

            toastr.option = {
                "timeout": "5000"
            }
            toastr["success"](result.message)
        })
    })

    $('#btn-update-description').on('click', function () {
        if ($('#article-description').val().replaceAll(' ', '').length === 0) {
            return alert('Please enter description')
        }

        $('#btn-update-description').attr('disabled', true)

        const data = {
            description: $('#article-description').val(),
            displayed: $('#show-description').is(':checked')
        }

        ajaxRequest.post({
            url: 'article/description/update',
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
            url: 'article/description/display',
            data: data
        })
    })
})

function getArticle() {
    ajaxRequest.get({
        "url": "/article/get"
    }).then(function (result) {
        if (result.description) {
            $('#article-description').val(result.description.description)
            if (result.description.displayed) {
                $('#show-description').attr('checked', true)
            } else {
                $('#show-description').attr('checked', false)
            }
        } else {
            $('#article-description').val('')
            $('#show-description').removeAttr('checked')
        }

        if (result.data.length > 0) {
            let articleData = ``

            $.each(result.data, function (i, v) {
                articleData = articleData + `<li>
                                                <i class="fa fa-comment activity-icon"></i>
                                                <img src="${base_url}/assets/images/${v.image}" alt="" style="width: 400px; height: 200px">
                                                <p>${v.description}
                                                    <span class="timestamp">Source : <a href="${v.source}" target="_blank">${v.source}</a></span>
                                                </p>
                                                <div class="album-tools">
                                                    <i class="far fa-pen edit-article" data-toggle="modal" data-target="#modalUpdate"
                                                        data-id="${v.id}"
                                                        data-image="${base_url}/assets/images/${v.image}"
                                                        data-description="${v.description}"
                                                        data-source="${v.source}"></i>
                                                    <i class="far fa-trash-alt delete-article" data-id="${v.id}" data-toggle="modal" data-target="#modalDelete"></i>
                                                </div>
                                            </li>`
            })

            $('#article-data').html(articleData)
            articleToolsAction()
        } else {
            $('#article-data').html(`<div class="null-data-wrapper">
                                            <i class="far fa-info-circle"></i> <h4>There's no data</h4>
                                        </div>`)
        }
    })
}

function postArticleValidate() {
    let valid = true

    $.each($('#post-article .required'), function (i, v) {
        if ($(this).val().length == 0) {
            valid = false
            return false
        }
    })

    if (valid == true) {
        $('#btn-post-article').removeAttr('disabled')
    } else {
        $('#btn-post-article').attr('disabled', true)
    }
}

function editArticleValidate() {
    let valid = true

    $.each($('#edit-article .required'), function (i, v) {
        if ($(this).val().length == 0) {
            valid = false
            return false
        }
    })

    if (valid == true) {
        $('#btn-edit-article').removeAttr('disabled')
    } else {
        $('#btn-edit-article').attr('disabled', true)
    }
}

function articleToolsAction() {
    $('.edit-article').on('click', function () {
        let thisEl = $(this)

        $('#edit-article #article-image').val('')
        $('#edit-article #article-image').attr('data-value', '')

        $('#edit-article #article-id').val(thisEl.data('id'))
        $('#edit-article #article-image-preview').attr('src', thisEl.data('image'))
        $('#edit-article #article-description').val(thisEl.data('description'))
        $('#edit-article #article-source').val(thisEl.data('source'))
    })

    $('.delete-article').on('click', function () {
        $('#delete-article #article-id').val($(this).data('id'))
    })
}

$(document).ajaxStop(function () {
    $('.panel-loader').hide()
})
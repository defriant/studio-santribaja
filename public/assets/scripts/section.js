$('.checkbox-switch').on('change', function(){
    let thisEl = $(this)
    if ($(this).is(':checked')) {
        thisEl.parent().find('span').html('Active')
    }else{
        thisEl.parent().find('span').html('Inactive')
    }
})

$(window).on('load', function(){
    getSection()
})

function getSection() {
    ajaxRequest.get({
        "url": "/content-manager/section/get"
    }).then(function(result){
        let sectionData = ``
        $.each(result.data, function(i, v){
            
            let sectionOrder = ``
            for (let i = 1; i <= result.data.length; i++) {
                if (i == v.section_order) {
                    sectionOrder = sectionOrder + `<option value="${i}" selected>${i}</option>`
                }else{
                    sectionOrder = sectionOrder + `<option value="${i}">${i}</option>`
                }
            }

            sectionData = sectionData + `<div class="sections">
                                            <div>
                                                <h4 class="section-title">${v.name}</h4>
                                            </div>
                                            <div class="sections-right">
                                                <div>
                                                    <select class="form-control section_order" data-id="${v.id}">
                                                        ${sectionOrder}
                                                    </select>
                                                </div>
                                                <div style="width: 105px">
                                                    <div class="checkbox-switch-wrapper">
                                                        <input type="checkbox" class="checkbox-switch section_status" data-id="${v.id}" ${(v.status == "active") ? "checked" : ""}>
                                                        <span class="checkbox-switch-text">${(v.status == "active") ? "Active" : "Inactive"}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`
        })

        $('#section-data').empty()
        $('#section-data').html(sectionData)

        $('.section_order').on('change', function(){
            $('.panel-loader').show()

            let params = {
                "id": $(this).data('id'),
                "section_order": $(this).val()
            }
            
            ajaxRequest.post({
                "url": "/content-manager/section/switch-order",
                "data": params
            }).then(function(result){
                $('.panel-loader').show()
                getSection()
            })
        })

        $('.section_status').on('change', function(){
            let status

            if ($(this).is(':checked')) {
                $(this).parent().find('.checkbox-switch-text').html('Active')
                status = "active"
            }else{
                $(this).parent().find('.checkbox-switch-text').html('Inactive')
                status = "inactive"
            }

            let params = {
                "id": $(this).data('id'),
                "status": status
            }

            ajaxRequest.post({
                "url": "/content-manager/section/status",
                "data": params
            })
        })
    })
}

$(document).ajaxStop(function(){
    $('.panel-loader').hide()
})
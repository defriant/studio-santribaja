let todayChart
let yearChart
let _year = new Date().getFullYear()
let countryVisitingRowActive

$(window).on('load', function () {
    todayVisitor()
    yearlyVisitor(_year)
    setInterval(() => {
        visitorUpdate()
    }, 60000);
})

function todayVisitor() {
    ajaxRequest.get({
        "url": "/dashboard/visitor/today/chart"
    }).then(result => {
        $('#today-visitor-date').html(result.date)

        let labels = []
        let dataset = []
        let avgDataset = []
        let dailyHighest = 0
        let avgHighest = 0

        $.each(result.todayChart, function (i, v) {
            labels.push(`${v.from} - ${v.to}`)

            if (v.from > `${new Date().getHours()}:00`) {
                dataset.push(null)
            } else {
                dataset.push(v.total)
            }

            avgDataset.push(v.average)
            if (v.total > dailyHighest) {
                dailyHighest = v.total
            }

            if (v.average > avgHighest) {
                avgHighest = v.average
            }
        })

        let highest

        if (dailyHighest > avgHighest) {
            highest = dailyHighest
        } else {
            highest = avgHighest
        }

        let ctx = document.getElementById("today-visitor-chart").getContext('2d')
        todayChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Today',
                        data: dataset,
                        borderColor: `hsla(${hueColor}, 100%, 50%, .75)`,
                        backgroundColor: `hsla(${hueColor}, 100%, 50%, .75)`
                    },
                    {
                        label: 'Average',
                        data: avgDataset,
                        borderColor: `hsla(0, 100%, 50%, .1)`,
                        backgroundColor: `hsla(0, 100%, 50%, .1)`
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        suggestedMin: 0,
                        suggestedMax: highest + (highest / 4)
                    }
                }
            }
        });

        $('#today-visits').html(result.todayVisits)
        $('#average-daily-visits').html(result.averageDaily)

        $('.loader-today-visitor').hide()
    })
}

function todayVisitorUpdate() {
    ajaxRequest.get({
        "url": "/dashboard/visitor/today/chart"
    }).then(result => {
        let dataset = []
        let avgDataset = []
        let dailyHighest = 0
        let avgHighest = 0

        $.each(result.todayChart, function (i, v) {
            if (v.from > `${new Date().getHours()}:00`) {
                dataset.push(null)
            } else {
                dataset.push(v.total)
            }

            avgDataset.push(v.average)
            if (v.total > dailyHighest) {
                dailyHighest = v.total
            }

            if (v.average > avgHighest) {
                avgHighest = v.average
            }
        })

        let highest

        if (dailyHighest > avgHighest) {
            highest = dailyHighest
        } else {
            highest = avgHighest
        }

        todayChart.data.datasets[0].data = dataset
        todayChart.data.datasets[1].data = avgDataset
        todayChart.options.scales.y.suggestedMax = highest + (highest / 4)
        todayChart.update()

        $('#today-visits').html(result.todayVisits)
        $('#average-daily-visits').html(result.averageDaily)
    })
}

function yearlyVisitor(year) {
    ajaxRequest.post({
        "url": "/dashboard/visitor/yearly/chart",
        "data": {
            "year": year
        }
    }).then(result => {
        let yearsData = ``
        $.each(result.years, function (i, v) {
            yearsData = yearsData + `<option value="${v}" ${(v == year) ? "selected" : ""}>${v}</option>`
        })

        $('#select-year').html(yearsData)

        let labels = []
        let dataset = []
        let highest = 0

        $.each(result.yearlyChart, function (i, v) {
            labels.push(v.month_text)
            dataset.push(v.total)

            if (v.total > highest) {
                highest = v.total
            }
        })

        let ctx = document.getElementById("years-visitor-chart").getContext('2d')
        yearChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Visitor',
                        data: dataset,
                        borderColor: ['#ff8080', '#ffe680', '#95ff80', '#80ffee', '#80d4ff', '#9580ff', '#f280ff'],
                        backgroundColor: ['#ff8080', '#ffe680', '#95ff80', '#80ffee', '#80d4ff', '#9580ff', '#f280ff']
                    }
                ]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        suggestedMin: 0,
                        suggestedMax: highest + (highest / 4)
                    }
                }
            }
        });

        $('#country-visiting').html(`Countries Visiting in ${year}`)
        let countryVisitingData = ``
        $.each(result.countries, function (i, v) {
            countryVisitingData = countryVisitingData + `<tr data-country="${v.country}">
                                                            <td>${v.iso}</td>
                                                            <td>${v.country}</td>
                                                            <td>${v.number_visit}</td>
                                                        </tr>`
        })
        $('#country-visiting-data').html(countryVisitingData)
        countryDetail()
        $('.loader-yearly-visitor').hide()

        // setInterval(() => {
        //     yearlyVisitorUpdate(_year)
        // }, 30000);
    })
}

function yearlyVisitorUpdate(year) {
    ajaxRequest.post({
        "url": "/dashboard/visitor/yearly/chart",
        "data": {
            "year": year
        }
    }).then(result => {
        let dataset = []
        let highest = 0

        $.each(result.yearlyChart, function (i, v) {
            dataset.push(v.total)

            if (v.total > highest) {
                highest = v.total
            }
        })

        yearChart.data.datasets[0].data = dataset
        yearChart.options.scales.y.suggestedMax = highest + (highest / 4)
        yearChart.update()

        $('#country-visiting').html(`Countries Visiting in ${year}`)
        let countryVisitingData = ``
        $.each(result.countries, function (i, v) {
            countryVisitingData = countryVisitingData + `<tr data-country="${v.country}" class="${(countryVisitingRowActive == v.country) ? 'row-active' : ''}">
                                                            <td>${v.iso}</td>
                                                            <td>${v.country}</td>
                                                            <td>${v.number_visit}</td>
                                                        </tr>`
        })
        $('#country-visiting-data').html(countryVisitingData)
        countryDetail()
        $('.loader-yearly-visitor').hide()
    })
}

function visitorUpdate() {
    ajaxRequest.post({
        "url": "api/dashboard/visitor/eb6FX5KN6URhSafTY6kp7TYwkk2365/update",
        "data": {
            "year": _year
        }
    }).then(result => {
        $('#today-visitor-date').html(result.date)

        let todayDataset = []
        let avgDataset = []
        let dailyHighest = 0
        let avgHighest = 0

        $.each(result.todayChart, function (i, v) {
            if (v.from > `${new Date().getHours()}:00`) {
                todayDataset.push(null)
            } else {
                todayDataset.push(v.total)
            }

            avgDataset.push(v.average)
            if (v.total > dailyHighest) {
                dailyHighest = v.total
            }

            if (v.average > avgHighest) {
                avgHighest = v.average
            }
        })

        let todayHighest

        if (dailyHighest > avgHighest) {
            todayHighest = dailyHighest
        } else {
            todayHighest = avgHighest
        }

        todayChart.data.datasets[0].data = todayDataset
        todayChart.data.datasets[1].data = avgDataset
        todayChart.options.scales.y.suggestedMax = todayHighest + (todayHighest / 4)
        todayChart.update()

        $('#today-visits').html(result.todayVisits)
        $('#average-daily-visits').html(result.averageDaily)

        let yearlyDataset = []
        let yearlyHighest = 0

        $.each(result.yearlyChart, function (i, v) {
            yearlyDataset.push(v.total)

            if (v.total > yearlyHighest) {
                yearlyHighest = v.total
            }
        })

        yearChart.data.datasets[0].data = yearlyDataset
        yearChart.options.scales.y.suggestedMax = yearlyHighest + (yearlyHighest / 4)
        yearChart.update()

        let countryVisitingData = ``
        $.each(result.countries, function (i, v) {
            countryVisitingData = countryVisitingData + `<tr data-country="${v.country}" class="${(countryVisitingRowActive == v.country) ? 'row-active' : ''}">
                                                            <td>${v.iso}</td>
                                                            <td>${v.country}</td>
                                                            <td>${v.number_visit}</td>
                                                        </tr>`
        })
        $('#country-visiting-data').html(countryVisitingData)

        countryDetail()
    })
}

$('#select-year').on('change', function () {
    _year = $(this).val()
    $('#country-visiting-data tr').removeClass('row-active')
    $('#yearly-by-country').html(`<div class="null-data-wrapper">
                                        <i class="far fa-info-circle"></i> <h4>Select country to view visitors</h4>
                                    </div>`)
    $('#yearly-by-country-title').hide()
    $('.loader-yearly-visitor').show()
    yearlyVisitorUpdate(_year)
})

function countryDetail() {
    $('#country-visiting-data tr').unbind('click')
    $('#country-visiting-data tr').on('click', function () {
        countryVisitingRowActive = $(this).data('country')
        $('#country-visiting-data tr').removeClass('row-active')
        $(this).addClass('row-active')
        $('#yearly-by-country-title').html($(this).data('country'))
        $('#yearly-by-country-loader').show()
        ajaxRequest.post({
            "url": "/dashboard/visitor/yearly/by-country",
            "data": {
                "country": $(this).data('country'),
                "year": _year
            }
        }).then(result => {
            let yearlyByCountryData = ``

            $.each(result.data, function (i, v) {
                yearlyByCountryData = yearlyByCountryData + `<tr>
                                                                <td>${v.state}</td>
                                                                <td>${v.city}</td>
                                                                <td>${v.number_visit}</td>
                                                            </tr>`
            })

            $('#yearly-by-country').html(`<table class="table">
                                            <thead>
                                                <tr>
                                                    <th>State</th>
                                                    <th>City</th>
                                                    <th>Number of Visits</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                ${yearlyByCountryData}
                                            </tbody>
                                        </table>`)

            $('#yearly-by-country-loader').hide()
        })
    })
}

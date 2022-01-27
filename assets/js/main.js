function date() {
    fyear = new Date().getYear();
    year = fyear < 1900 ? (fyear += 1900) : fyear;
    buildyear = 2021;
    return year > buildyear ?
        "&copy " + buildyear + " - " + year :
        "&copy " + buildyear;
}

function confPie(one, two, three, four, five, questionid) {
    var ctx = document.getElementById('myChart-' + questionid).getContext('2d');
    var all = (one + two + three + four + five);

    new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: [{
                data: [Math.round((one / all * 100)),
                Math.round((two / all * 100)),
                Math.round((three / all * 100)),
                Math.round((four / all * 100)),
                Math.round((five / all * 100))
                ],
                backgroundColor: ['#FB3640', '#EFCA08', '#43AA8B', '#253D5B', '#A129FA'],
            }],
            labels: ['1x⭐', '2x⭐', '3x⭐', '4x⭐', '5x⭐'],
        },
        options: {
            responsive: true,
            legend: {
                position: 'bottom'
            },
            plugins: {
                datalabels: {
                    color: '#fff',
                    anchor: 'end',
                    align: 'start',
                    offset: -10,
                    borderWidth: 1,
                    borderColor: '#fff',
                    borderRadius: 25,
                    backgroundColor: (context) => {
                        return context.dataset.backgroundColor;
                    },
                    font: {
                        weight: 'bold',
                        size: '10'
                    },
                    formatter: (value) => {
                        return value + ' %';
                    }
                },
            }
        }
    })
}
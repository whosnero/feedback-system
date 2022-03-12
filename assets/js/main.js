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
            labels: ['1x⭐', '2x⭐', '3x⭐', '4x⭐', '5x⭐'], 
            datasets: [{
                data: [Math.round((one / all * 100)),
                Math.round((two / all * 100)),
                Math.round((three / all * 100)),
                Math.round((four / all * 100)),
                Math.round((five / all * 100))
                ],
                backgroundColor: (localStorage.getItem("theme") == "dark-theme") ? ['#1F363D', '#40798C', '#70A9A1', '#9EC1A3', '#CFE0C3'] : ['#DE6B48', '#E5B181', '#F4B9B2', '#DAEDBD', '#8ECED6'],
                borderWidth: 1,
            }],
        },
        options: {
            responsive: true,
                plugins: {
                    datalabels: {
                        color: '#fff',
                        anchor: 'end',
                        align: 'start',
                        offset: -10,
                        borderWidth: 0,
                        borderColor: '#fff',
                        borderRadius: 25,
                        backgroundColor: (context) => {
                            return context.dataset.backgroundColor;
                        },
                        font: {
                            weight: 'bold',
                            size: '10',
                        },
                        formatter: (value) => {
                            return value + ' %';
                        }
                    },
                legend: {
                    position: 'top',
                        labels: {
                            color: 'white',
                            borderWidth: 0,
                            font: {
                                weight: 'bold',
                                size: '10',
                            }   
                        },
                }
            }
        }
    })
}
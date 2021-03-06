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
                backgroundColor: (localStorage.getItem("theme") == "light-theme") ? ['#F4B9B2', '#E5B181', '#DE6B48', '#A4486F', '#7A4EB0'] : ['#CFE0C3', '#9EC1A3', '#70A9A1', '#40798C', '#1F363D'],
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

function copyNotificationCode() {
    var range = document.createRange();
    range.selectNode(document.getElementById("notification-code"));
    window.getSelection().removeAllRanges(); // clear current selection
    window.getSelection().addRange(range); // to select text
    document.execCommand("copy");

    const tooltip = document.querySelector(".tooltip");
    tooltip.classList.add("show");
    setTimeout(function () {
        tooltip.classList.remove("show");
    }, 800);

    window.getSelection().removeAllRanges(); // to deselect
}

function themeSetter(classlist) {
    let localData = localStorage.getItem("theme");

    if (localData == "light-theme") {
        classlist.add("light-theme");
        document.getElementById("theme-icon").classList.remove("fa-sun");
        document.getElementById("theme-icon").classList.add("fa-moon");
    } else if (localData == "dark") {
        classlist.remove("light-theme");
    } else {
        localStorage.setItem("theme", "dark");
    }
}
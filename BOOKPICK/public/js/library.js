// 파이차트
document.addEventListener("DOMContentLoaded", function() {
	var canvas = document.getElementById('myPieChart');
	var ctx = canvas.getContext('2d');

	var piChartList0 = document.getElementById('pichartlist0');
	var piChartList1 = document.getElementById('pichartlist1');
	var piChartList2 = document.getElementById('pichartlist2');
	var piChartList3 = document.getElementById('pichartlist3');
	var piChartList4 = document.getElementById('pichartlist4');

	var intValue0 = parseInt(piChartList0.getAttribute('data-value'), 10);
	var intValue1 = parseInt(piChartList1.getAttribute('data-value'), 10);
	var intValue2 = parseInt(piChartList2.getAttribute('data-value'), 10);
	var intValue3 = parseInt(piChartList3.getAttribute('data-value'), 10);
	var intValue4 = parseInt(piChartList4.getAttribute('data-value'), 10);

	if(intValue0 === 0 && intValue1 === 0 && intValue2 === 0 && intValue3 === 0 && intValue4 === 0) {
		intValue0 = 100;
	}
	var data = [intValue0,intValue1,intValue2,intValue3,intValue4];
	var colors = ['#4a5759', '#b0c4b1', '#dedbd2','#f7e1d7','#edafb8'];

	var total = data.reduce(function(acc, value) {
		return acc + value;
	}, 0);

	var startAngle = 0;
	var endAngle;

	for (var i = 0; i < data.length; i++) {
		endAngle = startAngle + (data[i] / total) * (2 * Math.PI);

		ctx.beginPath();
		ctx.moveTo(canvas.width / 2, canvas.height / 2);
		ctx.arc(canvas.width / 2, canvas.height / 2, canvas.width / 3, startAngle, endAngle);
		ctx.fillStyle = colors[i];
		ctx.fill();

		startAngle = endAngle;
	}
});


// 막대차트
var currentDate = new Date();
var currentMonth = currentDate.getMonth();
if (currentMonth === 0) {
	var oneMonthAgo = 11;
	var twoMonthsAgo = 10;
} else if (currentMonth === 1) {
	var twoMonthsAgo = 11;
	var oneMonthAgo = currentDate.getMonth() - 1;
} else {
    var twoMonthsAgo = currentDate.getMonth() - 2;
	var oneMonthAgo = currentDate.getMonth() - 1;
}

var chartData1Element = document.getElementById('chartData1');
var chartData2Element = document.getElementById('chartData2');
var chartData3Element = document.getElementById('chartData3');
var chartData1Value = chartData1Element.getAttribute('data-hidden-data');
var chartData2Value = chartData2Element.getAttribute('data-hidden-data');
var chartData3Value = chartData3Element.getAttribute('data-hidden-data');
var ctx = document.getElementById('myChart').getContext('2d');

var data = new Chart(ctx, {
    type: 'bar',
    data: {
		labels: [twoMonthsAgo+1+"월", oneMonthAgo+1+"월", currentMonth+1+"월"],
		datasets: [
			{
				label: '기록현황',
				borderColor: 
					[
						'#74c69d',
						'#95d5b2',
						'#d8f3dc'
					],
				backgroundColor:
					[
						'#74c69d',
						'#95d5b2',
						'#d8f3dc'
					],
				borderWidth: 2,
				data: [chartData1Value, chartData2Value, chartData3Value],
			},
		],
		},
    options: {
        legend: {
            display: false  // 범례를 표시하지 않음
        },
		scales : {
			yAxes : [ {
				ticks : {
					beginAtZero : true, // 0부터 시작하게 합니다.
                	stepSize: 5, // y축 간격 설정
				}
			} ]
		}
    }
});

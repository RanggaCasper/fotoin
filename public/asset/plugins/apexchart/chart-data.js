'use strict';

$(document).ready(function() {

	function generateData(baseval, count, yrange) {
		var i = 0;
		var series = [];
		while (i < count) {
			var x = Math.floor(Math.random() * (750 - 1 + 1)) + 1;;
			var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
			var z = Math.floor(Math.random() * (75 - 15 + 1)) + 15;

			series.push([x, y, z]);
			baseval += 86400000;
			i++;
		}
		return series;
	}

  if($('#purchase-chart').length > 0 ){
    var options = {
      series: [{
        name: "Purchase",
        colors: ['#FF6900'],
        data: [{
          x: 'jan',
          y: 7.0,              
            }, {
              x: 'Feb',
              y: 4.0
            }, {
              x: 'Mar',
              y: 3.0
            }, {
              x: 'Apr',
              y: 3.7
            }, {
              x: 'May',
              y: 6.0
            },{
              x: 'Jun',
              y: 2.0
            },{
              x: 'Jul',
              y: 6.5
            },{
              x: 'Aug',
              y: 2.0
            },{
              x: 'Sep',
              y: 3.0
            },{
              x: 'Oct',
              y: 2.0
            },{
              x: 'Nov',
              y: 5.0
            },{
              x: 'Dec',
              y: 7.0
            }]
          }],
            chart: {
            type: 'bar',
            height: 250,            
            toolbar: {
              show: false,
            }
          },
          dataLabels: {
            enabled: false
          },
          plotOptions: {
            bar: {
                columnWidth: '20%',
                borderRadius: 0,
                endingShape: 'rounded'
            }
          },
          colors: ['#FF6900'],
          
          };    
          var chart = new ApexCharts(document.querySelector("#purchase-chart"), options);
          chart.render();
    }	

    if($('#amount-chart').length > 0 ){
    var options = {
      series: [{
        name: "Sales",
        colors: ['#FF6900'],
        data: [{
          x: 'jan',
          y: 7.0,              
            }, {
              x: 'Feb',
              y: 7.0
            }, {
              x: 'Mar',
              y: 3.0
            }, {
              x: 'Apr',
              y: 8.7
            }, {
              x: 'May',
              y: 7.0
            },{
              x: 'Jun',
              y: 2.0
            },{
              x: 'Jul',
              y: 7.5
            },{
              x: 'Aug',
              y: 2.0
            },{
              x: 'Sep',
              y: 3.0
            },{
              x: 'Oct',
              y: 2.0
            },{
              x: 'Nov',
              y: 5.0
            },{
              x: 'Dec',
              y: 7.0
            }]
          }],
            chart: {
            type: 'bar',
            height: 250,            
            toolbar: {
              show: false,
            }
          },
          dataLabels: {
            enabled: false
          },
          plotOptions: {
            bar: {
                columnWidth: '20%',
                borderRadius: 0,
                endingShape: 'rounded'
            }
          },
          colors: ['#FF6900'],
          
          };    
          var chart = new ApexCharts(document.querySelector("#amount-chart"), options);
          chart.render();
    } 

  
});
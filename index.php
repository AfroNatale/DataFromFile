<?php 
	require_once('analizedata.php');
	$analyze = new AnalizeData();
?>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="utf-8">
        <title>Zadania</title>
		<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/highcharts-more.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		
		<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

</style>
    </head>
    <body> 
	<?php $analyze->printResults(); ?>
	
	<div id="container1" style="min-width: 310px; height: 400px; max-width: 800px; margin: 0 auto"></div>
	
	<div id="container2" style="height: 400px; margin: auto; min-width: 310px; max-width: 600px"></div>

<script type="text/javascript">	
Highcharts.chart('container1', {
    chart: {
        type: 'scatter',
        zoomType: 'xy'
    },
    title: {
        text: 'Porównanie wag i wzrostów'
    },
    xAxis: {
        title: {
            enabled: true,
            text: 'Wzrosty (cm)'
        },
        startOnTick: true,
        endOnTick: true,
        showLastLabel: true
    },
    yAxis: {
        title: {
            text: 'wagi (kg)'
        }
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        verticalAlign: 'top',
        x: 100,
        y: 70,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF',
        borderWidth: 1
    },
    plotOptions: {
        scatter: {
            marker: {
                radius: 5,
                states: {
                    hover: {
                        enabled: true,
                        lineColor: 'rgb(100,100,100)'
                    }
                }
            },
            states: {
                hover: {
                    marker: {
                        enabled: false
                    }
                }
            },
            tooltip: {
                pointFormat: '{point.x} kg, {point.y} cm',
				headerFormat: '<b>{series.name}</b><br/>'
            }
        }
    },
    series: [{
		name: 'Seria danych',
        data: [
		
		 <?php echo $analyze->getJsData(); ?>
		 ]
    }]
});
</script>

<script type="text/javascript">
	Highcharts.chart('container2', {

    chart: {
        type: 'boxplot'
    },

    title: {
        text: 'Wykres Box-plot'
    },

    legend: {
        enabled: false
    },

    xAxis: {
        categories: ['Wagi', 'Wzrosty'],
    },

    yAxis: {
        title: {
            text: 'Wartości'
        },
    },

    series: [{
        name: 'Wyniki',
        data: [
            <?php $analyze->printChartValues(); ?>
        ],
        marker: {
            fillColor: 'white',
            lineWidth: 1,
            lineColor: Highcharts.getOptions().colors[0]
        },
        tooltip: {
            headerFormat: '<em>{point.key}</em><br/>'
        }
    }]

});
</script>

    </body>
</html>

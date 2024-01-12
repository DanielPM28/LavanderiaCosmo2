const chart = Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Desempeño Conductores',
        
    },
    
    xAxis: {
        categories: [],
        crosshair: true
       
    },
    yAxis: {
        
        title: {
            useHTML: true,
            text: 'Reservas atendidas'
        }
    },
    
    series: []
});

let $start, $end;


function fetchData(){
    const startDate = $start.val();
    const endDate = $end.val();
    const url = `/reportes/conductores/column/data?start=${startDate}&end=${endDate}`;
    //Fetch Api
    fetch(url)
    .then(function(response){
        return response.json();
    })
    .then(function(myJson){
        //console.log(myJson);
        chart.xAxis[0].setCategories(myJson.categories);

        if (chart.series.length > 0) {
            chart.series[1].remove();
            chart.series[0].remove();
        }
       
        chart.addSeries(myJson.series[0]);
        chart.addSeries(myJson.series[1]);
    });
}

$(function(){
     $start = $('#startDate');
     $end = $('#endDate');
     fetchData();

     $start.change(fetchData);
     $end.change(fetchData);
});
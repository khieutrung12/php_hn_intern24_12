$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  
    if($('#select-filter-revenue')){
        loadRevenue();
    }
   
    function loadCanvasRevenue(month,revenue){
        $('#chart_revenue').remove();
        $('#graph-container').append('<canvas id="chart_revenue"><canvas>');
            var lineChart = $('#chart_revenue');
            var myChartt = new Chart(lineChart, {
                type: 'line',
                data: {
                    labels: month.split(','),
                    datasets: [{
                            label: 'Revenue',
                            data: revenue.split(','),
                            fill: false,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                }
            });
    }

    function loadRevenue(){
        var year = $('#select-filter-revenue').val();
        var url = $('#select-filter-revenue').data('url');
        $.ajax({
            url: url,
            method: "post",
            data: {
                year: year,
            },
            success: function(data) {
                loadCanvasRevenue(data['month'],data['revenue']);
            },
            error: function (error) {
                toastr.error(error);
            },
        });
    }

    $('#select-filter-revenue').change(function() {
        var year = $(this).val();
        var url = $(this).data('url');
        $.ajax({
            url: url,
            method: "post",
            data: {
                year: year,
            },
            success: function(data) {
                loadCanvasRevenue(data['month'],data['revenue']);
            },
            error: function (error) {
                toastr.error(error);
            },
        });

    });
});

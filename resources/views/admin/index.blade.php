@extends('layouts.admin')

@section('content')

    <h3>Admin Dashboard</h3>
    <div class="row">
        <div class="col-sm-6">
            <canvas id="bar-graph"></canvas>
        </div>
        <div class="col-sm-6">
            <canvas id="pie-chart"></canvas>
        </div>
    </div>

@stop

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<script>
    // bar graph
    var ctx = document.getElementById("bar-graph").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Users", "Posts", "Comments", "Categories"],
            datasets: [{
                label: 'Site Analytics',
                data: [{{ $userCount }}, {{ $postCount }}, {{ $commentCount }}, {{ $categoryCount }}],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
    // pie chart
    var ctxpie = document.getElementById('pie-chart').getContext('2d');
    var myPieChart = new Chart(ctxpie,{
        type: 'pie',
        data: {
            labels: ['Users', 'Posts', 'Comments', 'Categories'],
            datasets: [{
                data: [{{ $userCount }}, {{ $postCount }}, {{ $commentCount }}, {{ $categoryCount }}],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                ],
            }],
        },
        options: {}
    });
</script>
@stop
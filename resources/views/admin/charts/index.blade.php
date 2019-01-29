@extends('layouts.admin')

@section('content')
<h1>Charts</h1>

<div id="placeholder" style="width:600px;height:300px"></div>

@stop

@section('scripts')
    <script>
        $(document).ready(function() {
            $.plot($("#placeholder"), [ [[0, 0], [1, 1]] ], { yaxis: { max: 1 } });
        })
    </script>
@stop
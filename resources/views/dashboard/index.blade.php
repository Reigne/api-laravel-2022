@extends('layouts.base')
@section('body')

<div class="container-sm">
    <div class="row mb-2">
        <div class="container-fluid col-md-6">
<div>
    <canvas id="titleChart"></canvas>
</div>
</div>

<div class="col-md-6">
<div>
    <canvas id="salesChart"></canvas>
</div>
</div>
<div class="chart-container" style="position: relative; height:40vh; width:80vw">
    <canvas id="itemsChart"></canvas>
</div>
</div>
</div>
@endsection
@extends('app')

@section('content')

<div class="container">

    <div class="row mt-4">
        @foreach ($metrics as $metric)
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $metric['title'] }}</h5>
                    <h3>{{ $metric['dish'] }}</h3>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-5">
        <h3 class="text-light title-center">Daily Revenue</h3>
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Revenue (Rs)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $key => $sale)
                <tr>
                    <th scope="row">{{ $key+1 }}</th>
                    <td>{{ $sale['date'] }}</td>
                    <td>{{ $sale['revenue'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</div>

@stop
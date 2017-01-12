@extends('template')

@section('title', _('Bought Stocks'))

@section('breadcrumbs')
  <li><a href="/bought-stocks">Bought Stocks</a></li>
@endsection

@section('content')
  {!! $boughtStocks->render() !!}
  <h1>Bought Stocks</h1>
  <table class="box table table-striped">
    <thead>
    <tr>
      <th>Symbol</th>
      <th>Price</th>
      <th>Amount</th>
      <th>Employee</th>
      <th>Client</th>
      <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($boughtStocks as $stock)
      <tr>
        <td>
          <a href="/stocks/{{ $stock->symbol }}">
            {{ $stock->symbol }}
          </a>
        </td>
        <td>{{ $stock->bought }}</td>
        <td>{{ $stock->amount }}</td>
        <td>
          <a href="/users/{{ $stock->employee->id }}">
            {{ $stock->employee->last_name }}
          </a>
        </td>
        <td>
          <a href="/users/{{ $stock->client->id }}">
            {{ $stock->client->last_name }}
          </a>
        </td>
        <td>{{ $stock->created_at->diffForHumans() }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
  {!! $boughtStocks->render() !!}
@endsection
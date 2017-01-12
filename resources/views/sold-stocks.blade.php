@extends('template')

@section('title', _('Sold Stocks'))

@section('breadcrumbs')
  <li><a href="/sold-stocks">Sold Stocks</a></li>
@endsection

@section('content')
  {!! $soldStocks->render() !!}
  <h1>Sold Stocks</h1>
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
    @foreach($soldStocks as $stock)
      <tr>
        <td><a href="/stocks/{{ $stock->symbol }}">
            {{ $stock->symbol }}
          </a>
        </td>
        <td>
          @if ($stock->percentage() > 0)
            <i style="color: {{ $stock->colour() }}"
               class='fa fa-caret-up'></i>
          @else
            <i style="color: {{ $stock->colour() }}"
               class='fa fa-caret-down'></i>
          @endif
          {{ $stock->from }}
          <span style="color: {{ $stock->colour() }}">
            ({{ $stock->percentage() }}%)
          </span>
        </td>
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
  {!! $soldStocks->render() !!}
@endsection
@extends('template')

@section('title', "$user->first_name's Bought Stocks")
@section('breadcrumbs')
  <li><a href="/users">Users</a></li>
  <li><a href="/users/{{  $user->id }}">{{ $user->name() }}</a></li>
  <li><a href="/users/{{  $user->id }}/sold">Bought Stocks</a></li>
@endsection

@section('content')
  {!! $stocks->render() !!}
  @if ($stocks->count())
    <h1>{{ $user->first_name }}'s Bought Stocks</h1>
    <table class="box table table-striped">
      <thead>
      <tr>
        <th>Symbol</th>
        <th>Price</th>
        <th>Amount</th>
        @if ($user->group == "Client")
          <th>Employee</th>
        @else
          <th>Client</th>
        @endif
        <th>Date</th>
      </tr>
      </thead>
      <tbody>
      @foreach($stocks as $stock)
        <tr>
          <td>
            <a href="/stocks/{{ $stock->symbol }}">
              {{ $stock->symbol }}
            </a>
          </td>
          <td>{{ $stock->bought }}</td>
          <td>{{ $stock->amount }}</td>
          <td>
            @if ($user->group == "Client")
              <a href="/users/{{ $stock->employee->id }}">
                {{ $stock->employee->last_name }}
              </a>
            @else
              <a href="/users/{{ $stock->client->id }}">
                {{ $stock->client->last_name }}
              </a>
            @endif
          </td>
          <td>{{ $stock->created_at->diffForHumans() }}</td>
        </tr>
      @endforeach
      </tbody>
    </table>
  @endif
  {!! $stocks->render() !!}
@endsection
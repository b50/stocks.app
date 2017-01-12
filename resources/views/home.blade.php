@extends('template')
@section('content')
  <div class="marquee">&nbsp;</div>
  <div class="row">
    <div class="col-md-7">
      @if (session('message'))
        <div class="alert alert-{{ session('status') }}" role="alert">
          <strong>{{ session('message') }}</strong>
        </div>
      @endif
      @if ($announcements)
        <div class="panel panel-default">
          <div class="panel-heading">
            {{ $announcements[0]->user->name() }}
            <div class="pull-right">
              @if ($authUser->group == "Admin")
                <a href="announcements/create">New</a>
                <a href="announcements/{{ $announcements[0]->id }}/edit">Edit</a>
              @endif
              {{ $announcements[0]->created_at->diffForHumans() }}
              {!! $announcements->render() !!}
            </div>
          </div>
          <div class="panel-body">
            {{ $announcements[0]->content }}
          </div>
        </div>
      @endif
      @if ($eotm)
        <h1>Employee of the month:
          <a href="/users/{{ $eotm->user()->id }}">
            {{ $eotm->user()->name() }}
          </a>
          <div class="right">
            <a href="/edit-eotm">Edit</a>
          </div>
        </h1>
        <div class="box box-down">
          <img src="{{ $eotm->user()->avatar() }}" alt=""
               class="eotm img-responsive img-thumbnail pull-left">
          <p class="clearfix">{{ $eotm->why() }}</p>
        </div>
      @endif
      <h1>News</h1>
      <div class="box box-down">
        <table id="news">
          <tr class="item">
            <td class="link"><a href=""></a></td>
            <td class="date"></td>
          </tr>
          <tr class="item">
            <td class="link"><a href=""></a></td>
            <td class="date"></td>
          </tr>
          <tr class="item">
            <td class="link"><a href=""></a></td>
            <td class="date"></td>
          </tr>
          <tr class="item">
            <td class="link"><a href=""></a></td>
            <td class="date"></td>
          </tr>
          <tr class="item">
            <td class="link"><a href=""></a></td>
            <td class="date"></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="col-md-5">
      <h1>
        Recently Bought Stocks
        <a class="right" href="bought-stocks">All</a>
      </h1>
      <table class="box table table-striped">
        <thead>
        <tr>
          <th>Symbol</th>
          <th>Price</th>
          <th>Amount</th>
          <th>Employee</th>
          <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($stocksBought as $stock)
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
            <td>{{ $stock->created_at->diffForHumans() }}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
      <h1>
        Recently Sold Stocks
        <a class="right" href="sold-stocks">All</a>
      </h1>
      <table class="box table table-striped">
        <thead>
        <tr>
          <th>Symbol</th>
          <th>Price</th>
          <th>Amount</th>
          <th>Employee</th>
          <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($stocksSold as $stock)
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
            <td>{{ $stock->created_at->diffForHumans() }}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
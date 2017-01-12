@extends('template')

@section('title', _($user->name()))
@section('breadcrumbs')
  <li><a href="/users">Users</a></li>
  <li><a href="/users/{{  $user->id }}">{{ $user->name() }}</a></li>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-3">
      <h1>{{ $user->name() }}</h1>
      <div class="box box-down">
        <p>
          <img id="profileAvatar" src="{{ $user->avatar() }}" alt="">
        </p>
      </div>
      <ul class="list-group">
        @if ($user->group == "Client")
          <li class="list-group-item">
            <b>Money</b> £{{ $user->money->value }}
          </li>
        @endif
        <li class="list-group-item">
          <b>{{ $user->group }}
            since</b> {{$user->created_at->format('d M Y') }}
        </li>
        <li class="list-group-item">
          <b>Group </b> {{ $user->group }}
        </li>
        <li class="list-group-item">
          <b class="hr">Email</b>
          {{ $user->email }}
        </li>
        @if ($user->mobile)
          <li class="list-group-item">
            <b>Mobile </b> {{ $user->mobile }}
          </li>
        @endif
        @if ($user->home_phone)
          <li class="list-group-item">
            <b>Home phone </b> {{ $user->home_phone }}
          </li>
        @endif
        @if ($user->work_phone)
          <li class="list-group-item">
            <b>Work phone </b> {{ $user->work_phone }}
          </li>
        @endif
      </ul>

      @if (in_array($user->group, ['Admin', 'Employee'])
        and $user->favoriteStocks->count())
        <h1>Favorite Stocks</h1>
        <ul class="list-group">
          @foreach($user->favoriteStocks as $stock)
            <li class="list-group-item">
              <a href="/stocks/{{ $stock->symbol }}">{{ $stock->symbol }} </a>
            </li>
          @endforeach
        </ul>
      @endif

      @if (in_array($authUser->group, ['Admin', 'Employee'])
        and in_array($user->group, ['Admin', 'Employee'])
        and $user->clients->count())
        <h1>Clients</h1>
        <ul class="list-group">
          @foreach ($user->clients as $client)
            <li class="list-group-item">
              <a href="/users/{{ $client->id }}">
                {{ $client->first_name }}
                {{ $client->last_name }}
              </a>
              <div class="pull-right">
                <form action="/users/{{ $user->id }}/client/{{ $client->id }}"
                      method="post">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}
                  <button type="submit" class="btn btn-link">
                    <i class="fa fa-times"></i>
                  </button>
                </form>
              </div>
            </li>
          @endforeach
        </ul>
      @endif

      @if ($user->group == 'Client' and $user->employees->count())
        <h1>Employees</h1>
        <ul class="list-group">
          @foreach ($user->employees as $client)
            <li class="list-group-item">
              <a href="/users/{{ $client->id }}">{{ $client->first_name }}
                {{ $client->last_name }}</a>
            </li>
          @endforeach
        </ul>
      @endif
    </div>
    <div class="col-md-9">
      <div class="edit">
        @if ($authUser->group == "Admin" or $authUser->id == $user->id)
          <a href="{{ $user->id }}/edit">Edit</a>
        @endif
        &nbsp;
        @if ($authUser->group == "Admin")
          @if (in_array($user->group, ['Employee', 'Admin']))
            <a href="/users/{{ $user->id }}/client">Add Client</a>
          @else
            <form action="/users/{{ $authUser->id }}/client" method="post"
                  style="display:inline">
              {{ csrf_field() }}
              <input type="hidden" name="clientId" value="{{ $user->id }}">
              <button type="submit" class="btn btn-link">
                Add As Client
              </button>
            </form>
          @endif
        @endif
      </div>
      @if (session('message'))
        <div class="alert alert-{{ session('status') }}" role="alert">
          <strong>{{ session('message') }}</strong>
        </div>
      @endif
      <h1>About</h1>
      <div class="box box-down">
        <p>{!! $user->about ? $user->aboutBr() : "..." !!} </p>
      </div>
      <iframe
          width="100%"
          height="350"
          frameborder="0" style="border:0"
          src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDbYZ1HmPs_
          q-mJP4vmUt4vR8hJcy3dEH8
          &q={{ $user->street1 }}
          {{ $user->street2 }}
          {{ $user->city }}
          {{ $user->region }}
          {{ $user->post_code }}
          {{ $user->country }}" allowfullscreen>
      </iframe>
      <br><br>
      @if (isset($boughtStocks) and $boughtStocks->count())
        <h1>
          Recently Bought Stocks
          <a class="right" href="/users/{{ $user->id }}/bought">All</a>
        </h1>
        <div class="box box-table">
          <table class="table table-striped">
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
        </div>
      @endif
      @if (isset($soldStocks) and $soldStocks->count())
        <h1>
          Recently Sold Stocks
          <a class="right" href="/users/{{ $user->id }}/sold">All</a>
        </h1>
        <div class="box box-table">
          <table class="table table-striped">
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
                  <span style="color: {{ $stock->colour()}}">
                ({{ $stock->percentage() }}%)
              </span>
                </td>
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
        </div>
      @endif
    </div>
  </div>
@endsection
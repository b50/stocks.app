<form action="/stocks/favorite" method="post">
  <input type="hidden" name="symbol" value="{{ $symbol }}">
  @if($authUser->favoriteStock($symbol))
    <input type="submit" class="btn" value="Favorite">
  @else
    <input type="submit" class="btn btn-primary" value="Favorite">
  @endif
  {{ csrf_field() }}
</form>
<br>
<h1>Buy</h1>
<div class="box box-down">
  <form action="{{ $symbol }}/buy"
        class="form-horizontal" method="POST">
    <div class="form-group">
      {{ csrf_field() }}
      <input type="hidden" name="symbol" value="{{ $symbol }}">
      <label class="col-sm-3 control-label">Client:</label>
      <div class="col-sm-9">
        <select class="form-control" id="sel1" name="client">
          @foreach ($authUser->clients as $client)
            <option value="{{ $client->id  }}">
              {{ $client->first_name }}
              {{ $client->last_name }}
            </option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">
        Amount
      </label>
      <div class="col-sm-9">
        <input type="number" class="form-control" id="amountBuy" placeholder=""
               value="1" name="amount" min="1">
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-3">
        <button type="submit" class="btn btn-primary">Buy</button>
      </div>
      <div class="col-md-9">Price: <span id="priceBuy"></span>
      </div>
    </div>
  </form>
</div>
@if ($boughtStocks->count())
  <h1>Sell</h1>
  <table class="box table table-striped">
    <thead>
    <tr>
      <th>Price</th>
      <th>Amount</th>
    </tr>
    </thead>
    <tbody>
    @foreach($boughtStocks as $stock)
      <tr>
        <td>
          <div class="compare">{{ $stock->bought }}</div>
        </td>
        <td>
          <form action="{{ $symbol }}/sell" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="symbol" value="{{ $symbol }}">
            <div class="row">
              <div class="col-xs-8">
                <input type="number" class="form-control" name="amount"
                       value="{{ $stock->amount }}" max="{{ $stock->amount }}"
                       min="1">
                <input type="hidden" name="id" value="{{ $stock->id }}">
              </div>
              <div class="col-xs-4">
                <button type="submit" class="btn btn-default">Sell</button>
              </div>
            </div>
          </form>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
@endif
@if ($soldStocks->count())
  <h1>Previously Sold</h1>
  <table class="box table table-striped">
    <thead>
    <tr>
      <th>Price</th>
      <th>Amount</th>
    </tr>
    </thead>
    <tbody>
    @foreach($soldStocks as $stock)
      <tr>
        <td>
          @if ($stock->percentage()> 0)
            <i style="color: {{ $stock->colour()}}" class='fa fa-caret-up'></i>
          @else
            <i style="color: {{ $stock->colour()}}"
               class='fa fa-caret-down'></i>
          @endif
          {{ $stock->sold }} | {{ $stock->from }}
          <span style="color: {{ $stock->colour()}}">
           ({{ $stock->percentage()}}%)
        </span>
        </td>
        <td>{{ $stock->amount }}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
@endif
<h1>Notes</h1>
<form action="{{ $symbol }}/note" method="POST">
  {{ csrf_field() }}
  <input type="hidden" name="symbol" value="{{ $symbol }}">
  <textarea name="note" id="" cols="30" rows="10" style="max-width: 100%"
            class="box box-section">{{ ($note) ? $note->note : null }}</textarea>
  <div class="box box-down">
    <p>
      <button type="submit" class="btn btn-primary">Save</button>
    </p>
  </div>
</form>

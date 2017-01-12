@extends(\Input::get('ajax') ? 'ajax' : 'template')

@section('content')
  <div class="row" id="stock">
    <div class="col-md-8">
      @if (session('message'))
        <div class="alert alert-{{ session('status') }}" role="alert">
          <strong>{{ session('message') }}</strong>
        </div>
      @endif
      @if (count($errors) > 0)
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <span class="hidden" id="symbol"></span>
      <h1 class="name">
        <small class="symbol"></small>
      </h1>
      <div class="box box-open box-down">
        <h2 class="price" id="price"></h2>
        <h3 class="change" id="change"></h3>
        <h3 class="changeP" id="changeP"></h3>
      </div>
      <div id="symbolImageContainer">
        <img id="symbolImage" class="clearfix">
      </div>
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
    <div class="col-md-4">
      @include('stock-sidebar')
    </div>
  </div>
@endsection
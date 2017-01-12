@extends('template')

@section('title', _('Stocks'))
@section('breadcrumbs')
  <li>
    <a href="/edit-eotm">
      Edit Employee of the month
    </a>
  </li>
@endsection

@section('content')
  @if (count($errors) > 0)
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <h1>Edit Employee Of The Month</h1>
  <div class="box">
    <form action="/edit-eotm" method="POST" class="form-horizontal">
      {{ csrf_field() }}
      <div class="form-group">
        <label class="col-sm-2 control-label" for="user_id" class="label">
          User
        </label>
        <div class="col-sm-10">
          <select name="user_id" class="form-control">
            @foreach ($employees as $employee)
              <option @if($employee->id == $eotm->userId()) selected @endif
                       value="{{ $employee->id }}">
                {{ $employee->name() }}
              </option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-12">
          <textarea class="form-control" rows="12"
                    name="why">{{ old('why') ?? $eotm->why() }}</textarea>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-12">
          <button type="submit" class="btn btn-primary">Edit</button>
        </div>
      </div>
    </form>
  </div>
@endsection
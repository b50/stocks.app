@extends('template')

@section('title', _('Add Client'))

@section('breadcrumbs')
  <li><a href="/users">Users</a></li>
  <li><a href="/users/{{  $user->id }}">{{ $user->name() }}</a></li>
  <li><a href="/users/{{  $user->id }}/client">Add Client</a></li>
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
  <h1>Add Client</h1>
  <div class="box">
    <form action="/users/{{ $user->id }}/client" method="POST"
          class="form-horizontal">
      {{ csrf_field() }}
      <div class="form-group">
        <label for="clientId" class="col-sm-2 control-label">Client</label>
        <div class="col-sm-10">
          <select name="clientId" class="form-control">
            @foreach ($users as $user)
              <option value="{{ $user->id }}">{{ $user->name() }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </div>
    </form>
  </div>
@endsection
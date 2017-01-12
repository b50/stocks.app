@extends('template')

@section('title', _('Stocks'))
@section('breadcrumbs')
  <li>
    <a href="/announcement/create">Create Announcement</a>
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
  <h1>Create Announcement</h1>
  <div class="box">
    <form action="/announcements" method="POST">
      {{ csrf_field() }}
      <div class="form-group">
        <textarea class="form-control" rows="12" name="content"></textarea>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Create</button>
      </div>
    </form>
  </div>
@endsection
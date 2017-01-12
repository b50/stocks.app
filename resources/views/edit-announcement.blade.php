@extends('template')

@section('title', _('Stocks'))
@section('breadcrumbs')
  <li>
    <a href="/announcements/{{ $announcement->id }}/edit">Edit Announcement</a>
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
  <h1>Edit Announcement</h1>
  <div class="box">
    <form action="/announcements/{{ $announcement->id }}" method="POST">
      {{ csrf_field() }}
      {{ method_field('PUT') }}
      <div class="form-group">
        <textarea class="form-control"
                  rows="12" name="content"
        >{{ $errors->count() ? '': $announcement->content }}</textarea>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Edit</button>
      </div>
    </form>
  </div>
@endsection
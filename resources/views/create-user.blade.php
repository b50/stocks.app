@extends('template')

@section('title', _('Create a user'))
@section('breadcrumbs')
  <li><a href="/users">Users</a></li>
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
  <h1>Create User</h1>
  <div class="box">
    @include('user-form', [
      'action' => "/users",
      'user' => new \App\Models\User()
    ])
  </div>
@endsection
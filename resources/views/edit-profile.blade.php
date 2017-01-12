@extends('template')

@section('title', _('Edit a user'))
@section('breadcrumbs')
  <li><a href="/users">Users</a></li>
  <li><a href="/users/{{  $user->id }}">{{ $user->name() }}</a></li>
  <li><a href="/users/{{  $user->id }}/edit">Edit</a></li>
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
  <h1>Edit Profile</h1>
  <div class="box">
    @include('user-form', ['action' => "/users/$user->id", 'method' => 'put'])
  </div>
@endsection
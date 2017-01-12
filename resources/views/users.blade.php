@extends('template')

@section('title', 'Users')
@section('breadcrumbs', '<li><a href="/users">Users</a></li>')

@section('content')
  {!! $users->render() !!}
  <h1>Users
    @if ($authUser->group == "Admin")
      <a class="right" href="/users/create">Add</a>
    @endif
  </h1>
  <table class="table table-striped box box-down">
    @foreach ($users as $user)
      <tr>
        <td class="usersAvatar">
          <img src="{{ $user->avatar() }}" alt="">
        </td>
        <td>
          <a href="/users/{{ $user->id }}">{{ $user->name() }}</a><br>
          {{ $user->group }}
        </td>
      </tr>
    @endforeach
  </table>
  {!! $users->render() !!}
@endsection

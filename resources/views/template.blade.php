<!DOCTYPE html>
<html lang="en">
@include('header')
<body>
<nav class="navbar navbar-default navbar-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed"
              data-toggle="collapse" data-target=".navbar-collapse"
              aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">
        <img id="logo" src="/images/logo.png" alt="">stocks.app
      </a>
    </div>
    <div class="collapse navbar-collapse">
      @if (in_array($authUser->group, ['Admin', 'Employee']))
        <form id="searchForm" class="navbar-form navbar-left" role="search">
          <div class="form-group">
            <input id="search" type="text" class="form-control"
                   placeholder="Search for...">
          </div>
          <button type="submit" class="btn btn-default">Go!</button>
        </form>
      @endif
      <ul class="nav navbar-nav">
        <li><a href="/users">Users</a></li>
        <li class="hidden-lg hidden-md hidden-sm">
          <a href="/users/{{ $authUser->id }}">Profile</a>
        </li>
        <li class="hidden-lg hidden-md hidden-sm">
          <a href="/auth/logout">Logout</a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right hidden-xs">
        <li id="userBox">
          <a href="/users/{{ $authUser->id }}">
            <img style="height:50px" src="{{ $authUser->avatar() }}" alt="">
          </a>
        </li>
        <ul id="menu">
          <li><a href="/users/{{ $authUser->id }}">Profile</a></li>
          <li><a href="/auth/logout">Logout</a></li>
        </ul>
        <li>
          <a href="#" id="user">
            {{ $authUser->first_name }}
            <span class="caret"></span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
  <ul class="breadcrumb">
    <li><a href="/">Home</a></li>
    @yield('breadcrumbs')
  </ul>
  <i class="fa fa-spinner fa-pulse center" id="loading"></i>
  <div id="content">
    @yield('content')
  </div>
</div>
<footer>
  <div class="container">
    <p>&copy; stocks.app</p>
  </div>
</footer>
</body>
</html>
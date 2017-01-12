<form action="{{ $action }}" method="POST" class="form-horizontal"
      enctype="multipart/form-data">
  {{ csrf_field() }}
  @if(isset($method))
    <input type="hidden" name="_method" value="{{ $method }}">
  @endif
  <div class="form-group">
    <label for="first_name" class="col-sm-2 control-label">First Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="first_name"
             @if ($authUser->group != 'Admin') disabled @endif
             value="{{ old('first_name') ?? $user->first_name }}">
    </div>
  </div>
  <div class="form-group">
    <label for="last_name" class="col-sm-2 control-label">Last Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="last_name"
             @if ($authUser->group != 'Admin') disabled @endif
             value="{{ old('last_name') ?? $user->last_name }}">
    </div>
  </div>
  <div class="form-group">
    <label for="email" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" name="email"
             value="{{ old('email') ?? $user->email }}">
    </div>
  </div>
  @if ($authUser->group == "Admin")
    <div class="form-group">
      <label for="group" class="col-sm-2 control-label">Group</label>
      <div class="col-sm-10">
        <select id="group" name="group" class="form-control">
          @if (old('group'))
            <option @if(old('group') == "Admin") selected @endif>
              Admin
            </option>
            <option @if(old('group') == "Client") selected @endif>
              Client
            </option>
            <option @if(old('group') == "Employee") selected @endif>
              Employee
            </option>
          @else
            <option
                @if($user->group == "Admin") selected @endif>
              Admin
            </option>
            <option @if($user->group == "Client") selected @endif>
              Client
            </option>
            <option @if($user->group == "Employee") selected @endif>
              Employee
            </option>
          @endif
        </select>
      </div>
    </div>
  @endif
  @if ($user->group = "Client" and $authUser->group == "Admin")
    <div class="form-group">
      <label for="password" class="col-sm-2 control-label">Money</label>
      <div class="col-sm-10">
        @if ($user->id and $user->money)
          <input type="text" class="form-control" name="money"
                 value="{{ old('money') ?? $user->money->value }}">
        @else
          <input type="text" class="form-control" name="money"
                 value="{{ old('money') }}">
        @endif
      </div>
    </div>
  @endif
  <div class="form-group">
    <label for="password" class="col-sm-2 control-label">New Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" name="password">
    </div>
  </div>
  <div class="form-group">
    <label for="password_confirmation" class="col-sm-2 control-label">
      Confirm New Password
    </label>
    <div class="col-sm-10">
      <input type="password" class="form-control" name="password_confirmation">
    </div>
  </div>
  <div class="form-group">
    <label for="about" class="col-sm-2 control-label">About</label>
    <div class="col-sm-10">
          <textarea class="form-control" rows="12"
                    name="about">{{ old('about') ?? $user->about }}</textarea>
    </div>
  </div>
  <div class="form-group">
    <label for="avatar" class="col-sm-2 control-label">Profile Picture</label>
    <div class="col-sm-10">
      <input type="file" name="avatar">
    </div>
  </div>
  <div class="form-group">
    <label for="email" class="col-sm-2 control-label">Address</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="street1"
             placeholder="Line 1"
             value="{{ old('street1') ?? $user->street1 }}">
      <br>
      <input type="text" class="form-control" name="street2"
             placeholder="Line 2"
             value="{{ old('street2') ?? $user->street2 }}">
    </div>
  </div>
  <div class="form-group">
    <label for="city" class="col-sm-2 control-label">City</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="city"
             value="{{ old('city') ?? $user->city }}">
    </div>
  </div>
  <div class="form-group">
    <label for="post_code" class="col-sm-2 control-label">Post Code</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="post_code"
             value="{{ old('post_code') ?? $user->post_code }}">
    </div>
  </div>
  <div class="form-group">
    <label for="region" class="col-sm-2 control-label">Region</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="region"
             value="{{ old('region') ?? $user->region }}">
    </div>
  </div>
  <div class="form-group">
    <label for="country" class="col-sm-2 control-label">Country</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="country"
             value="{{ old('country') ?? $user->country }}">
    </div>
  </div>
  <div class="form-group">
    <label for="mobile" class="col-sm-2 control-label">Mobile</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="mobile"
             value="{{ old('mobile') ?? $user->mobile }}">
    </div>
  </div>
  <div class="form-group">
    <label for="home_phone" class="col-sm-2 control-label">Home Phone</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="home_phone"
             value="{{ old('home_phone') ?? $user->home_phone }}">
    </div>
  </div>
  <div class="form-group">
    <label for="work_phone" class="col-sm-2 control-label">Work Phone</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="work_phone"
             value="{{ old('work_phone') ?? $user->work_phone }}">
    </div>
  </div>
  <div class="form-group">
    <label for="password" class="col-sm-2 control-label">
      Current Password
    </label>
    <div class="col-sm-10">
      <input type="password" class="form-control" name="currentPassword">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </div>
</form>
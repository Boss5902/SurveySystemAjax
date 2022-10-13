@extends('auth.layout')
  
@section('content')
<main class="login-form">
  <div class="cotainer">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">Login</div>
                  <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('success') }}
                        </div>
                    @elseif( session('customErr'))  
                            <div class="alert alert-danger" role="alert">
                                {{ session('customErr') }}
                            </div>
                    @endif
  
                    <form action="{{ route('login.post') }}" method="POST">
                          @csrf

                           @php if(isset($_COOKIE['login_email']) && isset($_COOKIE['login_pass']))
                            {
                                $login_email = $_COOKIE['login_email'];
                                $login_pass  = $_COOKIE['login_pass'];
                                $is_remember = "checked='checked'";
                            }
                            else{
                                $login_email ='';
                                $login_pass = '';
                                $is_remember = "";
                                }
                            @endphp

                          <div class="form-group row">
                              <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                              <div class="col-md-6">
                                  <input type="text" id="email_address" class="form-control" name="email" value="{{$login_email}}" autocomplete="off" required autofocus>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="form-group row">
                              <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                              <div class="col-md-6">
                                  <input type="password" id="password" class="form-control" name="password" autocomplete="off" value="{{$login_pass}}" required>
                                  @if ($errors->has('password'))
                                      <span class="text-danger">{{ $errors->first('password') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="form-group row">
                              <div class="col-md-6 offset-md-4">
                                  <div class="checkbox">
                                      <label>
                                          <input type="checkbox" name="remember_me" {{$is_remember}}> Remember Me
                                      </label>
                                  </div>
                              </div>
                          </div>
  
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  Login
                              </button>
                          </div>
                    </form>
                        
                  </div>
              </div>
          </div>
      </div>
  </div>
</main>
@endsection
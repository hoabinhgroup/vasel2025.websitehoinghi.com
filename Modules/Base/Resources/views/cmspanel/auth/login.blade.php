@extends('base::cmspanel.layout.master')

@section('title', ' - Login page')

@section('content')
<style>
  body {
    background: url('{{ setting("admin_login_screen_background") }}') !important;
    background-size: cover !important;
  }

  .border-lighten-3 {
    background: rgb(0, 0, 0, 0.3);
  }

  .btn-outline-yellow {
    border-color: #FFEB3B;
    background-color: transparent;
    color: #FFEB3B;
  }

  .card-header {
    background: transparent;
  }

  label[for="remember-me"] {
    color: #fff;
  }
</style>
<div class="content-wrapper">
  <div class="content-header row">
  </div>
  <div class="content-body">
    <section class="flexbox-container">

      <div class="col-12 d-flex align-items-center justify-content-center">
        <div class="col-md-4 col-10 box-shadow-2 p-0">
          <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
            <div class="card-header border-0">
              <div class="card-title text-center">
                <!-- <h1 style="font-size: 2em;color: #fdd300;"><img src="https://cdn.websitehoinghi.com/apscvir-header-a4-copy.png" width="200" /></h1> -->
                <!--                     <img src="/public/images/7b91b2efc18361b9f3d67e6102382cd4.png" alt="branding logo"> -->
              </div>
              <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">

              </h6>
            </div>
            <div class="card-content">
              <div class="text-center"></div>
              <style>
                .error {
                  color: red;
                }
              </style>

              <div class="card-body">
                @if ($errors->any())

          @foreach($errors->all() as $error)
        <div class="alert alert-danger border-0 mb-2" role="alert">
        {!! $error !!}
        </div>

      @endforeach

        @endif
                <form class="form-horizontal" action="/cmspanel/auth/login" method="post">
                  {{ csrf_field() }}
                  <fieldset class="form-group position-relative has-icon-left">
                    <input type="text" class="form-control" name="email" id="email" placeholder="Your Username">
                    <div class="form-control-position">
                      <i class="ft-user"></i>
                    </div>
                  </fieldset>
                  <fieldset class="form-group position-relative has-icon-left">
                    <input type="password" name="password" class="form-control" id="user-password"
                      placeholder="Enter Password">
                    <div class="form-control-position">
                      <i class="fa fa-key"></i>
                    </div>
                  </fieldset>
                  <div class="form-group row">
                    <div class="col-md-6 col-12 text-center text-sm-left">
                      <fieldset>
                        <input type="checkbox" id="remember-me2" class="" name="remember" value="1" checked>
                        <label for="remember-me"> Ghi nhớ tài khoản</label>
                      </fieldset>
                    </div>

                  </div>
                  <button type="submit" class="btn btn-outline-yellow btn-block"><i class="ft-unlock"></i> Đăng
                    nhập</button>
                </form>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
@stop
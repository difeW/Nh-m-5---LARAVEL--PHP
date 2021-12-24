@extends('layout')
@section('content')

<section id="form">

	<!--form-->
	<div class="container">
		<div class="row account">
			<div class="col-sm-7">
				<div class="login-form" id="login_form">
					<!--login form-->
					<h2>Đăng nhập tài khoản</h2>
					<form action="{{URL::to('/login-customer')}}" method="POST">
						{{csrf_field()}}
						<input type="text" name="email_account" placeholder="Email" />
						<input type="password" name="password_account" placeholder="Mật khẩu" />
						<span>
							<input type="checkbox" class="checkbox">
							Ghi nhớ đăng nhập
						</span>
						<div class="btn-acc">
							<button type="submit" class="btn btn-default">Đăng nhập</button>
						</div>
						<p>Bạn chưa có tài khoản? <a class="nav-link" href="javascript:void(0)" id="signup">ĐĂNG KÝ NGAY</a></p>
					</form>
          <hr>
          <div class="form-group row mb-0">
              <div class="col-md-8 offset-md-4">
                 <a href="{{ url('login-facebook') }}" class="btn btn-primary"
                  style="background-color: blue;"><i class="fa fa-facebook"></i>
                  Facebook</a>
               </div>
             </div>
				</div>
				<!--/login form-->
			</div>
		</div>
		<div class="row account">
			<div class="col-sm-7">
				<div class="signup-form" id="register_form">
					<!--sign up form-->
					<h2>Đăng ký</h2>
					<form action="{{URL::to('/add-customer')}}" method="POST">
						{{ csrf_field() }}
						<input type="text" name="customer_name" placeholder="Họ và tên" />
						<input type="email" name="customer_email" placeholder="Email" />
						<input type="password" name="customer_password" placeholder="Mật khẩu" />
						<input type="text" name="customer_phone" placeholder="Điện thoại" />
						<div class="btn-acc">
							<button type="submit" class="btn btn-default">Đăng ký</button>
						</div>
						<p>Bạn chưa đã tài khoản? <a class="nav-link" href="javascript:void(0)" id="signin">ĐĂNG NHẬP NGAY</a></p>
					</form>
				</div>
				<!--/sign up form-->
			</div>
		</div>
	</div>

</section>
<!--/form-->

@endsection
@extends('layout')
@section('content')

<section id="cart_items">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="{{URL::to('/')}}">Trang chủ</a></li>
				<li class="active">Thanh toán</li>
			</ol>
		</div>

		<!-- <div class="register-req">
				<p>Làm ơn đăng ký hoặc đăng nhập để thanh toán giỏ hàng và xem lại lịch sử mua hàng</p>
			</div>/register-req -->

		<div class="shopper-informations">
			<div class="row info-shopper">
				<div class="col-sm-6">
					<div class="bill-to">
						<p>Điền thông tin nhận hàng</p>
						<div class="form-one">
							<form method="POST" action="{{URL::to('/save-checkout-customer')}}">
								@csrf
								<input type="text" name="shipping_email" class="shipping_email" placeholder="Email">
								<input type="text" name="shipping_name" class="shipping_name" placeholder="Họ tên">
								<div class="form-group">
                                    <label for="exampleInputPassword1">Chọn thành phố</label>
                                      <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
                                    
                                            <option value="">--Chọn tỉnh thành phố--</option>
                                        @foreach($city as $key => $ci)
                                            <option value="{{$ci->name_city}}">{{$ci->name_city}}</option>
                                        @endforeach
                                            
                                    </select>
                                </div>
								<input type="text" name="shipping_address" class="shipping_address" placeholder="Địa chỉ nhận hàng">
								<input type="text" name="shipping_phone" class="shipping_phone" placeholder="Số điện thoại">
								<textarea name="shipping_notes" class="shipping_notes" placeholder="Ghi chú" rows="5"></textarea>
								<div>
									<div class="form-group">
										<label for="exampleInputPassword1">Hình thức thanh toán</label>
										<select name="payment_select" class="form-control input-sm m-bot15 payment_select">
											<option value="0">Chuyển khoản</option>
											<option value="1">Thanh toán khi nhận hàng</option>
										</select>
									</div>
								</div>
								<input type="submit" value="Xác nhận đơn hàng" class="btn btn-primary btn-sm send_order" ">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!--/#cart_items-->

@endsection
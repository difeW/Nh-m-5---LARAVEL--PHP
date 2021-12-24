@extends('layout')
@section('content')

<section id="cart_items">

	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="{{URL::to('/')}}">Trang chủ</a></li>
				<li class="active">Giỏ hàng của bạn</li>
			</ol>
		</div>
		@if(session()->has('message'))
		<div class="alert alert-success">
			{!! session()->get('message') !!}
		</div>
		@elseif(session()->has('error'))
		<div class="alert alert-danger">
			{!! session()->get('error') !!}
		</div>
		@endif
		<div class="table-responsive cart_info">

			<form action="{{url('/update-cart')}}" method="POST">
				@csrf
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image text-center">Hình ảnh</td>
							<td class="description text-center">Tên sản phẩm</td>
							<td class="description text-center">Số lượng tồn</td> 
							<td class="price text-center">Giá sản phẩm</td>
							<td class="quantity text-center">Số lượng</td>
							<td class="total text-center">Thành tiền</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						@if(Session::get('cart')==true)
						<?php
						$total = 0;
						?>
						@foreach(Session::get('cart') as $key => $cart)
						<?php
						$subtotal = $cart['product_price'] * $cart['product_qty'];
						$total += $subtotal;
						?>
						<tr>
							<td class="cart_product text-center">
								<img src="{{asset('/public/uploads/product/'.$cart['product_image'])}}" width="90" alt="{{$cart['product_name']}}" />
							</td>
							<td class="cart_description text-center">
								<h4><a href=""></a></h4>
								<p>{{$cart['product_name']}}</p>
							</td>
							<td class="cart_description text-center">
                  				<p>{{$cart['product_quantity']}}</p>
              				</td>
							<td class="cart_price">
								<h4><a href=""></a></h4>
								<p>{{number_format($cart['product_price'],0,',','.')}} VND</p>
							</td>
							<td class="cart_quantity text-center">
								<div class="cart_quantity_button">

									<input class="cart_quantity no-footer" data-validation="number"
                                        data-validation-allowing="range [1; {{$cart['product_quantity']}}]"
                                        data-validation-error-msg="Số lượng vượt số lượng tồn kho." type="number"
                                        min="1" name="cart_qty[{{$cart['session_id']}}]"
                                        value="{{$cart['product_qty']}}" style="max-width: 2.5em;">

								</div>
							</td>
							<td class="cart_total text-center">
								<h4><a href=""></a></h4>
								<p class="cart_total_price">
									{{number_format($subtotal,0,',','.')}} VND

								</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href="{{url('/del-product/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
							</td>
						</tr>

						@endforeach
						<tr>
							<td colspan="2" class="text-center"><a class="btn btn-default check_out" href="{{url('/del-all-product')}}">Xóa tất cả</a></td>

							<td><input type="submit" value="Cập nhật giỏ hàng" name="update_qty" class="check_out btn btn-default btn-sm"></td>
							<!-- <td>
								@if(Session::get('coupon'))
								<a class="btn btn-default check_out" href="{{url('/unset-coupon')}}">Xóa mã khuyến mãi</a>
								@endif
							</td> -->

							<!-- <td>
								@if(Session::get('customer_id'))
								<a class="btn btn-default check_out" href="{{url('/shipping')}}">Đặt hàng</a>
								@else
								<a class="btn btn-default check_out" href="{{url('/dang-nhap')}}">Đặt hàng</a>
								@endif
							</td> -->

							<td colspan="1" class="text-right">
								<h3>TỔNG:</h3>
							</td>
							<td colspan="1" class="text-center">
								<h3><span>{{number_format($total,0,',','.')}} VND</span></h3>
								@if(Session::get('coupon'))
								<li>

									@foreach(Session::get('coupon') as $key => $cou)
									@if($cou['coupon_condition']==1)
									Mã giảm : {{$cou['coupon_number']}} %
									<p>
										@php
										$total_coupon = ($total*$cou['coupon_number'])/100;
										echo '
									<p>
								<li>Tổng giảm:'.number_format($total_coupon,0,',','.').'đ</li>
								</p>';
								@endphp
								</p>
								<p>
									<li>Tổng đã giảm :{{number_format($total-$total_coupon,0,',','.')}}đ</li>
								</p>
								@elseif($cou['coupon_condition']==2)
								Mã giảm : {{number_format($cou['coupon_number'],0,',','.')}} k
								<p>
									@php
									$total_coupon = $total - $cou['coupon_number'];

									@endphp
								</p>
								<p>
									<li>Tổng đã giảm :{{number_format($total_coupon,0,',','.')}}đ</li>
								</p>
								@endif
								@endforeach



								</li>
								@endif
								{{-- <li>Thuế <span></span></li>
							<li>Phí vận chuyển <span>Free</span></li> --}}


							</td>
						</tr>

						<tr>
							<td colspan="5" class="text-right">
								@if(Session::get('customer_id'))
								<a class="btn btn-default check_out" href="{{url('/shipping')}}" style="padding: 1% 5%;">ĐẶT HÀNG</a>
								@else
								<a class="btn btn-default check_out" href="{{url('/dang-nhap')}}" style="padding: 1% 5%;">ĐẶT HÀNG</a>
								@endif
							</td>
						</tr>
						@else
						<tr>
							<td colspan="6" class="text-center">
								@php
								echo 'Bạn chưa có sản phẩm nào trong giỏ';
								@endphp
							</td>
						</tr>
						@endif
					</tbody>

			</form>
			@if(Session::get('car'))
			<tr>
				<td>

					<form method="POST" action="{{url('/check-coupon')}}">
						@csrf
						<input type="text" class="form-control" name="coupon" placeholder="Nhập mã giảm giá"><br>
						<input type="submit" class="btn btn-default check_coupon" name="check_coupon" value="Tính mã giảm giá">

					</form>
				</td>
			</tr>
			@endif

			</table>

		</div>
	</div>

</section>
<!--/#cart_items-->



@endsection
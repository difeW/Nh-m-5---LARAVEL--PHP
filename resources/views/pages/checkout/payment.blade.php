@extends('layout')
@section('content')

<section id="cart_items">
	<?php
	$content = Session::get("cart");
	?>
	<script>
		alert($content.val());
	</script>
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="{{URL::to('/')}}">Trang chủ</a></li>
				<li class="active">Thanh toán giỏ hàng</li>
			</ol>
		</div>

		<div style="background-color: var(--saphire-blue); height: 3px;"></div>
		<div class="review-payment">
			<h2><span class="glyphicon glyphicon-map-marker"></span> Địa chỉ nhận hàng</h2>
			<a href="{{URL::to('/shipping')}}">
				<div class="infoShopper" style ="color: black;">
				<span><b>Tên:</b><b> {{$ship->shipping_name}}</b></span>
				<span><b>Địa chỉ:</b> {{$ship->shipping_address}},{{$ship->city_name}}</span>
				<span><b>Điện thoại:</b> {{$ship->shipping_phone}}</span>
			</div></a>
			
		</div>
		
		<div class="table-responsive cart_info">

			<?php
			$total = 0;
			?>
			<table class="table table-condensed">
				<thead>
					<tr class="cart_menu">
						<td class="image text-center">Hình ảnh</td>
						<td class="description text-center">Tên sản phẩm</td>
						<td class="price text-center">Giá</td>
						<td class="quantity text-center">Số lượng</td>
						<td class="total text-center">Tổng</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					@foreach($content as $v_content)
					<tr>
						<?php
						$total += $v_content['product_price'] * $v_content['product_qty'];
						?>
						<td class="cart_product">
							<a href=""><img src="{{URL::to('public/uploads/product/'.$v_content['product_image'])}}" width="90" alt="" /></a>
						</td>
						<td class="cart_description text-center">
							<h4><a href="">{{$v_content['product_name']}}</a></h4>
						</td>
						<td class="cart_price">
							<p>{{number_format($v_content['product_price']).' '.' VND'}}</p>
						</td>
						<td class="cart_quantity text-center">
							<div class="cart_quantity_button">
								<form action="{{URL::to('/update-cart-quantity')}}" method="POST" style="display: flex; justify-content: space-around;">
									{{ csrf_field() }}
									<input class="cart_quantity_input" type="text" name="cart_quantity" value="{{$v_content['product_qty']}}" style="max-width: 2.3em;">
									<input type="hidden" value="{{$v_content['session_id']}}" name="rowId_cart" class="form-control">
									<input type="submit" value="Cập nhật" name="update_qty" class="btn btn-default btn-sm">
								</form>
							</div>
						</td>
						<td class="cart_total text-center">
							<p class="cart_total_price">

								<?php
								$subtotal = $v_content['product_price'] * $v_content['product_qty'];
								echo number_format($subtotal) . ' ' . ' VND';
								?>

						</td>
						<td class="cart_delete">
							<a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$v_content['session_id'])}}"><i class="fa fa-times"></i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>

		</div>
			<?php
					$tiencodinh = $total + $ship->tien_ship;
					session::put('thanhtien',$total + $ship->tien_ship);
				?>
		<div>
				<h4>Mã giảm giá</h4>
				<form>
					<label for="fname">Code</label>
					<input type="text" id="fname" class="code" placeholder="Your code..">
					<br>
					<a  class="btn btn-primary btn-sm tinhgiamgia" value="Submit">Xác nhận</a>
					<p id="thongbaocode"></p>
					<input type="hidden" value="{{$tiencodinh}}" class="tiencodinh">
				</form>
			</div>
		<form action="{{URL::to('/order-place')}}" method="POST" style="margin-bottom: 3%;">
			{{ csrf_field() }}
			<input type="hidden" name="shipid" value="{{$ship->shipping_id}}">

			<div class="text-right">
				<h3>Tổng tiền:
					<label><input name="thanhtien" value="{{$total}}" type="hidden"> {{number_format($total,0,',','.')}} VND</label>
				</h3>
				<h3>Tiền ship:
					<label><input name="thanhtien" value="{{$total}}" type="hidden"> +{{number_format($ship->tien_ship,0,',','.')}} VND</label>
				</h3>
				<h3 id="tiengiamgia">
				</h3>

				<h3>Thành tiền:
					<label id="thanhtien"><input name="thanhtien" value="{{$total}}" type="hidden"> {{number_format(session::get('thanhtien'),0,',','.')}} VND</label>
				</h3>
			</div>
			<div style="background-color: var(--saphire-blue); height: 3px;"></div>
			<h3 style="margin-left: 2rem; color: var(--dark-blue);">Phương thức thanh toán</h3>
			<div class="payment-options">
				<span>
					<label><input name="payment_option" value="1" type="radio"><i class="fas fa-credit-card"></i> Trả bằng thẻ ATM</label>
				</span>
				<span>
					<label><input name="payment_option" value="2" type="radio"><i class="fas fa-money-bill"></i> Nhận tiền mặt</label>
				</span>
				<span>
					<label><input name="payment_option" value="3" type="radio"><i class="fab fa-cc-mastercard"></i> Thanh toán thẻ ghi nợ</label>
				</span>
			</div>
			<div class="text-right">
				<button type="submit" class="btn btn-primary btn-sm" style="padding: 1% 4%; font-weight: 500; font-size: 17px;">ĐẶT HÀNG</button>
			</div>

		</form>
	</div>
</section>

<script src="https://kit.fontawesome.com/75e5dad444.js" crossorigin="anonymous"></script>
<!--/#cart_items-->

@endsection
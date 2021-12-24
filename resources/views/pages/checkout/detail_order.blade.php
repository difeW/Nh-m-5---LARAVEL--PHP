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
				<span><b>Tên:</b><b> {{$shipping->shipping_name}}</b></span>
				<span><b>Địa chỉ:</b> {{$shipping->shipping_address}},{{$shipping->city_name}}</span>
				<span><b>Điện thoại:</b> {{$shipping->shipping_phone}}</span>
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
					@foreach($order_details as $v_content)
					<tr>
						<td class="cart_product">
							<a href=""><img src="{{URL::to('public/uploads/product/'.$v_content->product_image)}}" width="90" alt="" /></a>
						</td>
						<td class="cart_description text-center">
							<h4><a href="">{{$v_content->product_name}}</a></h4>
						</td>
						<td class="cart_price">
							<p>{{number_format($v_content->product_price).' '.' VND'}}</p>
						</td>
						<td class="cart_quantity text-center">
							<div class="cart_quantity_button">
								<form action="{{URL::to('/update-cart-quantity')}}" method="POST" style="display: flex; justify-content: space-around;">
									{{ csrf_field() }}
									<input class="cart_quantity_input" type="text" name="cart_quantity" value="{{$v_content->product_sales_quantity}}" style="max-width: 2.3em;">
								
								</form>
							</div>
						</td>
						<td class="cart_total text-center">
							<p class="cart_total_price">

								<?php
								$subtotal = $v_content->product_price * $v_content->product_sales_quantity;
								echo number_format($subtotal) . ' ' . ' VND';
								?>

						</td>
					</tr>
					@endforeach
				</tbody>
			</table>

		</div>
			<?php
					$tiencodinh = $total + $shipping->tien_ship;
					session::put('thanhtien',$total + $shipping->tien_ship);
				?>
		
		<form action="{{URL::to('/order-place')}}" method="POST" style="margin-bottom: 3%;">
			{{ csrf_field() }}
			<input type="hidden" name="shipid" value="{{$shipping->shipping_id}}">

			<div class="text-right">
				

				<h3>Thành tiền:
					<label id="thanhtien"><input name="thanhtien" value="{{$total}}" type="hidden"> {{number_format($order->order_total,0,',','.')}} VND</label>
				</h3>
			</div>
			<div style="background-color: var(--saphire-blue); height: 3px;"></div>
      <div style="margin-left: 2rem;">
        <h3  style ="color: var(--dark-blue);">Phương thức thanh toán</h3>
        <b>{{$order->phuongthuc}}</b>
        <h3 style=" color: var(--dark-blue);">Tình trạng đơn hàng</h3>
        <b>{{$order->order_status}}</b>
      </div>
			
      <div class="text-right">
        <input type="hidden" class="status" value="{{$order->order_status}}">
        @if($order->order_status=='Đang chờ xử lí'||$order->order_status=='Đã xác nhận đơn hàng')
        <a type="button" class="btn btn-danger huy-don-hang" data-id ='{{$order->order_id}}'>Hủy đơn hàng</a>
        @elseif($order->order_status=='Đơn hàng đang được giao')
        <a type="button" class="btn btn-warning huy-don-hang" data-id ='{{$order->order_id}}'>Trả hàng</a>
        <a type="button" class="btn btn-success nhan-don-hang" data-id ='{{$order->order_id}}'>Đã nhận hàng</a>
        @elseif($order->order_status=='Đơn hàng đã hủy')
        <h3 type="button" style="color: red;">Đơn hàng đã được hủy</h3>
        @elseif($order->order_status=='Đơn hàng đã được nhận')
        <h3 type="button" style="color: green;">Đơn hàng đã được nhận</h3>
        <a type="button" class="btn btn-warning">Đánh giá</a>
        @endif
        <h4 id="thongbao"></h4>
      </div>
			

		</form>
	</div>
</section>

<script src="https://kit.fontawesome.com/75e5dad444.js" crossorigin="anonymous"></script>
<!--/#cart_items-->

@endsection
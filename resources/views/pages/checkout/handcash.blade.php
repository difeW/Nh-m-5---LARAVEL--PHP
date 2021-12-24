@extends('layout')
@section('content')

<section id="cart_items">
	<div class="container order">
	<h2 class="title text-center" style="font-size: 24px; font-weight: 700; margin-bottom: 10px;">Thông tin đơn hàng</h2>
		@foreach($order as $key => $o)
		<div style="border: 5px solid var(--dark-blue); width: 70%; padding: 10px; margin: 20px;">
			<a style="padding-top: 10px; color: black;" href="{{URL::to('/order-detail/'.$o->order_id)}}" >
				<p><b>Tên:</b> {{$o->customer_name}}</p>
				<p><b>Sản phẩm:</b></p>
				<table class="table table-condensed">
					<thead class="text-center text-align">
						<tr class="cart_menu">
							<td class="image">Hình ảnh</td>
							<td class="description">Tên sản phẩm</td>
							<td class="price">Giá sản phẩm</td>
							<td class="quantity">Số lượng</td>
							<td class="total">Thành tiền</td>
							<td></td>
						</tr>
					</thead>
					<tbody class="text-center text-align">
						@foreach($order_details as $key => $order_d)
							<tr>
								@if($order_d->order_id == $o->order_id)
								<td>
									<img src="{{asset('/public/uploads/product/'.$order_d->product_image)}}" width="50" />
								</td>
								<td>
									<p>{{$order_d->product_name}}</p>
								</td>
								<td>
									<p>{{$order_d->product_price}}</p>
								</td>
								<td>
									<p>{{$order_d->product_sales_quantity}}</p>
								</td>
								<?php
									$subtotal = $order_d->product_price*$order_d->product_sales_quantity;
									?>
								<td>
									<p>{{$subtotal}}</p>
								</td>
								@endif
							</tr>
						@endforeach
					</tbody>
				</table>
				<p style="display: block inline;"><b>Tình Trạng:</b> {{$o->order_status}}.</p>
				<hr>
				<h3 class="text-right" style="margin-right: 2.5rem;">Tổng thanh toán: <b>{{$o->order_total}}</b></h3>
			</a>
		</div>
		@endforeach
		
	</div>
	
</section>

@endsection
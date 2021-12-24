@extends('layout')
@section('content')
@foreach($product_details as $key => $value)
<div class="product-details">
    <!--product-details-->
    <div class="col-sm-5">
        <div class="view-product">
            <img src="{{ URL::to('public/uploads/product/'.$value->product_image)}}" alt="" />
        </div>
    </div>
    <div class="col-sm-7">
        <div class="product-information">
            <!--/product-information-->
            <img src="images/product-details/new.jpg" class="newarrival" alt="" />
            <h2>{{$value->product_name}}</h2>
            <p>Mã ID: {{$value->product_id}}</p>
            <img src="images/product-details/rating.png" alt="" />

            <form>
                @csrf
                <input type="hidden" value="{{$value->product_id}}" class="cart_product_id_{{$value->product_id}}">

                <input type="hidden" value="{{$value->product_name}}" class="cart_product_name_{{$value->product_id}}">

                <input type="hidden" value="{{$value->product_image}}"
                    class="cart_product_image_{{$value->product_id}}">

                <input type="hidden" value="{{$value->product_price}}"
                    class="cart_product_price_{{$value->product_id}}">

                <span>
                    <span>{{number_format($value->product_price,0,',','.').'VNĐ'}}</span>

                    <label>Số lượng:</label>
                    <input name="qty" type="number" min="1" class="cart_product_qty_{{$value->product_id}}" value="1" />
                    <input name="productid_hidden" type="hidden" value="{{$value->product_id}}" />
                </span>
                <input type="button" value="Thêm giỏ hàng" class="btn add-to-cart"
                    data-id_product="{{$value->product_id}}" name="add-to-cart">
            </form>

            @if( $value->product_quantity == 0)
            <p><b>Tình trạng:</b> Hết hàng.</p>
            @else
            <p><b>Tình trạng:</b> Còn {{$value->product_quantity}} cái</p>
            @endif
            <p><b>Điều kiện:</b> Mơi 100%</p>
            <p><b>Thương hiệu:</b> {{$value->brand_name}}</p>
            <p><b>Danh mục:</b> {{$value->category_name}}</p>
        </div>
        <!--/product-information-->
    </div>
</div>
<!--/product-details-->

<div class="category-tab shop-details-tab">
    <!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Mô tả</a></li>
            <li><a href="#companyprofile" data-toggle="tab">Chi tiết sản phẩm</a></li>

            <li><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="details">
            <p>{!!$value->product_desc!!}</p>

        </div>

        <div class="tab-pane fade" id="companyprofile">
            <p>{!!$value->product_content!!}</p>


        </div>

        <div class="tab-pane fade" id="reviews">
            <div class="col-sm-12">
                <ul>
                    <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                    <li><a href=""><i class="fa fa-clock-o"></i>1:23 PM</a></li>
                    <li><a href=""><i class="fa fa-calendar-o"></i>24 12 2021</a></li>
                </ul>
                <p>
                    Chân thành cảm ơn quý khách đã mua sản phẩm từ MuseTech, mọi đánh giá của quý khách sẽ giúp cho
                    thương hiệu
                    MuseTech có thể hoàn thiện và phục vụ quý khách ngày một tốt hơn trong mai sau. Trân trọng!
                </p>
                <p><b>Viết đánh giá sản phẩm</b></p>

                <form action="#">
                    <span>
                        <input type="text" placeholder="Tên của bạn" />
                        <input type="email" placeholder="Địa chỉ email" />
                    </span>
                    <textarea name=""></textarea>
                    <!-- <b>Rating: </b> <img src="images/product-details/rating.png" alt="" /> -->
                    <button type="button" class="btn" style="border-radius: 10px;">
                        Submit
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
<!--/category-tab-->
@endforeach
<!-- <div class="recommended_items">
						<h2 class="title text-center">Sản phẩm liên quan</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<div class="item active">
							@foreach($relate as $key => $lienquan)
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											 <div class="single-products">
		                                        <div class="productinfo text-center product-related">
		                                            <img src="{{URL::to('uploads/product/'.$lienquan->product_image)}}" alt="" />
		                                            <h2>{{number_format($lienquan->product_price,0,',','.').' '.'VNĐ'}}</h2>
		                                            <p>{{$lienquan->product_name}}</p>
		                                         
		                                        </div>
		                                      
                                			</div>
										</div>
									</div>
							@endforeach		

								
								</div>
									
							</div>
									
						</div>
					</div>
					{{--   <ul class="pagination pagination-sm m-t-none m-b-none">
                       {!!$relate->links()!!}
                      </ul> --}} -->

@endsection
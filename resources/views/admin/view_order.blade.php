@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">

    <div class="panel panel-default">
        <div class="panel-heading">
            Thông tin đăng nhập
        </div>

        <div class="table-responsive">
            <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>

                        <th>Tên khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>

                        <th style="width:30px;"></th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>{{$customer->customer_name}}</td>
                        <td>{{$customer->customer_phone}}</td>
                        <td>{{$customer->customer_email}}</td>
                    </tr>

                </tbody>
            </table>

        </div>

    </div>
</div>
<br>
<div class="table-agile-info">

    <div class="panel panel-default">
        <div class="panel-heading">
            Thông tin vận chuyển hàng
        </div>


        <div class="table-responsive">
            <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>

                        <th>Tên người vận chuyển</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Ghi chú</th>
                        <th>Hình thức thanh toán</th>


                        <th style="width:30px;"></th>
                    </tr>
                </thead>
                <tbody>

                    <tr>

                        <td>{{$shipping->shipping_name}}</td>
                        <td>{{$shipping->shipping_address}}</td>
                        <td>{{$shipping->shipping_phone}}</td>
                        <td>{{$shipping->shipping_email}}</td>
                        <td>{{$shipping->shipping_notes}}</td>
                        <td>@if($shipping->shipping_method==0) Chuyển khoản @else Tiền mặt @endif</td>


                    </tr>

                </tbody>
            </table>

        </div>

    </div>
</div>
<br><br>

<div class="table-agile-info">

    <div class="panel panel-default">
        <div class="panel-heading">
            Liệt kê chi tiết đơn hàng
        </div>

        <div class="table-responsive">
            <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>

            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th style="width:20px;">
                            <label class="i-checks m-b-none">
                                <input type="checkbox"><i></i>
                            </label>
                        </th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng kho còn</th>
                        <th>Mã giảm giá</th>
                        <th>Phí ship hàng</th>
                        <th>Số lượng</th>
                        <th>Giá sản phẩm</th>
                        <th>Tổng tiền</th>

                        <th style="width:30px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 0;
                    $total = 0;
                    @endphp
                    @foreach($order_details as $key => $details)

                    @php
                    $i++;
                    $subtotal = $details->product_price*$details->product_sales_quantity;
                    $total+=$subtotal;
                    @endphp
                    <tr class="color_qty_{{$details->product_id}}">

                        <td><i>{{$i}}</i></td>
                        <td>{{$details->product_name}}</td>
                        <td>{{$details->product->product_quantity}}</td>
                        <td>@if($details->product_coupon!='no')
                            {{$details->product_coupon}}
                            @else
                            Không mã
                            @endif
                        </td>
                        <td>{{number_format($details->product_feeship ,0,',','.')}}đ</td>
                        <td>

                            <input type="number" min="1" {{$order_status==2 ? 'disabled' : ''}}
                                class="order_qty_{{$details->product_id}}" value="{{$details->product_sales_quantity}}"
                                name="product_sales_quantity">

                            <input type="hidden" name="order_qty_storage"
                                class="order_qty_storage_{{$details->product_id}}"
                                value="{{$details->product->product_quantity}}">

                            <input type="hidden" name="order_code" class="order_code" value="{{$details->order_code}}">

                            <input type="hidden" name="order_product_id" class="order_product_id"
                                value="{{$details->product_id}}">


                            <button class="btn btn-default update_quantity_order"
                                data-product_id="{{$details->product_id}}" name="update_quantity_order">Cập
                                nhật</button>


                        </td>
                        <td>{{number_format($details->product_price ,0,',','.')}}đ</td>
                        <td>{{number_format($subtotal ,0,',','.')}}đ</td>
                    </tr>

                    @endforeach
                    <tr>
                        <td colspan="6">
                            @foreach($order as $key => $or)
                            @if($or->order_status=='Đang chờ xử lí')
                            <form>
                                @csrf
                                <select class="form-control order_details">
                                    <option value="">----Chọn hình thức đơn hàng-----</option>
                                    <option id="{{$or->order_id}}" selected value="Đang chờ xử lí">Đang chờ xử lí</option>
                                    <option id="{{$or->order_id}}" value="Đã xác nhận đơn hàng">Đã xác nhận đơn hàng</option>
                                    <option id="{{$or->order_id}}" value="Đơn hàng đang được giao">Đơn hàng đang được giao</option>
                                    <option id="{{$or->order_id}}" value="Đơn hàng đã hủy">Đơn hàng đã hủy</option>
                                    <option id="{{$or->order_id}}" value="Đơn hàng đã được nhận">Đơn hàng đã được nhận</option>
                                </select>
                            </form>
                            @elseif($or->order_status=='Đã xác nhận đơn hàng')
                            <form>
                                @csrf
                                <select class="form-control order_details">
                                    <option value="">----Chọn hình thức đơn hàng-----</option>
                                    <option id="{{$or->order_id}}" value="Đã xác nhận đơn hàng" selected>Đã xác nhận đơn hàng</option>
                                    <option id="{{$or->order_id}}"  value="Đơn hàng đang được giao">Đơn hàng đang được giao</option>
                                    <option id="{{$or->order_id}}" value="Đơn hàng đã hủy">Đơn hàng đã hủy</option>
                                    <option id="{{$or->order_id}}" value="Đơn hàng đã được nhận">Đơn hàng đã được nhận</option>
                                </select>
                            </form>

                            @elseif($or->order_status=='Đơn hàng đang được giao')
                            <form>
                                @csrf
                                <select class="form-control order_details">
                                    <option value="">----Chọn hình thức đơn hàng-----</option>
                                    <option id="{{$or->order_id}}"  value="Đơn hàng đang được giao" selected>Đơn hàng đang được giao</option>
                                    <option id="{{$or->order_id}}" value="Đơn hàng đã hủy">Đơn hàng đã hủy</option>
                                    <option id="{{$or->order_id}}" value="Đơn hàng đã được nhận">Đơn hàng đã được nhận</option>
                                </select>
                            </form>
                            @elseif($or->order_status=='Đơn hàng đã hủy')
                            <h3 style="color: red;">Đơn hàng đã được hủy</h3>
                            @elseif($or->order_status=='Đơn hàng đã được nhận')
                            <h3 style="color: green;">Đơn hàng đã được nhận</h3>
                            @endif
                            @endforeach


                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

    </div>
</div>
@endsection
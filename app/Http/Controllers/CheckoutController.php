<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Cart;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Feeship;
use App\Models\Slider;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderDetails;
session_start();

class CheckoutController extends Controller
{
    public function show_shipping(request $request)
    {   
        $id = Session::get('customer_id');
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
        $shipping = Shipping::where('shipping_customer_id',$id)->get();
        $meta_desc = "Đăng nhập thanh toán"; 
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
        return view('pages.checkout.shipping')->with('shipping', $shipping)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider',$slider)->with('category',$cate_product)->with('brand',$brand_product);
    }

    public function handcash(request $request)
    {   
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
        $meta_desc = "Đăng nhập thanh toán"; 
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đơn mua";
        $id = Session::get('customer_id');
        $order = DB::table('tbl_order')
                ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
                ->where('tbl_customers.customer_id','=',$id)->get();
        $order_details = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->join('tbl_order_details','tbl_order_details.order_id','=','tbl_order.order_id')
        ->join('tbl_product','tbl_product.product_id','=','tbl_order_details.product_id')
        ->where('tbl_customers.customer_id','=',$id)->get();

        $url_canonical = $request->url();
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
        return view('pages.checkout.handcash')->with('order_details', $order_details)->with('order', $order)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider',$slider)->with('category',$cate_product)->with('brand',$brand_product);
    }
    public function confirm_order(Request $request){
         $data = $request->all();

         $shipping = new Shipping();
         $shipping->shipping_name = $data['shipping_name'];
         $shipping->shipping_email = $data['shipping_email'];
         $shipping->shipping_phone = $data['shipping_phone'];
         $shipping->shipping_address = $data['shipping_address'];
         $shipping->shipping_notes = $data['shipping_notes'];
         $shipping->shipping_method = $data['shipping_method'];
         $shipping->save();
         $shipping_id = $shipping->shipping_id;

         $checkout_code = substr(md5(microtime()),rand(0,26),5);

         $order = new Order;
         $order->customer_id = $_SESSION['customer_id'];
         $order->shipping_id = $shipping_id;
         $order->order_status = 1;
         $order->order_code = $checkout_code;

         date_default_timezone_set('Asia/Ho_Chi_Minh');
         $order->created_at = now();
         $order->save();

         if($_SESSION['cart']){
            foreach($_SESSION('cart') as $key => $cart){
                $order_details = new OrderDetails;
                $order_details->order_code = $checkout_code;
                $order_details->product_id = $cart['product_id'];
                $order_details->product_name = $cart['product_name'];
                $order_details->product_price = $cart['product_price'];
                $order_details->product_sales_quantity = $cart['product_qty'];
                $order_details->product_coupon =  $data['order_coupon'];
                $order_details->product_feeship = $data['order_fee'];
                $order_details->save();
            }
         }
         Session::forget('coupon');
         Session::forget('fee');
         Session::forget('cart');
    }
    public function del_fee(){
        Session::forget('fee');
        return redirect()->back();
    }

     public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function calculate_fee(Request $request){
        $data = $request->all();
        if($data['matp']){
            $feeship = Feeship::where('fee_matp',$data['matp'])->where('fee_maqh',$data['maqh'])->where('fee_xaid',$data['xaid'])->get();
            if($feeship){
                $count_feeship = $feeship->count();
                if($count_feeship>0){
                     foreach($feeship as $key => $fee){
                        $_SESSION['fee']=$fee->fee_feeship;
                        Session::save();
                    }
                }else{ 
                    $_SESSION['fee']=25000;
                    $_SESSION::save();
                }
            }
           
        }
    }
    public function select_delivery_home(Request $request){
        $data = $request->all();
        if($data['action']){
            $output = '';
            if($data['action']=="city"){
                $select_province = Province::where('matp',$data['ma_id'])->orderby('maqh','ASC')->get();
                    $output.='<option>---Chọn quận huyện---</option>';
                foreach($select_province as $key => $province){
                    $output.='<option value="'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
                }

            }else{

                $select_wards = Wards::where('maqh',$data['ma_id'])->orderby('xaid','ASC')->get();
                $output.='<option>---Chọn xã phường---</option>';
                foreach($select_wards as $key => $ward){
                    $output.='<option value="'.$ward->xaid.'">'.$ward->name_xaphuong.'</option>';
                }
            }
            echo $output;
        }
    }
    public function view_order($orderId){
        $this->AuthLogin();
        $order_by_id = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
        ->select('tbl_order.*','tbl_customers.*','tbl_shipping.*','tbl_order_details.*')->first();

        $manager_order_by_id  = view('admin.view_order')->with('order_by_id',$order_by_id);
        return view('admin_layout')->with('admin.view_order', $manager_order_by_id);
        
    }
    public function login_checkout(Request $request){
         //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        //seo 
        $meta_desc = "Đăng nhập thanh toán"; 
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        //--seo 

    	$cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 

    	return view('pages.checkout.login_checkout')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider',$slider);
    }
    public function add_customer(Request $request){

    	$data = array();
    	$data['customer_name'] = $request->customer_name;
    	$data['customer_phone'] = $request->customer_phone;
    	$data['customer_email'] = $request->customer_email;
    	$data['customer_password'] = md5($request->customer_password);

    	$customer_id = DB::table('tbl_customers')->insertGetId($data);

    	$_SESSION['customer_id']=$customer_id;
    	$_SESSION['customer_name']=$request->customer_name;
    	return Redirect::to('/checkout');
    }
    public function checkout(Request $request){
         //seo 
         //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $meta_desc = "Đăng nhập thanh toán"; 
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        //--seo 

    	$cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
        $city = City::orderby('matp','ASC')->get();

    	return view('pages.checkout.show_checkout')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider',$slider)->with('city',$city);
    }
    public function save_checkout_customer(Request $request){
    	$data = array();
        $data['shipping_customer_id'] = Session::get('customer_id');
    	$data['shipping_name'] = $request->shipping_name;
    	$data['shipping_phone'] = $request->shipping_phone;
        $data['city_name'] = $request->city;
    	$data['shipping_email'] = $request->shipping_email;
    	$data['shipping_notes'] = $request->shipping_notes;
    	$data['shipping_address'] = $request->shipping_address;

    	$shipping_id = DB::table('tbl_shipping')->insertGetId($data);

    	//Session::put('shipping_id',$shipping_id);
    	return Redirect::to('/payment/'.$shipping_id);
    }
    public function delete_shipping($shipping_id){
    	$shipping = Shipping::where('shipping_id',$shipping_id)->first();
		$shipping->delete();
        return Redirect()->back();
    }

    public function tinh_tien_giam(Request $request){
        $result = array("thongbao"=>"","tiengiam"=>"","thanhtien"=>"");
        $giam = DB::table('tbl_coupon')->where('coupon_code', $request->code)->first();
        if($giam)
        {
            $result['tiengiam']="Được giảm: -";
            if($giam->coupon_condition == 1)
            {
                session::put('thanhtien',$request->tiencodinh - $request->tiencodinh/$giam->coupon_number );
                $result['tiengiam'] .= number_format($request->tiencodinh/$giam->coupon_number,0,',','.');
            }
            if($giam->coupon_condition == 2)
            {
                session::put('thanhtien',$request->tinhcodinh - $giam->coupon_number );
                $result['tiengiam'] .= number_format($giam->coupon_number,0,',','.');
            }
            $result['tiengiam'].="VND";
            $result['thongbao'] = "";
        }
        else{
            $result['tiengiam']="";
            $result['thongbao'] = "Mã nhập không chính xác";
            session::put('thanhtien',$request->tiencodinh );
        }
        $result['thanhtien'] = number_format(session::get('thanhtien'),0,',','.');
        $result['thanhtien'] .= 'VND';
        return $result;

    }
    public function payment(Request $request, $shipping_id){
        //seo 
        $meta_desc = "Đăng nhập thanh toán"; 
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        $ship = DB::table('tbl_shipping')->join('tbl_tinhthanhpho','tbl_shipping.city_name','tbl_tinhthanhpho.name_city')->where('shipping_id',$shipping_id)->first();
        $slider = DB::table('tbl_slider')->orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
        //--seo 
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
        return view('pages.checkout.payment')->with('ship', $ship)->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)->with('slider',$slider);

    }
    public function order_place(Request $request){
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
        $meta_desc = "Đăng nhập thanh toán"; 
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        //--seo 
        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Đang chờ xử lí';


        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        //insert order
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = $request->shipid;
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = session::get("thanhtien");
        $order_data['order_status'] = 'Đang chờ xử lí';
        if($data['payment_method']==1){

            $order_data['phuongthuc']="Thẻ ATM";

        }elseif($data['payment_method']==2){
           
            $order_data['phuongthuc']="Tiền mặt";
        }else{
            $order_data['phuongthuc']="Thẻ ghi nợ";
        }
        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        //insert order_details
        $content = session::get("cart");
        foreach($content as $v_content){
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content['product_id'];
            $order_d_data['product_name'] = $v_content['product_name'];
            $order_d_data['product_price'] = $v_content['product_price'];
            $order_d_data['product_sales_quantity'] = $v_content['product_qty'];
            DB::table('tbl_order_details')->insert($order_d_data);
            DB::table('tbl_product')->where('product_id',$v_content['product_id'])->Decrement('product_quantity',$v_content['product_qty']);
        }

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
        Session::forget('cart');
        return Redirect::to('/handcash');
    }
    public function logout_checkout(){
    	Session::forget('customer_id');
        Session::forget('customer_name');
    	return Redirect::to('/dang-nhap');
    }
    public function login_customer(Request $request){
    	$email = $request->email_account;
    	$password = md5($request->password_account);
    	$result = DB::table('tbl_customers')->where('customer_email',$email)->where('customer_password',$password)->first();
    	
    	
    	if($result){
           
    		Session::put('customer_id',$result->customer_id);
            Session::put('customer_name',$result->customer_name);
    		return Redirect::to('/checkout');
    	}else{
    		return Redirect::to('/dang-nhap');
    	}
        Session::save();

    }
    public function manage_order(){
        
        $this->AuthLogin();
        $all_order = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->select('tbl_order.*','tbl_customers.customer_name')
        ->orderby('tbl_order.order_id','desc')->get();
        $manager_order  = view('admin.manage_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.manage_order', $manager_order);
    }
}
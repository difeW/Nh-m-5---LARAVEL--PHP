<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Feeship;
use Illuminate\Support\Facades\Redirect;
session_start();
class DeliveryController extends Controller
{
	public function update_delivery(Request $request){
		DB::table('tbl_tinhthanhpho')->where('matp', $request->matp)->update(['tien_ship'=>$request->fee_value]);
		return 1;
	}
	public function select_feeship(){
		$feeship = DB::table('tbl_tinhthanhpho')->orderby('matp','asc')->get();
		$output = '';
		$output .= '<div class="table-responsive">  
			<table class="table table-bordered">
				<thread> 
					<tr>
						<th>Mã tỉnh/thành phố</th>
						<th>Tên</th> 
						<th>Phí ship</th>
					</tr>  
				</thread>
				<tbody>
				';

				foreach($feeship as $key => $fee){

				$output.='
					<tr>
						<td>'.$fee->matp.'</td>
						<td>'.$fee->name_city.'</td>
						<td contenteditable data-matp="'.$fee->matp.'" class="fee_feeship_edit">'.number_format($fee->tien_ship,0,',','.').'</td>
					</tr>
					';
				}

				$output.='		
				</tbody>
				</table></div>
				';

				echo $output;

		
	}
	public function insert_delivery(Request $request){
		$data = $request->all();

		$fee_ship = new Feeship;

		$fee_ship->fee_matp = $data['city'];     	
		$fee_ship->fee_maqh = $data['province'];
		$fee_ship->fee_xaid = $data['wards'];
		$fee_ship->fee_feeship = $data['fee_ship'];
		$fee_ship->save();
	}
    public function delivery(Request $request){

    	$city = City::orderby('matp','ASC')->get();

    	return view('admin.delivery.add_delivery')->with(compact('city'));
    }
    public function select_delivery(Request $request){
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
}

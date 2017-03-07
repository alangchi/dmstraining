<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\DeviceInfomationRequest;
use App\DeviceStatus;
use App\Manufactory;
use App\Version;
use App\Models;
use App\Type;
use App\Os;
use Input;
use DB;
use Carbon\Carbon;

class DeviceInfomationController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user_data = \Session::get('user_data');
            if($user_data['role_name'] != 'admin'){
                return redirect('/login');
            }
            return $next($request);
        });
    }

    public function listDeviceInfo(Request $request) {
    	$search = $request->Input('search');

        Log::debug('DeviceInfomationController@listDeviceInfo :' .$search);
    	$os = DB::table('os')->get();
    	$version = DB::table('versions')->get();
    	$model = DB::table('models')->get();
    	$type = DB::table('types')->get();
    	$manufactory = DB::table('manufactories')->get();

        return view('device_infos.list', ['dv_os' => $os],['versions' => $version],['models' => $model],['types' => $type],['manufactories' => $manufactory]);
    }

    public function createDeviceInfo() {
    	return view('device_infos.add');
    }

    public function storeDeviceInfo(DeviceInfomationRequest $requests ) {

    	$deviceType = new Type();
    	$deviceType->name = Input::get('deviceType');
    	$saved = $deviceType->save();

		$deviceModel = new Models();
		$deviceModel->name = Input::get('deviceModel');
		$savedDeviceModel = $deviceModel->save();

		$deviceOs = new Os();
		$deviceOs->name = Input::get('deviceOs');
		$deviceOs->save();

    	$deviceVersion = new Version();
    	$deviceVersion->name = Input::get('deviceVersion');
    	$deviceVersion->save();

    	$deviceManufactory = new Manufactory();
    	$deviceManufactory->name = Input::get('deviceManufactory');
    	$deviceManufactory->save();

        \Session::flash('flash_message','Add Device Info Successfully!');
    	return redirect('/dashboard');
    }

    public function showDeviceInfo($device_info_id) {
    	
    }

    public function updateDeviceInfo($device_info_id) {
    	
    }

    public function destroyDeviceInfo($device_info_id) {
    	$os = Os::findOrFail($device_info_id);
	    $os->delete();
        $flash_message = [
            'flash_level'=>'success', 
            'flash_message'=> 'Delete device info successfully!'
        ];
	    return redirect('device_infos/list_device_info')->with($flash_message);
    }

}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Input;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\Response;
use App\HistoryStatus;
use App\DeviceStatus;
use App\Manufactory;
use App\History;
use App\Version;
use App\Device;
use App\Models;
use App\User;
use App\Type;
use App\Os;
use Auth;
use DB;
use Carbon\Carbon;
class DevicesController extends Controller
{
	public function __construct(Device $devices, History $history){
        $this->devices = $devices;
        $this->history = $history;
     }
    /*
    *Dvices for users
    */
    public function SeasrchDeviecs() {
        return view('borrowers/devices/dashboard');
    }

   	public function Deviecs(Request $request) {
        $defaultDevicesAvalable  = DeviceStatus::where('name',Device::DEFAULT_DEVICE_AVAILABLE)->first();
        $defaultDevicesBorrowing = DeviceStatus::where('name',Device::DEFAULT_DEVICE_UNAVAILABLE)->first();
        $defaultDevicesBroken    = DeviceStatus::where('name',Device::DEFAULT_DEVICE_BROKEN)->first();
        $defaultDevicesLost      = DeviceStatus::where('name',Device::DEFAULT_DEVICE_LOST)->first();

        //Get data to show in form
        $os          = DB::table('os')->get();
        $model       = DB::table('models')->get(); 
        $type        = Type::select('id', 'name')->get();
        $version     = Version::select('id', 'name')->get();
        $manufactory = Manufactory::select('id', 'name')->get();
        // Filter input data
        $manufatory_id = Input::get('manufactory_devices');
        $version_id    = Input::get('version_devices');
        $model_id      = Input::get('model_devices');
        $type_id       = Input::get('type_devices');
        $os_id         = Input::get('os_devices');

        $search = $request->Input('search');
        Log::debug('DevicesController@Deviecs :' .$search);
        //Show data on table
   		$listDevices   = DB::table('devices')
            ->join('manufactories', 'devices.manufatory_id', '=', 'manufactories.id')
            ->join('device_status', 'devices.status_id', '=', 'device_status.id')
            ->join('versions', 'devices.version_id', '=', 'versions.id')
            ->join('models', 'devices.model_id', '=', 'models.id')
            ->join('types', 'devices.type_id', '=', 'types.id')
            ->join('os', 'devices.os_id', '=', 'os.id')
            ->select('devices.*','types.name as type_name','manufactories.name as manufactory_name', 'versions.name as version_name', 'models.name as model_name', 'device_status.image as status_image','os.name as os_name')
            ->whereRaw(\DB::raw("(devices.id like '%{$search}%' OR devices.name like '%{$search}%' OR devices.device_code like '%{$search}%' OR devices.description like '%{$search}%')"))
            ->orderBy('devices.status_id', 'ASC');
            //Filter before search
            if(!empty($manufatory_id)) {
                $listDevices->where('devices.manufatory_id','=',$manufatory_id);
            }

            if(!empty($version_id)) {
                $listDevices->where('devices.version_id','=', $version_id);
            }

            if(!empty($type_id)) {
                $listDevices->where('devices.type_id','=', $type_id);
            }

            if(!empty($model_id)) {
                $listDevices->where('devices.model_id', $model_id);
            }

            if(!empty($os_id)) {
                $listDevices->where('devices.os_id','=', $os_id);
            }

            $listDevices = $listDevices->paginate(20);    
    
        //search devices
            if($request->ajax()){
                $output = "";
                $default_device_status = "";

                    $searchListDevices = Device::join('manufactories', 'devices.manufatory_id', '=', 'manufactories.id')
                    ->join('device_status', 'devices.status_id', '=', 'device_status.id')
                    ->join('versions', 'devices.version_id', '=', 'versions.id')
                    ->join('models', 'devices.model_id', '=', 'models.id')
                    ->join('types', 'devices.type_id', '=', 'types.id')
                    ->join('os', 'devices.os_id', '=', 'os.id')
                    ->select('devices.*','types.name as type_name','manufactories.name as manufactory_name', 'versions.name as version_name', 'models.name as model_name', 'device_status.image as status_image','os.name as os_name')
                    ->where('devices.name',  'LIKE', '%'.$request->search.'%')
                    ->orWhere('devices.device_code','LIKE', '%'.$request->search.'%')
                    ->orWhere('devices.description', 'LIKE','%'.$request->search.'%')->get();
                if($searchListDevices){
                    $No = 0;
                    foreach ($searchListDevices as $key => $searchListDevice) {

                        $No = $No + 1 ;

                        if($searchListDevice->status_id == $defaultDevicesAvalable->id){

                        $default_device_status = '<a class="btn btn-success btn-block" type="button" onclick="showAddBorrowModal'.$searchListDevice->id.'">Borrow</a>';
                        }elseif($searchListDevice->status_id == $defaultDevicesBorrowing->id){

                        $default_device_status = '<a style="font-weight: bold;">Borrowing</a>';
                        }elseif($searchListDevice->status_id == $defaultDevicesBroken->id){

                        $default_device_status = '<a style="font-weight: bold;">Broken</a>';
                        }elseif($searchListDevice->status_id == $defaultDevicesLost->id){

                        $default_device_status = '<a style="font-weight: bold;">Lost</a>';
                        }
                        
                        $output .= '<tr>'.
                                        '<td>'.$No.'</td>'.
                                        '<td>'.$searchListDevice->device_code.'</td>'.
                                        '<td>'.$searchListDevice->name.'</td>'.
                                        '<td>'.$searchListDevice->type_name.'</td>'.
                                        '<td>'.$searchListDevice->description.'</td>'.
                                        '<td>'.$searchListDevice->manufactory_name.'</td>'.
                                        '<td>'.$searchListDevice->version_name.'</td>'.
                                        '<td>'.$searchListDevice->model_name.'</td>'.
                                        '<td>'.$searchListDevice->os_name.'</td>'.
                                        '<td>'.'<img src="/uploads/'.$searchListDevice->status_image.'" alt="" height ="20px" width ="20px" />'.'</td>'.
                                        '<td>'.$default_device_status.'</td>'.
                                    '</tr>';

                    }
                    return Response($output);
                    }
                }else{

                return view('borrowers/devices/dashboard', compact('listDevices', 'type', 'os','model', 'version', 'manufactory', 'defaultDevicesAvalable', $defaultDevicesAvalable, 'defaultDevicesBorrowing', $defaultDevicesBorrowing, 'defaultDevicesBroken', $defaultDevicesBroken , 'defaultDevicesLost',$defaultDevicesLost));
   	        }
    }

    /*
    *Histories for users
    */
    public function getSearchHistories(Request $request) {
        return view('borrowers/devices/histories');
    }
   	public function getHistories(Request $request) {
        $defaultRequestDevice   = HistoryStatus::where('name',History::DEFAULT_HIS_REQUEST)->first();
        $defaultBorrowedDevice  = HistoryStatus::where('name',History::DEFAULT_HIS_BORROWED)->first();
        $defaultWarningDevice   = HistoryStatus::where('name',History::DEFAULT_HIS_WARNING)->first();
        $defaultReturnedDevice  = HistoryStatus::where('name',History::DEFAULT_HIS_RETURNED)->first();
        $defaultLostDevice      = HistoryStatus::where('name',History::DEFAULT_HIS_LOST)->first();
        $defaultCancelledDevice = HistoryStatus::where('name',History::DEFAULT_HIS_CANCELLED)->first();

   		$user   = Auth::User();    
        $userId = $user->id;
        $search = $request->Input('search');

    	$histories = DB::table('histories')
            ->join('devices', 'histories.device_id', '=', 'devices.id')
            ->join('history_status', 'histories.status_id', '=', 'history_status.id')
            ->join('users', 'histories.user_id', '=', 'users.id')
            ->join('types', 'devices.type_id', '=', 'types.id')
            ->join('manufactories', 'devices.manufatory_id', '=', 'manufactories.id')
            ->join('versions', 'devices.version_id', '=', 'versions.id')
            ->join('models', 'devices.model_id', '=', 'models.id')
            ->join('os', 'devices.os_id', '=', 'os.id')
            ->select('histories.*','history_status.image as status_image', 'users.full_name as username', 'devices.name as device_name','devices.description as device_description', 'devices.device_code as device_code','types.name as type_name','manufactories.name as manufactory_name', 'versions.name as version_name', 'models.name as model_name','os.name as os_name','history_status.id as history_status_id')
            ->whereRaw(\DB::raw("(histories.id like '%{$search}%' OR histories.start_at like '%{$search}%' OR histories.end_at like '%{$search}%' OR histories.user_id like '%{$search}%')"))
            ->where('user_id', $userId)->paginate(20);

            //Live search ajax
            if($request->ajax()) {
                $output = "";
                $default_history_status = "";
                $default_history_action = "";
                $history_search = History::join('devices', 'histories.device_id', '=', 'devices.id')
                    ->join('history_status', 'histories.status_id', '=', 'history_status.id')
                    ->join('users', 'histories.user_id', '=', 'users.id')
                    ->join('types', 'devices.type_id', '=', 'types.id')
                    ->join('manufactories', 'devices.manufatory_id', '=', 'manufactories.id')
                    ->join('versions', 'devices.version_id', '=', 'versions.id')
                    ->join('models', 'devices.model_id', '=', 'models.id')
                    ->join('os', 'devices.os_id', '=', 'os.id')
                    ->select('histories.*','history_status.image as status_image', 'users.full_name as username', 'devices.name as device_name','devices.description as device_description', 'devices.device_code as device_code','types.name as type_name','manufactories.name as manufactory_name', 'versions.name as version_name', 'models.name as model_name','os.name as os_name','history_status.id as history_status_id')
                    ->where('histories.start_at',  'LIKE', '%'.$request->search.'%')
                    ->orWhere('histories.end_at',  'LIKE', '%'.$request->search.'%')
                    ->where('user_id', $userId)->paginate(20);

                if($history_search) {

                    $No = 0;
                    foreach ($history_search as $key => $history_search_value) {
                        $No++;

                        $t1    = strtotime($history_search_value->end_at);
                        $today = date("Y-m-d"); 
                        $t2    = strtotime($today);

                        // $default_device_status
                        if(($t2 > $t1) && ($history_search_value->status_id == $defaultRequestDevice->id)){
                            $default_device_status ='<img src="/uploads/icon-warning.png" alt="" height ="20px" width ="20px"/>';
                        }elseif(($t2 > $t1) && ($history_search_value->status_id == $defaultReturnedDevice->id)){
                            $default_device_status ='<img src="/uploads/'.$history_search_value->status_image.'" alt="" height ="20px" width ="20px" />';
                        }else{
                            $default_device_status ='<img src="/uploads/'.$history_search_value->status_image .'" alt="" height ="20px" width ="20px" />';
                        }

                        // $default_device_action
                        if($history_search_value->status_id == $defaultRequestDevice->id){
                            $default_history_action ='<a style="font-weight: bold;">Requesting</a>';
                        }elseif($history_search_value->status_id == $defaultBorrowedDevice->id){
                            $default_history_action ='<a style="font-weight: bold;">Borrowing</a>';
                        }elseif($history_search_value->status_id == $defaultWarningDevice->id){
                            $default_history_action ='<a class="btn btn-warning" type="button" onclick="showPopup('.$history_search_value->id .','. $history_search_value->start_at .', '. $history_search_value->end_at .')">Update</a> ';
                        }elseif($history_search_value->status_id == $defaultReturnedDevice->id){
                            $default_history_action ='<a style="font-weight: bold;">Returned</a>';
                        }elseif($history_search_value->status_id == $defaultLostDevice->id){
                            $default_history_action ='<a style="font-weight: bold;">Lost</a>';
                        }else{
                            $default_history_action ='<a style="font-weight: bold;">Cenceled</a>';
                        }

                        if(strtotime($today) > strtotime($history_search_value->end_at) && (($history_search_value->status_id == $defaultRequestDevice->id) || ($history_search_value->status_id == $defaultBorrowedDevice->id))){
                            $default_history_action ='<a class="btn btn-warning" type="button" onclick="showPopup('.$history_search_value->id.','. $history_search_value->start_at .', '. $history_search_value->end_at .')">Update</a> ';
                        }

                        $output .= '<tr>'.
                                        '<td>'.$No.'</td>'.
                                        '<td>'.$history_search_value->username.'</td>'.
                                        '<td>'.$history_search_value->device_code.'</td>'.
                                        '<td>'.$history_search_value->device_name.'</td>'.
                                        '<td>'.$history_search_value->type_name.'</td>'.
                                        '<td>'.$history_search_value->os_name.'</td>'.
                                        '<td>'.$history_search_value->model_name.'</td>'.
                                        '<td>'.$history_search_value->version_name.'</td>'.
                                        '<td>'.$history_search_value->device_description.'</td>'.
                                        '<td>'.$history_search_value->manufactory_name.'</td>'.
                                        '<td>'.$history_search_value->start_at.'</td>'.
                                        '<td>'.$history_search_value->end_at.'</td>'.
                                        '<td>'.$default_device_status.'</td>'.
                                        '<td>'.$default_history_action.'</td>'.
                                    '</tr>';

                    }
                    return Response($output);
                }

            }else{

        return view('borrowers/devices/histories', compact('histories', 'defaultRequestDevice',$defaultRequestDevice , 'defaultBorrowedDevice', $defaultBorrowedDevice, 'defaultWarningDevice',$defaultWarningDevice, 'defaultReturnedDevice',$defaultReturnedDevice, 'defaultLostDevice', $defaultLostDevice, 'defaultCancelledDevice', $defaultCancelledDevice));
        }
   	}

   	//Borrows devices to request device (users)
    public function postBorrow($deviceId, Request $request) {
    	$user    = Auth::User();
    	$message = 'Error';
        $device  = Device::find($deviceId);
        $defaultRequestDevice = HistoryStatus::where('name',History::DEFAULT_HIS_REQUEST)->first();

        $histories = DB::table('histories')
            ->join('devices', 'histories.device_id', '=', 'devices.id')
            ->join('history_status', 'histories.status_id', '=', 'history_status.id')
            ->join('users', 'histories.user_id', '=', 'users.id')
            ->select('histories.id')
            ->where('user_id', $user->id)
            ->where('device_id', $device->id)
            ->where('histories.status_id', $defaultRequestDevice->id)->get();

        if(!count($histories)){
            try {
                if($request->ajax()) {
                    $start = request()->get('start');
                    $end   = request()->get('end');

                    $history = new History();
                    $history->start_at  = $start;
                    $history->end_at    = $end;
                    $history->status_id = $defaultRequestDevice->id;//request to device
                    $history->device_id = $deviceId;
                    $history->user_id   = $user->id;
                    $history->save();
                    return response()->json(
                    [
                        'status' => 200, 
                        'message'=> 'Post to borrower successfully!',
                        'data'   => $history
                    ]);
                }
            } catch(\Exception $e){
                $message = $e->getMessage();
            }
            return response()->json(
            [
                'status' => false, 
                'message' => $message
            ]);

        }else{
            return response()->json(
            [
                'status' => 404, 
                'message'=> 'Sorry! You just request only one time!',
                'data'   => (object)[]
            ]);
        }
    }
    //Update timeline to borrow device (users)
    public function updateTimeline(Request $request, $hId) {
        $user    = Auth::User();
        $history  = $this->history->find($hId);
        $defaultRequest = HistoryStatus::where('name',History::DEFAULT_HIS_REQUEST)->first();

        $message = 'Error';
        try {
            if($request->ajax()) {
              $end = $request->input('end_at');
              $device_id = $history->device_id;
              $start_at  = $history->start_at;
              $history->end_at    = $end;
              $history->status_id = $defaultRequest->id;//request to device
              $history->user_id   = $user->id;
              $history->save();
              Log::debug('DevicesController@Deviecs' .$history);

              return response()->json(['status' => true, 'message' => 'OK']);
            }
        } catch(\Exception $e){
            $message = $e->getMessage();
        }
        return response()->json(['status' => false, 'message' => $message]);
    }


}

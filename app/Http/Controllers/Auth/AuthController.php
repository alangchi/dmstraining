<?php 

namespace App\Http\Controllers\Auth;
use App\User;
use Input;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/
	 protected $redirectTo = '/users/list_users';
	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	public function editProfiles($id) {
		$currentUser = User::whereId($id)->firstOrFail();

		return view('auth/profiles', compact('currentUser'));
	}

	public function postEditProfiles($id, Request $updates) {
		$users  = User::whereId($id)->firstOrFail();
	    $this->validate($updates, [
	    	'full_name'             => 'required',
	    	'username'              => 'required|max:255',
            'email'                 => 'required|email|max:255|unique:users',
	        'old_password'          => 'required',
	        'password'              => 'required|min:4',
	        'password_confirmation' => 'required|same:password'
	    ]);

	    $role_id = Auth::user()->role_id;
	    if($users) {
	    	$users->full_name      = $updates->get('full_name');
		    $users->username       = $updates->get('username');
		    $users->email          = $updates->get('email');
		    $users->password       = bcrypt($updates->get('password'));
		    $users->role_id        = $role_id;
	        $users->remember_token = $updates->get('remember_token');
		    $checkPassword         = ['email' => Auth::user()->email, 'password' => Input::get('old_password')];
		    $users->save();
		    return redirect('/users/list_users');
	    }else{
	    	return Redirect::to('/editProfiles/{id}')->with('flash_message', 'The following errors occurred')->withErrors($validator)->withInput();
	    }
	    
	    
	}
}

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;


class UserController extends Controller {
	
	public function index() {
		// $data['countries'] = Country::get(["name","id"]);
		// return view('country-state-city',$data);
		return view('user');
	}

	public function add(Request $request) {   

		// echo "<pre>";
		// print_r($request->all());
		// exit();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email'
        ]);

        if($validator->fails()) {
			// return response()->json($validator->errors());
        }

        $user = [
            'name' => $request->name,
            'email' => $request->email,
            'parentId' => (!empty($request->officer)) ? $request->officer : '0',
            'birthdate' => date('Y-m-d', strtotime($request->dateOfBirth)),
            'skills' => implode(',', $request->skills)
        ];

        $addUser = User::create($user);
        // $lastId = $addUser->id;

        if($addUser){
			return json_encode(array( "statusCode"=>200) );
        }else{
		    return json_encode(array( "statusCode"=> 401 ) );
        }
    }

    public function fetchUsers(){
		$users = User::all();
		return json_encode($users);
    }

    public function fetchChildCount($parentId) {
        $childUser = User::where('parentId', '=', $parentId)->get();
        return $childUser->count();
    }

    public function fetchChildUsers($parentId) {
        $childUser = User::where('parentId', '=', $parentId)->get();
        return json_encode($childUser);
    }
}

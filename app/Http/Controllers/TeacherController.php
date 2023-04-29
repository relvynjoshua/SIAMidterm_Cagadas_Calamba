<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

Class TeacherController extends Controller {
    private $request;
    public function __construct(Request $request){
        $this->request = $request;
    }
    public function getUsers(){
        $users = User::all();
        return response()->json(['data' => $users], 200);
    }
    
    public function index()
    {
        $users = User::all();
        return $this->successResponse($users);  
    }

    public function add(Request $request ){
        
        $rules = [
            'lastname' => 'required|max:50',
            'firstname' => 'required|max:50',
            'middlename' => 'required|max:50',
            'age' => 'required|max:8'
        ];

        $this->validate($request,$rules);

        $user = User::create($request->all());
        return $this->json($user, 200);
    }

    public function updateUser(Request $request, $id) {
        $rules = [
            'lastname' => 'required|max:50',
            'firstname' => 'required|max:50',
            'middlename' => 'required|max:50',
            'age' => 'required|max:8'
        ];
    
        $this->validate($request, $rules);
    
        $user = User::findOrFail($id);
    
        $user->fill($request->all());
    
        if ($user->isClean()) {
            return response()->json("At least one value must
            change", 403);
        } else {
            $user->save();
            return response()->json($user, 200);
        }
    }

    public function deleteUser($id) {
        $user = User::findOrFail($id);

        if ($user) {
            $user->delete();

            return response()->json($user, 200);
        } else {
            return response()->json("User Not Found", 404);
        }
    }
    public function show($id) {
        $user = User::findorFail($id);
        return $this->sucessResponse($user);
    }
}
    


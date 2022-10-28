<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\ApiController\ResultType;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        #return response()->json(Product::all(),200);
        #return response(Product::paginate(10),200);

        $offset = $request->has('offset') ? $request->query('offset'):0;
        $limit = $request->has('limit') ? $request->query('limit'):10;
        
        $queryBuilder = User::query();
        if($request->has('q'))
            $queryBuilder->where('name','like','%'.$request->query('q').'%');
        
        if($request->has('sortBy'))
            $queryBuilder->orderBy($request->query('sortBy'),$request->query('sort','DESC'));

        $data = $queryBuilder->offset($offset)->limit($limit)->get();
        return response($data,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|unique:users',
            'name' => 'required|string|max:50',
            'password' =>'required'
        ]
        );

        if($validator->fails())
            return $this->apiResponse(ResultType::Error,$validator->errors(),'Validation Error!', 422);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->email_verified_at = now();
        $user->password = bcrypt($request->password);
        $user->save();

        return response([
            'data'=> $user,
            'message' =>"User created."

        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if($user){
            return response($user,200);
        }else{
            return response(['message'=>'User Not Found'],404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        return response([
            'data'=> $user,
            'message' =>"User updated."

        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response([
            'message' =>"User deleted."

        ],200);
    }
}

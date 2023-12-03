<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.modules.user.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getUsers(Request $request)
    {
        $query = User::where("status", "!=", 3);
        $search = $request->search ? $request->search : "";
        $take = (int) $request->take;

        // search email, phone ,name 
        $query = $query->where(function ($query) use ($search) {
            $query->where("full_name", "like", "%" . $search . "%")
                ->orWhere("email", "like", "%" . $search . "%")
                ->orWhere("phone", "like", "%" . $search . "%");
        });

        $result = $query->orderBy("created_at", "desc")->paginate($take);
        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $result]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = new User();
        $data->full_name = $request->full_name;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->level = $request->level;
        $data->status = $request->status;
        $data->address = $request->address;
        $data->phone = $request->phone;
        $data->save();
        return redirect()->route("admin.user.index")->with("success", "Create user successful");

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::findOrfail($id);


        return view("admin.modules.user.edit", ["data" => $data, 'id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $user = User::findOrfail($id);
        if (!empty($request->password)) {
            $request->validate([
                "password" => "min:8",
                "confirmation_password" => "required|same:password",
            ]);
            $data["password"] = bcrypt($request->password);
        }
        $user->full_name = $request->full_name;
        $user->phone = $request->phone;
        $user->status = $request->status;
        $user->level = $request->level;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->save();
        return redirect()->route('admin.user.index')->with('success', 'Edit success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrfail($id);
        $user->status = 3;
        $user->save();
        return redirect()->route('admin.user.index')->with('success', 'Delete success');
    }
}

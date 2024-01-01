<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WeighTag;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WeightTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $weights = WeighTag::orderBy("mass", "ASC")->paginate(10);
        return view("admin.modules.weight-tag.index", ["weights" => $weights]);
    }

    public function create()
    {
        return view("admin.modules.weight-tag.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mass' => 'required|numeric',
        ]);
        $weight = new WeighTag();

        $weight->mass = $request->mass;
        $weight->save();
        return redirect()->route("admin.weight-tag.index")->with("success", "Create success!");
    }

    public function edit(string $id)
    {
        $data = WeighTag::findOrFail($id);
        return view("admin.modules.weight-tag.edit", ["data" => $data, "id" => $id]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'mass' => 'required|numeric',
        ]);
        $weight = WeighTag::findOrFail($id);


        $weight->mass = $request->mass;
        $weight->update();

        return redirect()->route("admin.weight-tag.index")->with("success", "Create success!");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $weight = WeighTag::findOrFail($id);
        $weight->delete();
        return redirect()->route("admin.weight-tag.index")->with("success", "Delete success!");
    }
}

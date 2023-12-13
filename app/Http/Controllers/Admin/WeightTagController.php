<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WeighTag;
use Illuminate\Http\Request;

class WeightTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $weights = WeighTag::get();
        return view("admin.modules.other.weight-tag.index", ["weights" => $weights]);
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
        return redirect()->route("admin.other.weight-tag.index")->with("success", "Create success!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $weight = WeighTag::findOrFail($id);
        $weight->delete();
        return redirect()->route("admin.other.weight-tag.index")->with("success", "Delete success!");
    }
}

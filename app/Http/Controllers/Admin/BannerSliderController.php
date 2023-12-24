<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerAndSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BannerSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliderBanner = BannerAndSlide::paginate(10);
        return view("admin.modules.slider-banner.index", ["sliderBanner" => $sliderBanner]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.modules.slider-banner.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            "image" => "mimes:png,jpg",
        ]);

        $data = new BannerAndSlide();

        $data->title = $request->title;
        $data->description = $request->description;
        $data->status = $request->status;
        $data->position = $request->position;
        $data->created_at = Carbon::now();
        $data->updated_at = Carbon::now();
        if (isset($request->image)) {
            $filename = rand(1, 10000) . time() . "." . $request->image->getClientOriginalName();
            $request->image->move(public_path("uploads"), $filename);
            $data->image = route("uploads") . "/" . $filename;
        }
        $data->save();
        return redirect()->route("admin.slider-banner.index")->with("success", "Create success!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = BannerAndSlide::findOrFail($id);
        return view("admin.modules.slider-banner.edit", ["data" => $data, "id" => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            "image" => "mimes:png,jpg",
        ]);

        $data = BannerAndSlide::findOrFail($id);

        $data->title = $request->title;
        $data->description = $request->description;
        $data->status = $request->status;
        $data->position = $request->position;
        $data->updated_at = Carbon::now();
        if (isset($request->image)) {
            $file = $data->image ? public_path("uploads/") . $data->image : "";

            if (file_exists($file)) {
                unlink($file);
            }

            $filename = rand(1, 10000) . time() . "." . $request->image->getClientOriginalName();
            $request->image->move(public_path("uploads"), $filename);
            $data->image = route("uploads") . "/" . $filename;
        }
        $data->save();
        return redirect()->route("admin.slider-banner.index")->with("success", "Update success!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = BannerAndSlide::findOrFail($id);
        $data->delete();
        return redirect()->route('admin.slider-banner.index')->with("success", "Delete product success!");
    }
}

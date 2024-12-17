<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\File;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carousels = Carousel::paginate(5);
        return view('backend.Carousels.index', compact('carousels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $files = File::paginate(9);
        return view('backend.Carousels.create', compact('files'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $carousel = new Carousel;
        $validate_data = $request->validate([
            'title' => 'required',
            'sub_title' => 'required',

            'img' => 'required'
        ]);
        $carousel->title = $validate_data['title'];
        $carousel->sub_title = $validate_data['sub_title'];

        $carousel->img = $validate_data['img'];
        $carousel->save();
        return redirect('admin/carousels')->with('success', 'Your data have been submitted');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $carousels = new Carousel;
        $carousels = $carousels->where('id', $id)->First();
        $files = File::paginate(9);
        return view('backend.Carousels.show', compact('carousels', 'files'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $carousels = new Carousel;
        $carousels = $carousels->where('id', $id)->First();
        $files = File::paginate(9);
        return view('backend.Carousels.edit', compact('carousels', 'files'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $carousel = new Carousel;
        $carousel = $carousel->where('id', $id)->First();
        $validate_data = $request->validate([
            'title' => 'required',
            'sub_title' => 'required',
            'img' => 'required'
        ]);
        $carousel->title = $validate_data['title'];
        $carousel->sub_title = $validate_data['sub_title'];

        $carousel->img = $validate_data['sub_title'];

        $carousel->update();
        return redirect('admin/carousels')->with('success', 'Your data have been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $carousels = new Carousel;
        $carousels = $carousels->where('id', $id)->First();
        $carousels->delete();
        return redirect('admin/carousels')->with('success', 'Your data have been deleted');
    }
}

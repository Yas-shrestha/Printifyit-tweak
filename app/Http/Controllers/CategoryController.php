<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\File;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::query()->paginate(10);

        return view('backend.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $files = File::query()->paginate(10);
        return view('backend.category.create', compact('files'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $category = new Category;
        $request->validate([
            'name' => 'string|required',
            'img' => 'required'
        ]);
        $category->name = $request->name;
        $category->img_id = $request->img;
        $category->save();
        return redirect('admin/categories')->with('success', 'Your data have been updated');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = new Category;
        $category = $category->where('id', $id)->First();
        return view('backend.category.create', compact('files', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $files = File::query()->paginate(10);
        return view('backend.category.create', compact('files', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = new Category;
        $category = $category->where('id', $id)->First();
        $request->validate([
            'name' => 'string|required',
            'img' => 'required'
        ]);
        $category->name = $request->name;
        $category->img_id = $request->img;
        $category->save();
        return redirect('admin/categories')->with('success', 'Your data have been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = new Category;
        $category = $category->where('id', $id)->First();
        $category->delete();
        return redirect('/admin/category')->with('success', 'Your data has been deleted');
    }
}

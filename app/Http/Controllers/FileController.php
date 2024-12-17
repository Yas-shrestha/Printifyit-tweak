<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as Files;
use Illuminate\Support\Str;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = new File;
        $files = $files->paginate(4);
        return view('backend.FileManager.index', compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.FileManager.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = new File;
        $request->validate([
            'img' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'title' => 'required|max:100'
        ]);
        $fileName = Str::slug($request->title)  . '-' . time() . '.' . $request->img->extension();
        $request->img->move(public_path('uploads'), $fileName);
        $file->title = $request->title;
        $file->img = $fileName;

        $file->save();
        return redirect('/admin/file')->with('success', 'Your data is submitted ');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $file = new File;
        $file = $file->where('id', $id)->First();
        return view('backend.FileManager.show', compact('file'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $file = new File;
        $file = $file->where('id', $id)->First();
        return view('backend.FileManager.edit', compact('file'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'img' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'title' => 'required|max:100'
        ]);
        $file = new File;
        $file = $file->where('id', $id)->First();
        $file->title = $request->title;
        if ($request->img != NULL) {
            $fileName = Str::slug($request->title) . "-" . time() . '.' . $request->img->extension();
            Files::delete(public_path('uploads/' . $file->img));
            $request->img->move(public_path('uploads'), $fileName);
            $file->img = $fileName;
        }
        $file->update();
        return redirect('admin/file')->with('success', 'Your data have been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $file = File::find($id);
        Files::delete(public_path('uploads/' . $file->img));
        $file->delete();
        return redirect('/admin/file')->with('success', 'Your data has been deleted');
    }
}

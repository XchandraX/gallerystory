<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\foto;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * Tampilkan form upload foto.
     */
    public function create()
    {
        $categories = category::all();
        return view('upload', compact('categories'));
    }

    /**
     * Proses upload satu atau banyak foto.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required',
            'category_id' => 'required|exists:categories,id',
            'is_private'  => 'required|in:public,private',
            'image.*'     => 'required|image|max:2048', // per file max 2MB
        ]);

        foreach ($request->file('image') as $file) {
            $path = $file->store('photos', 'public');

            foto::create([
                'title'       => $request->title,
                'category_id' => $request->category_id,
                'is_private'  => $request->is_private,
                'image'       => $path,
            ]);
        }

        return back()->with('success', 'Photos uploaded successfully!');
    }
}
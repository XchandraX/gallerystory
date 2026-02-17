<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Tampilkan semua kategori (halaman depan).
     */
    public function index()
    {
        $categories = Category::all();

        return view('index', compact('categories'));
    }

    /**
     * Tampilkan form tambah kategori.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Simpan kategori baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'slug' => 'required|unique:categories,slug',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return redirect('/')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * Tampilkan foto-foto dalam kategori tertentu (hanya public).
     */
    public function show($slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $query = $category->fotos()->where('is_private', 'public');

        // Sorting
        $sort = $request->get('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $photos = $query->paginate(12);

        if ($request->wantsJson()) {
            return response()->json([
                'photos' => $photos->map(fn ($p) => [
                    'title' => $p->title,
                    'image_url' => asset('storage/'.$p->image),
                ]),
                'next_page' => $photos->currentPage() + 1,
                'has_more' => $photos->hasMorePages(),
            ]);
        }

        return view('kategori.index', compact('category', 'photos', 'sort'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Paginator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->when(request()->q, function ($posts) {
            $posts = $posts->where('title', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::latest()->get();
        return view('admin.post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:1000',
            'title' => 'required',
            'category_id' => 'required',
            'description' => 'required'
        ], [
            'image.required' => 'Gambar harus diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'title.required' => 'Judul harus diisi.',
            'category_id.required' => 'Kategori harus dipilih.',
            'description.required' => 'Deskripsi harus diisi.'
        ]);

        // Proses dan unggah gambar
        $image = $request->file('image');
        $filename = $this->storeImage($image);

        // Create post
        $post = Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'content' => $request->content,
            'user_id' => auth()->user()->id,
            'image' => $filename,
            'pub_date' => $request->pub_date,
        ]);

        if ($post) {
            // Redirect dengan pesan sukses
            return redirect()->route('admin.post.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            // Redirect dengan pesan error
            return redirect()->route('admin.post.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::latest()->get();
        return view('admin.post.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'image' => 'image|mimes:jpeg,jpg,png,webp|max:1000',
            'title' => 'required',
            'category_id' => 'required',
            'description' => 'required'
        ], [
            'image.image' => 'File harus berupa gambar.',
            'title.required' => 'Judul harus diisi.',
            'category_id.required' => 'Kategori harus dipilih.',
            'description.required' => 'Deskripsi harus diisi.'
        ]);

        // Check jika image kosong
        if ($request->file('image') == '') {
            // Update data tanpa image
            $post->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title, '-'),
                'category_id' => $request->category_id,
                'description' => $request->description,
                'content' => $request->content,
                'user_id' => auth()->user()->id,
                'pub_date' => $request->pub_date,
            ]);
        } else {
            // Hapus image lama
            Storage::disk('local')->delete('public/posts/' . $post->image);

            // Proses dan unggah gambar baru
            $image = $request->file('image');
            $filename = $this->storeImage($image);

            // Update dengan image baru
            $post->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title, '-'),
                'category_id' => $request->category_id,
                'description' => $request->description,
                'content' => $request->content,
                'user_id' => auth()->user()->id,
                'image' => $filename,
                'pub_date' => $request->pub_date,
            ]);
        }

        if ($post) {
            // Redirect dengan pesan sukses
            return redirect()->route('admin.post.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            // Redirect dengan pesan error
            return redirect()->route('admin.post.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        Storage::disk('local')->delete('public/posts/' . $post->image);
        $post->delete();

        return response()->json([
            'status' => $post ? 'success' : 'error'
        ]);
    }

    /**
     * Helper function untuk penyimpanan gambar.
     *
     * @param  \Illuminate\Http\UploadedFile  $image
     * @return string
     */
    private function storeImage($image)
    {
        $path = $image->storeAs('public/posts', $image->hashName());
        return basename($path);
    }

    public function massDestroy(Request $request)
    {
        $ids = $request->ids;

        $posts = Post::whereIn('id', $ids)->get();

        foreach ($posts as $post) {
            Storage::disk('local')->delete('public/posts/' . $post->image);
            $post->delete();
        }

        return response()->json(['status' => 'success']);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogsController extends Controller
{
    public function index()
    {
        $blogs = Blog::paginate(10);
        return view('admins.Blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admins.Blogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable',
            'content' => 'nullable',
            'status' => 'required',
        ]);

        $data = $request->except(['_token', '_method']);
        if ($request->hasFile('image')) {
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/blogs'), $fileName);
            $data['image'] = 'images/blogs/' . $fileName;
        }

        Blog::create($data);
        return redirect()->route('admin.blogs.index')->with('success', 'Thêm mới thành công!');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admins.Blogs.edit', compact('blog', 'id'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable',
            'content' => 'nullable',
            'status' => 'required',
        ]);

        $blog = Blog::findOrFail($id);
        
        $data = $request->except(['_token', '_method']);
        if ($request->hasFile('image')) {
            if ($blog->image && file_exists(public_path($blog->image))) {
                unlink(public_path($blog->image));
            }
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/blogs'), $fileName);
            $data['image'] = 'images/blogs/' . $fileName;
        }

        $blog->update($data);
        return redirect()->route('admin.blogs.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        if ($blog->image && file_exists(public_path($blog->image))) {
            unlink(public_path($blog->image));
        }
        $blog->delete();
        return redirect()->route('admin.blogs.index')->with('success', 'Xóa thành công!');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            
            $request->file('upload')->move(public_path('images/blogs'), $fileName);
            
            $url = asset('images/blogs/' . $fileName);
            
            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
        }
    }
}
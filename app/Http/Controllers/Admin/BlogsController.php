<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->paginate(7);

        return view('admin.blog.home', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'content' => 'required|string',
            'status' => 'required|in:0,1',
        ], [
            'title.required' => 'Tiêu đề không được để trống',
            'image.required' => 'Vui lòng chọn ảnh đại diện',
            'image.image' => 'File phải là hình ảnh',
            'content.required' => 'Nội dung bài viết không được để trống',
            'status.required' => 'Vui lòng chọn trạng thái',
        ]);

        $blog = new Blog;
        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->status = 1;

        // Xử lý ảnh
        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('images/blogs'), $imageName);

            // Lưu đường dẫn tương đối
            $blog->image = 'images/blogs/'.$imageName;
        }

        $blog->save();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Thêm bài viết thành công!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);

        return view('admin.blog.update', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'content' => 'required|string',
            'status' => 'required|in:0,1',
        ], [
            'title.required' => 'Tiêu đề không được để trống',
            'image.image' => 'File phải là hình ảnh',
            'image.mimes' => 'Ảnh phải có định dạng jpg, jpeg, png hoặc webp',
            'content.required' => 'Nội dung bài viết không được để trống',
            'status.required' => 'Vui lòng chọn trạng thái',
        ]);

        $blog = Blog::findOrFail($id);

        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->status = $request->status;

        // Nếu có upload ảnh mới
        if ($request->hasFile('image')) {

            // Xóa ảnh cũ nếu tồn tại
            if (! empty($blog->image) && file_exists(public_path($blog->image))) {
                unlink(public_path($blog->image));
            }

            // Upload ảnh mới
            $image = $request->file('image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('images/blogs'), $imageName);

            $blog->image = 'images/blogs/'.$imageName;
        }

        $blog->save();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Cập nhật bài viết thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        // Xóa ảnh nếu có
        if (! empty($blog->image) && file_exists(public_path($blog->image))) {
            unlink(public_path($blog->image));
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Xóa bài viết thành công!');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {

            $file = $request->file('upload');
            $fileName = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('images/blogs'), $fileName);

            return response()->json([
                'url' => '/images/blogs/'.$fileName,
            ]);
        }

        return response()->json([
            'error' => [
                'message' => 'Upload failed',
            ],
        ], 400);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tree = Category::with('children')->whereNull('category_id')->orderBy('id', 'desc')->get();

        return view('admin.category.home', compact('tree'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with('children')->get();
        return view('admin.category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'category_id' => 'nullable|exists:categories,id', // parent field?
            'parent_id' => 'nullable|exists:categories,id',
            'link' => 'nullable|string|max:255',
            'status' => 'nullable|integer',
        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'name.unique' => 'Tên danh mục đã tồn tại',
        ]);
        
        $data['status'] = $request->has('status') ? $request->status : 1;
        // In case they submit using parent_id, map it or save both. 
        if(isset($data['parent_id']) && !isset($data['category_id'])) {
            $data['category_id'] = $data['parent_id'];
        }

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Thêm danh mục thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::with('children')->findOrFail($id);
        $categories = Category::where('id', '!=', $id)->with('children')->get();

        return view('admin.category.update', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$id,
            'category_id' => 'nullable|exists:categories,id',
            'parent_id' => 'nullable|exists:categories,id',
            'link' => 'nullable|string|max:255',
            'status' => 'nullable|integer',
        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'name.unique' => 'Tên danh mục đã tồn tại',
        ]);

        $data['status'] = $request->has('status') ? $request->status : 1;
        if(isset($data['parent_id']) && !isset($data['category_id'])) {
            $data['category_id'] = $data['parent_id'];
        }

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Cập nhật danh mục thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return back()->with('success', 'Xóa thành công');
    }

    public function reorder(Request $req)
    {
        return response()->json(['status' => 'Feature requires nestedset package']);
    }
}

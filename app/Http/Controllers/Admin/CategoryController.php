<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tree = Category::get()->toTree();

        return view('admins.Categories.index', compact('tree'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $flat = Category::defaultOrder()->get()->toTree();

        return view('admins.Categories.create', compact('flat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'parent_id' => 'nullable|exists:categories,id',
            'link' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'name.unique' => 'Tên danh mục đã tồn tại',
            'parent_id.exists' => 'Danh mục cha không hợp lệ',
        ]);

        $cat = new Category($data);
        if (! empty($data['parent_id'])) {
            $parent = Category::find($data['parent_id']);
            $parent->appendNode($cat);
        } else {
            $cat->saveAsRoot();
        }

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::with('children')->findOrFail($id);
        $flat = Category::with('children')->whereNull('parent_id')->get();

        return view('admins.Categories.edit', compact('category', 'flat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'link' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'name.unique' => 'Tên danh mục đã tồn tại',
            'parent_id.exists' => 'Danh mục cha không hợp lệ',
        ]);

        $category->fill($data)->save();

        // Xử lý cây danh mục (nested set)
        if (isset($data['parent_id'])) {

            // Nếu có parent và khác parent hiện tại
            if ($data['parent_id'] && $data['parent_id'] != $category->parent_id) {
                $parent = Category::find($data['parent_id']);
                $parent->appendNode($category);
            }
            // Nếu chọn về gốc
            elseif (! $data['parent_id']) {
                $category->saveAsRoot();
            }
        }

        return redirect()->route('categories.index')
            ->with('success', 'Cập nhật danh mục thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return back();
    }

    public function reorder(Request $req)
    {
        $req->validate(['tree' => 'required|array']);
        Category::rebuildTree($req->input('tree'));

        return response()->json(['status' => 'ok']);
    }
}

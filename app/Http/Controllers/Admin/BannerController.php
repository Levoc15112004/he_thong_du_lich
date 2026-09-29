<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::paginate(10);
        return view('admins.Banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admins.Banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable',
            'link' => 'required',
        ]);

        $data = $request->except(['_token', '_method']);
        if ($request->hasFile('image')) {
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/banners'), $fileName);
            $data['image'] = 'images/banners/' . $fileName;
        }

        Banner::create($data);
        return redirect()->route('admin.banners.index')->with('success', 'Thêm mới thành công!');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admins.Banners.edit', compact('banner', 'id'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable',
            'link' => 'required',
        ]);

        $banner = Banner::findOrFail($id);
        
        $data = $request->except(['_token', '_method']);
        if ($request->hasFile('image')) {
            if ($banner->image && file_exists(public_path($banner->image))) {
                unlink(public_path($banner->image));
            }
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/banners'), $fileName);
            $data['image'] = 'images/banners/' . $fileName;
        }

        $banner->update($data);
        return redirect()->route('admin.banners.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        if ($banner->image && file_exists(public_path($banner->image))) {
            unlink(public_path($banner->image));
        }
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Xóa thành công!');
    }
}
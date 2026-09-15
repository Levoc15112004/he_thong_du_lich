<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttrTour;
use Illuminate\Http\Request;

class AttrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attrs = AttrTour::paginate(10);
        return view('admin.attr.home', compact('attrs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.attr.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value'=> ['required','unique:attr_tours'],
        ],[
            'name.required'=>'Tên loại thuộc tính không được để trống',
            'value.required'=>'Tên thuộc tính không được để trống',
            'value.unique'=>'Tên thuộc tính đã tồn tại',

        ]);
        AttrTour::create([
            'name' => $request->name,
            'value' => $request->value,
        ]);
        return redirect()->route('admin.attr.home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attr = AttrTour::find($id);
        return view('admin.attr.update', compact('attr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value'=> ['required','unique:attr_tours'],
        ],[
            'name.required'=>'Tên loại thuộc tính không được để trống',
            'value.required'=>'Tên thuộc tính không được để trống',
            'value.unique'=>'Tên thuộc tính đã tồn tại',

        ]);
        $attr = AttrTour::find($id);
        $attr->update($request->only('name', 'value'));
        return redirect()->route('admin.attr.home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attr = AttrTour::find($id);
        $attr->delete();
        return redirect()->route('admin.attr.home');
    }
}

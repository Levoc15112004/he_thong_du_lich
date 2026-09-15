<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.user.home', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $user = User::findOrFail($id);
        return view('admin.user.update', compact('user'));
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
    $user = User::findOrFail($id);

    $data = $request->validate([
        'name'     => 'required|string|max:255',
        'phone'    => 'nullable|regex:/^(0)[0-9]{9}$/',
        'address'  => 'nullable|string|max:255',
        'gender'   => 'nullable|in:male,female,other',
        'birthday' => 'nullable|date|before:today',
        'avatar'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'status'   => 'required|in:dang_hoat_dong,dung_hoat_dong',
    ], [
        'name.required'   => 'Vui lòng nhập tên người dùng.',
        'name.string'     => 'Tên phải là chuỗi ký tự.',
        'name.max'        => 'Tên không được vượt quá 255 ký tự.',
        'phone.regex'     => 'Số điện thoại không hợp lệ (phải có 10 số và bắt đầu bằng 0).',
        'address.max'     => 'Địa chỉ không được vượt quá 255 ký tự.',
        'gender.in'       => 'Giới tính không hợp lệ.',
        'birthday.date'   => 'Ngày sinh không đúng định dạng ngày tháng.',
        'birthday.before' => 'Ngày sinh phải là một ngày trong quá khứ.',
        'avatar.image'    => 'Tệp tải lên phải là hình ảnh.',
        'avatar.mimes'    => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif.',
        'avatar.max'      => 'Kích thước ảnh không được vượt quá 2MB.',
        'status.required' => 'Vui lòng chọn trạng thái hoạt động.',
        'status.in'       => 'Trạng thái không hợp lệ.',
    ]);


    if ($request->hasFile('avatar')) {
        $file = $request->file('avatar');
        $filename = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('fontend/img'), $filename);

        $data['avatar'] = 'fontend/img/' . $filename;
    }


    $user->update($data);

    return redirect()
        ->route('admin.user.home')
        ->with('success', 'Cập nhật người dùng thành công!');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = User::find($id);
        $users->update([
            'status' => 'dung_hoat_dong',
        ]);

        return redirect()->route('admin.user.home')->with('success','Dừng hoạt động người dùng hành công');
    }
}

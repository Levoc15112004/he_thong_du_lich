<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\TourSchedule;
use Illuminate\Support\Facades\Log;

class TourScheduleController extends Controller
{
    /**
     *  Danh sách lịch trình
     */
    public function index(Request $request)
    {
        $keyword = $request->query('keyword');

        $query = TourSchedule::with('tour');

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('location_name', 'like', "%{$keyword}%")
                    ->orWhere('day_number', 'like', "%{$keyword}%")
                    ->orWhereHas('tour', function ($tq) use ($keyword) {
                        $tq->where('name', 'like', "%{$keyword}%");
                    });
            });
        }

        $tourSchedules = $query->orderBy('tour_id', 'desc')
            ->orderBy('day_number', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admins.TourSchedules.index', compact('tourSchedules'));
    }

    /**
     *  Form thêm lịch trình
     */
    public function create()
    {
        $tours = Tour::all(['id', 'name']);
        return view('admins.TourSchedules.create', compact('tours'));
    }

    /**
     *  Lưu lịch trình mới
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'tour_id' => 'required|exists:tours,id',
                'day_number' => 'required|integer|min:1',
                'title' => 'required|max:255',
                'description' => 'nullable|string',
                'location_name' => 'required|max:255',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',
                'map_link' => 'nullable|url|max:500',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            ], [
                'tour_id.required' => 'Vui lòng chọn tour!',
                'tour_id.exists' => 'Tour không tồn tại!',
                'day_number.required' => 'Vui lòng nhập ngày thứ mấy!',
                'day_number.integer' => 'Ngày phải là số!',
                'title.required' => 'Vui lòng nhập tiêu đề!',
                'location_name.required' => 'Vui lòng nhập tên địa điểm!',
                'image.image' => 'File tải lên phải là hình ảnh!',
            ]);

            //  Xử lý upload ảnh minh họa
            $imagePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/schedules'), $fileName);
                $imagePath = 'images/schedules/' . $fileName;
            }

            //  Tạo lịch trình
            TourSchedule::create([
                'tour_id' => $validated['tour_id'],
                'day_number' => $validated['day_number'],
                'title' => $validated['title'],
                'description' => $request->description,
                'location_name' => $validated['location_name'],
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'map_link' => $request->map_link,
                'image' => $imagePath,
            ]);

            return redirect()->route('admin.tour_schedules.index')
                ->with('success', ' Thêm lịch trình Tour thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error(' Lỗi thêm lịch trình Tour: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return redirect()->back()->withInput()->with('error', ' Không thể thêm lịch trình: ' . $e->getMessage());
        }
    }

    /**
     *  Xem chi tiết 1 lịch trình
     */
    public function show($id)
    {
        $schedule = TourSchedule::with('tour')->findOrFail($id);
        return view('admins.TourSchedules.show', compact('schedule'));
    }

    /**
     *  Form chỉnh sửa
     */
    public function edit($id)
    {
        $schedule = TourSchedule::findOrFail($id);

        // Lấy toàn bộ tour để select
        $tours = Tour::orderBy('name')->get();

        return view('admins.TourSchedules.edit', compact('schedule', 'tours'));
    }

    /**
     *  Cập nhật lịch trình
     */
    public function update(Request $request, $id)
    {
        try {
            $schedule = TourSchedule::findOrFail($id);

            $validated = $request->validate([
                'tour_id' => 'required|exists:tours,id',
                'day_number' => 'required|integer|min:1',
                'title' => 'required|max:255',
                'description' => 'nullable|string',
                'location_name' => 'required|max:255',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',
                'map_link' => 'nullable|url|max:500',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            ], [
                'tour_id.required' => 'Vui lòng chọn tour!',
                'tour_id.exists' => 'Tour không tồn tại!',
                'day_number.required' => 'Vui lòng nhập ngày thứ mấy!',
                'day_number.integer' => 'Ngày phải là số!',
                'title.required' => 'Vui lòng nhập tiêu đề!',
                'location_name.required' => 'Vui lòng nhập tên địa điểm!',
                'image.image' => 'File tải lên phải là hình ảnh!',
            ]);

            $imagePath = $schedule->image;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/schedules'), $fileName);
                $imagePath = 'images/schedules/' . $fileName;
            }

            $schedule->update([
                'tour_id' => $validated['tour_id'],
                'day_number' => $validated['day_number'],
                'title' => $validated['title'],
                'description' => $request->description,
                'location_name' => $validated['location_name'],
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'map_link' => $request->map_link,
                'image' => $imagePath,
            ]);

            return redirect()->route('admin.tour_schedules.index')
                ->with('success', ' Cập nhật lịch trình Tour thành công!');
        } catch (\Exception $e) {
            Log::error(' Lỗi cập nhật lịch trình Tour: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', ' Cập nhật thất bại: ' . $e->getMessage());
        }
    }

    /**
     *  Xóa lịch trình
     */
    public function destroy($id)
    {
        try {
            $schedule = TourSchedule::findOrFail($id);
            $schedule->delete();
            return redirect()->route('admin.tour_schedules.index')
                ->with('success', ' Xóa lịch trình thành công!');
        } catch (\Exception $e) {
            Log::error(' Lỗi xóa lịch trình: ' . $e->getMessage());
            return redirect()->back()->with('error', ' Xóa lịch trình thất bại: ' . $e->getMessage());
        }
    }
}

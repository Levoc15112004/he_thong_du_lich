<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttrTour;
use App\Models\Category;
use App\Models\ImageTour;
use App\Models\Tour;
use App\Models\TourAttr;
use App\Models\TourSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Tour::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                    ->orWhere('start_location', 'like', "%$keyword%")
                    ->orWhere('end_location', 'like', "%$keyword%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tours = $query->latest()->paginate(6)->appends($request->query());

        $tourSchedules = TourSchedule::all();

        return view('admins.Tours.index', compact('tours', 'tourSchedules'));
    }
    public function seedSample()
    {
        try {
            \Illuminate\Support\Facades\Artisan::call('db:seed', [
                '--class' => 'Tour200Seeder',
                '--force' => true,
            ]);
            return redirect()->route('admin.tours.index')->with('success', 'Đã nạp thành công 190+ tour mẫu và lịch trình!');
        } catch (\Throwable $e) {
            return redirect()->route('admin.tours.index')->with('error', 'Lỗi nạp tour: ' . $e->getMessage());
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attrTransport = AttrTour::where('name', 'transport')->get();
        $tourType = AttrTour::where('name', 'tour_type')->get();

        $categories = Category::with('children')->whereNull('parent_id')->get();

        $options = [];
        $categoryOptions = $this->buildCategoryOptions($categories, '', $options, old('category_id'));

        $categories = Category::defaultOrder()->get()->toTree();

        return view('admins.Tours.create', compact(
            'categories',
            'attrTransport',
            'tourType',
            'categoryOptions'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tours,name',
            'time' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'file' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'files.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'start_location' => 'required|string|max:255',
            'end_location' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',

        ], [
            'name.required' => 'Tên tour không được để trống',
            'name.unique' => 'Tên tour đã tồn tại',
            'file.required' => 'Ảnh đại diện không được để trống',
            'file.image' => 'Ảnh đại diện phải là hình ảnh',
            'start_location.required' => 'Vui lòng nhập điểm bắt đầu',
            'end_location.required' => 'Vui lòng nhập điểm kết thúc',
            'start_date.required' => 'Vui lòng chọn ngày khởi hành',
            'category_id.required' => 'Vui lòng chọn danh mục tour',
            'quantity.min' => 'Số chỗ phải lớn hơn 0',
            'sale_price.required' => 'Giá tour không được để trống',
            'sale_price.numeric' => 'Giá tour phải là số',
            'sale_price.min' => 'Giá tour không được nhỏ hơn 0',
        ]);

        // ---- Upload hình đại diện ----
        $mainImage = null;
        if ($request->hasFile('file')) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $request->file->move(public_path('images/tours'), $fileName);
            $mainImage = 'images/tours/'.$fileName;
        }

        // ---- Tạo tour ----
        $calculatedPrice = !empty($request->price) && $request->price > 0 
            ? $request->price 
            : round($request->sale_price * 1.15);

        $tour = Tour::create([
            'name' => $validated['name'],
            'time' => $request->time,
            'price' => $calculatedPrice,
            'sale_price' => $request->sale_price,
            'image' => $mainImage,
            'start_location' => $request->start_location,
            'end_location' => $request->end_location,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'start_date' => $request->start_date,
        ]);

        // ---- Upload nhiều ảnh mô tả ----
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('images/tour_images'), $fileName);

                $tour->images()->create([
                    'image' => 'images/tour_images/'.$fileName,
                ]);
            }
        }

        $attr = $request->attr;
        if (! empty($attr)) {
            foreach ($attr as $value) {
                TourAttr::create([
                    'attr_tour_id' => $value,
                    'tour_id' => $tour->id,
                ]);
            }
        }

        return redirect()->route('admin.tours.index')->with('success', 'Thêm Tour thành công!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tour = Tour::with(['images', 'attrTours', 'schedules'])->findOrFail($id);
        $categories = Category::get()->toTree();
        $attrs = AttrTour::all();
        $attrTransport = AttrTour::where('name', 'transport')->get();
        $tourType = AttrTour::where('name', 'tour_type')->get();

        $categories = Category::with('children')->whereNull('parent_id')->get();

        $options = [];
        $categoryOptions = $this->buildCategoryOptions($categories, '', $options, old('category_id'));

        $categories = Category::defaultOrder()->get()->toTree();

        return view('admins.Tours.edit', compact('tour', 'categories', 'attrs', 'categories', 'categoryOptions', 'attrTransport', 'tourType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tour = Tour::findOrFail($id);

        // 1. Validate
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tours,name,'.$tour->id,
            'time' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'files.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'start_location' => 'required|string|max:255',
            'end_location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'attr' => 'nullable|array',
            'attr.*' => 'exists:attr_tours,id',
        ], [
            'name.required' => 'Tên tour không được để trống',
            'name.unique' => 'Tên tour đã tồn tại',
            'file.image' => 'Ảnh đại diện phải là hình ảnh',
            'start_location.required' => 'Vui lòng nhập điểm bắt đầu',
            'end_location.required' => 'Vui lòng nhập điểm kết thúc',
            'start_date.required' => 'Vui lòng chọn ngày khởi hành',
            'category_id.required' => 'Vui lòng chọn danh mục tour',
            'quantity.min' => 'Số chỗ phải lớn hơn 0',
            'sale_price.required' => 'Giá tour không được để trống',
            'sale_price.numeric' => 'Giá tour phải là số',
            'sale_price.min' => 'Giá tour không được nhỏ hơn 0',
        ]);

        // 2. Cập nhật ảnh đại diện (nếu có)
        if ($request->hasFile('file')) {
            if ($tour->image && File::exists(public_path($tour->image))) {
                File::delete(public_path($tour->image));
            }

            $fileName = time().'_'.$request->file('file')->getClientOriginalName();
            $request->file('file')->move(public_path('images/tours'), $fileName);

            $validated['image'] = 'images/tours/'.$fileName;
        }

        // 3. Update tour
        $calculatedPrice = !empty($request->price) && $request->price > 0 
            ? $request->price 
            : ($tour->price ?: round($validated['sale_price'] * 1.15));

        $tour->update([
            'name' => $validated['name'],
            'time' => $validated['time'],
            'price' => $calculatedPrice,
            'sale_price' => $validated['sale_price'],
            'start_location' => $validated['start_location'],
            'end_location' => $validated['end_location'],
            'quantity' => $validated['quantity'],
            'description' => $validated['description'] ?? null,
            'category_id' => $validated['category_id'],
            'status' => $validated['status'],
            'start_date' => $validated['start_date'],
            'image' => $validated['image'] ?? $tour->image,
        ]);

        // 4. Upload ảnh mô tả (nếu có)
        if ($request->hasFile('files')) {
            // Xóa ảnh cũ
            $oldImages = $tour->images;
            foreach ($oldImages as $oldImg) {
                if (\Illuminate\Support\Facades\File::exists(public_path($oldImg->image))) {
                    \Illuminate\Support\Facades\File::delete(public_path($oldImg->image));
                }
                $oldImg->delete();
            }

            // Lưu ảnh mới
            foreach ($request->file('files') as $file) {
                $fileName = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('images/tour_images'), $fileName);

                $tour->images()->create([
                    'image' => 'images/tour_images/'.$fileName,
                ]);
            }
        }

        // 5. Sync thuộc tính (attr)
        $tour->attrTours()->sync($validated['attr'] ?? []);

        return redirect()
            ->route('admin.tours.index')
            ->with('success', 'Cập nhật Tour du lịch thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tour = Tour::findOrFail($id);
        $images = ImageTour::where('tour_id', $id)->get();
        foreach ($images as $img) {
            File::delete('images/'.$img->images);
        }
        TourSchedule::where('tour_id', $id)->delete();
        TourAttr::where('tour_id', $id)->delete();
        ImageTour::where('tour_id', $id)->delete();
        $tour->delete();

        return redirect()->route('admin.tours.index')->with('success', 'Xóa Tour du lịch thành công!');
    }

    private function buildCategoryOptions($categories, $prefix = '', &$options = [], $oldValue = null)
    {
        foreach ($categories as $category) {
            $options[] = [
                'id' => $category->id,
                'name' => $prefix.$category->name,
                'selected' => ($oldValue == $category->id),
            ];

            if ($category->children && $category->children->count()) {
                $this->buildCategoryOptions($category->children, $prefix.'— ', $options, $oldValue);
            }
        }

        return $options;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Requests\SanPhamRequest; // Import your request class
use App\Models\DanhMuc;
use App\Models\HinhAnhSanPham;
use App\Models\SanPham;
use Illuminate\Http\Request;

class SanPhamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Thông tin sản phẩm";
        $listSanPham = SanPham::orderByDesc('is_type')->get();
        return view('admins.sanphams.index', compact('title', 'listSanPham'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Thêm sản phẩm";
        $listDanhMuc = DanhMuc::all(); // Get all categories
        return view('admins.sanphams.create', compact('title', 'listDanhMuc'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SanPhamRequest $request)
    {
        $params = $request->except('_token');

        // Convert boolean fields
        $params['is_new'] = $request->has('is_new') ? 1 : 0;
        $params['is_hot'] = $request->has('is_hot') ? 1 : 0;
        $params['is_hot_deal'] = $request->has('is_hot_deal') ? 1 : 0;
        $params['is_show_home'] = $request->has('is_show_home') ? 1 : 0;

        // Handle main image
        if ($request->hasFile('hinh_anh')) {
            $params['hinh_anh'] = $request->file('hinh_anh')->store('uploads/sanpham', 'public');
        }

        // Create product
        $sanPham = SanPham::create($params);
        $sanPhamID = $sanPham->id;

        // Handle additional images
        if ($request->hasFile('list_hinh_anh')) {
            foreach ($request->file('list_hinh_anh') as $image) {
                if ($image) {
                    $path = $image->store('uploads/hinhanhsanpham/id_' . $sanPhamID, 'public');
                    $sanPham->hinhanhSanPham()->create([
                        'san_pham_id' => $sanPhamID,
                        'hinh_anh' => $path,
                    ]);
                }
            }
        }

        return redirect()->route('admins.sanphams.index')->with('success', 'Thêm sản phẩm thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sanPham = SanPham::findOrFail($id);
        return view('admins.sanphams.show', compact('sanPham'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Chỉnh sửa sản phẩm";
        $sanPham = SanPham::findOrFail($id);
        $listDanhMuc = DanhMuc::all();
        return view('admins.sanphams.edit', compact('title', 'sanPham', 'listDanhMuc'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SanPhamRequest $request, string $id)
    {
        $sanPham = SanPham::findOrFail($id);
        $params = $request->except('_token');

        // Convert boolean fields
        $params['is_new'] = $request->has('is_new') ? 1 : 0;
        $params['is_hot'] = $request->has('is_hot') ? 1 : 0;
        $params['is_hot_deal'] = $request->has('is_hot_deal') ? 1 : 0;
        $params['is_show_home'] = $request->has('is_show_home') ? 1 : 0;

        // Handle main image
        if ($request->hasFile('hinh_anh')) {
            $params['hinh_anh'] = $request->file('hinh_anh')->store('uploads/sanpham', 'public');
        }

        // Update product
        $sanPham->update($params);

        // Handle additional images
        if ($request->hasFile('list_hinh_anh')) {
            foreach ($request->file('list_hinh_anh') as $image) {
                if ($image) {
                    $path = $image->store('uploads/hinhanhsanpham/id_' . $sanPham->id, 'public');
                    $sanPham->hinhanhSanPham()->create([
                        'san_pham_id' => $sanPham->id,
                        'hinh_anh' => $path,
                    ]);
                }
            }
        }


        // xử lý album
        if ($request->hasFile('list_hinh_anh')) {
            $currentImage = $sanPham->hinhAnhSanPham->pluck('id')->toArray();
            $arrayCombine = array_combine($currentImage, $currentImage);

            // Truoengwf hơp xóa
            foreach ($arrayCombine as $key => $value) {
                // tìm kiếm id hình ảnh trong mảng hình ảnh
                // Nếu  ko tồn tại id => ng dùng đã xóa 
                if (array_key_exists($key, $request->list_hinh_anh)) {

                    $hinhAnhSanPham = HinhAnhSanPham::query()->find($key);
                    // xóa hình ảnh
                    if ($hinhAnhSanPham && Storage::disk('public')->exists($hinhAnhSanPham->hinh_anh)) {
                        Storage::disk('public')->delete($hinhAnhSanPham->hinh_anh);
                        $hinhAnhSanPham->delete();
                    }
                }
            }
            //Trường hợp thêm hoặc sửa
            foreach ($request->list_hinh_anh as $key => $image) {
                if (!array_key_exists($key, $arrayCombine)) {
                    if ($request->hasFile("list_hinh_anh.$key")) {
                        $path = $image->store('uploads/hinhanhsanpham/id_' . $id, 'public');
                        $sanPham->hinhAnhSanPham()->create([
                            'san_pham_id' => $id,
                            'hinh_anh' => $path,
                        ]);
                    }
                } else if (is_file($image) && $request->hasFile("list_hinh_anh.$key")) {
                    //Trường hợp thay đổi ảnh
                    $hinhAnhSanPham = HinhAnhSanPham::query()->find($key);
                    if ($hinhAnhSanPham && Storage::disk('public')->exists($hinhAnhSanPham->hinh_anh)) {
                        Storage::disk('public')->delete($hinhAnhSanPham->hinh_anh);
                    }
                    $path = $image->store('uploads/hinhanhsanpham/id_' . $id, 'public');
                    $hinhAnhSanPham->update([
                        'hinh_anh' => $path,
                    ]);
                }
            }
        }
        

        $sanPham->update($params);
        return redirect()->route('admins.sanphams.index')->with('success', 'Cập nhật sản phẩm thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sanPham = SanPham::findOrFail($id);

        // xóa hình ảnh đại diện của sản phẩm
        if ($sanPham->hinh_anh && Storage::disk('public')->exists($sanPham->hinh_anh)) {
            Storage::disk('public')->delete($sanPham->hinh_anh);
        }

        // Xóa album ảnh
        $sanPham->hinhAnhSanPham()->delete();
        //xóa toàn bộ ảnh trong thư mục 

        $path =  'uploads/hinhanhsanpham/id_' . $id;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->deleteDirectory($path);
        }

        $sanPham->delete();
        return redirect()->route('admins.sanphams.index')->with('success', 'Xóa sản phẩm thành công');
    }
}

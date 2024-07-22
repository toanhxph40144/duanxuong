<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DanhMuc;
use App\Http\Requests\DanhMucRequest;
use Illuminate\Support\Facades\Storage;



class DanhMucController extends Controller
{
    public function index()
    {
        $title = "Danh mục sản phẩm";
        $listDanhMuc = DanhMuc::orderByDesc('trang_thai')->get();
        return view('admins.danhmucs.index', compact('title', 'listDanhMuc'));
    }

    public function create()
    {
        $title = "Thêm danh mục sản phẩm";
        return view('admins.danhmucs.create', compact('title'));
    }

    public function store(DanhMucRequest $request)
    {
        // Retrieve validated data
        // $validatedData = $request->validated();

        // // Handle file upload
        // if ($request->hasFile('hinh_anh')) {
        //     $filepath = $request->file('hinh_anh')->store('uploads/danhmucs', 'public');
        //     $validatedData['hinh_anh'] = $filepath;
        // }

        // // Create new DanhMuc record
        // DanhMuc::create($validatedData);

        if ($request->isMethod('POST')) {
            $param = $request->except('_token');
            if ($request->hasFile('hinh_anh')) {
                $filepath = $request->file('hinh_anh')->store('uploads/danhmucs', 'public');
            } else {
                $filepath = null;
            }
            $param['hinh_anh'] = $filepath;
            $param['trang_thai'] = $request->input('trang_thai', 0);
            DanhMuc::create($param);
        }
        // Redirect with success message
        return redirect()->route('admins.danhmucs.index')->with('success', 'Thêm danh mục thành công');
    }





    public function show(string $id)
    {
        // Show logic
    }

    public function edit(string $id)
    {
        $title = "Chỉnh sửa danh mục sản phẩm";
        $danhMuc = DanhMuc::findOrFail($id); // Corrected method
        return view('admins.danhmucs.edit', compact('title', 'danhMuc'));
    }

    public function update(DanhMucRequest $request, string $id)
    {
        if ($request->isMethod('PUT')) {
            $param = $request->except('_token','_method');
            $danhMuc = DanhMuc::findOrFail($id);
            if ($request->hasFile('hinh_anh')) {
                      if($danhMuc->hinh_anh && Storage::disk('public')->exists($danhMuc->hinh_anh)){
                        Storage::disk('public')->delete($danhMuc->hinh_anh);
                      }
                $filepath = $request->file('hinh_anh')->store('uploads/danhmucs', 'public');
            } else {
                $filepath = $danhMuc->hinh_anh;
            }
            $param['hinh_anh'] = $filepath;
            // $param['trang_thai'] = $request->input('trang_thai', 0);

            $danhMuc->update($param);
           
        }
        // Redirect with success message
        return redirect()->route('admins.danhmucs.index')->with('success', 'Cập nhật danh mục thành công');
    }

    public function destroy(string $id)
    {
        // Retrieve the existing record
        $danhMuc = DanhMuc::findOrFail($id);

        // // Delete the file if it exists
        if ($danhMuc->hinh_anh) {
            Storage::disk('public')->delete($danhMuc->hinh_anh);
        }

        // // Delete the record
        $danhMuc->delete();

        // // Redirect with success message
        return redirect()->route('admins.danhmucs.index')->with('success', 'Xóa danh mục thành công');
    }
}

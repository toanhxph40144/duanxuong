@extends('layouts.admin')

@section('title')
{{$title}}
@endsection

@section('css')
<!-- Quill css -->
<link href="{{asset('assets/admin/libs/quill/quill.snow.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/admin/libs/quill/quill.bubble.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="content">
    <!-- Start Content-->
    <div class="container-xxl">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Quản lý sản phẩm</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{$title}}</h5>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <form action="{{ route('admins.sanphams.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4">
                                    <!-- Product Code -->
                                    <div class="mb-3">
                                        <label for="ma_san_pham" class="form-label">Mã sản phẩm</label>
                                        <input type="text" id="ma_san_pham" name="ma_san_pham" class="form-control @error('ma_san_pham') is-invalid @enderror" value="{{ old('ma_san_pham') }}" placeholder="Mã sản phẩm">
                                        @error('ma_san_pham')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Product Name -->
                                    <div class="mb-3">
                                        <label for="ten_san_pham" class="form-label">Tên sản phẩm</label>
                                        <input type="text" id="ten_san_pham" name="ten_san_pham" class="form-control @error('ten_san_pham') is-invalid @enderror" placeholder="Tên sản phẩm" value="{{ old('ten_san_pham') }}">
                                        @error('ten_san_pham')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Product Price -->
                                    <div class="mb-3">
                                        <label for="gia_san_pham" class="form-label">Giá sản phẩm</label>
                                        <input type="number" id="gia_san_pham" name="gia_san_pham" class="form-control @error('gia_san_pham') is-invalid @enderror" placeholder="Giá sản phẩm" value="{{ old('gia_san_pham') }}">
                                        @error('gia_san_pham')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Discount Price -->
                                    <div class="mb-3">
                                        <label for="gia_khuyen_mai" class="form-label">Giá Khuyến Mãi</label>
                                        <input type="number" id="gia_khuyen_mai" name="gia_khuyen_mai" class="form-control @error('gia_khuyen_mai') is-invalid @enderror" placeholder="Giá khuyến mãi" value="{{ old('gia_khuyen_mai') }}">
                                        @error('gia_khuyen_mai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Category -->
                                    <div class="mb-3">
                                        <label for="danh_muc_id" class="form-label">Danh Mục</label>
                                        <select name="danh_muc_id" class="form-select @error('danh_muc_id') is-invalid @enderror">
                                            <option value="" disabled selected>Chọn danh mục</option>
                                            @foreach ($listDanhMuc as $item)
                                                <option value="{{ $item->id }}" {{ old('danh_muc_id') == $item->id ? 'selected' : '' }}>{{ $item->ten_danh_muc }}</option>
                                            @endforeach
                                        </select>
                                        @error('danh_muc_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Quantity -->
                                    <div class="mb-3">
                                        <label for="so_luong" class="form-label">Số Lượng</label>
                                        <input type="number" id="so_luong" name="so_luong" class="form-control @error('so_luong') is-invalid @enderror" placeholder="Số lượng sản phẩm" value="{{ old('so_luong') }}">
                                        @error('so_luong')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Date -->
                                    <div class="mb-3">
                                        <label for="ngay_nhap" class="form-label">Ngày nhập</label>
                                        <input type="date" id="ngay_nhap" name="ngay_nhap" class="form-control @error('ngay_nhap') is-invalid @enderror" value="{{ old('ngay_nhap') }}">
                                        @error('ngay_nhap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Short Description -->
                                    <div class="mb-3">
                                        <label for="mo_ta_ngan" class="form-label">Mô Tả</label>
                                        <textarea name="mo_ta_ngan" id="mo_ta_ngan" class="form-control @error('mo_ta_ngan') is-invalid @enderror" rows="3" placeholder="Mô tả ngắn">{{ old('mo_ta_ngan') }}</textarea>
                                        @error('mo_ta_ngan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Custom Options -->
                                    <label for="is_type" class="form-label">Tùy chỉnh</label>
                                    <div class="form-switch mb-2 d-flex justify-content-between">
                                        @foreach(['is_new' => 'New', 'is_hot' => 'Hot', 'is_hot_deal' => 'Hot Deal', 'is_show_home' => 'Show Home'] as $field => $label)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="{{ $field }}" id="{{ $field }}" {{ old($field) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $field }}">{{ $label }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <!-- Detailed Description -->
                                    <div class="mb-3">
                                        <label for="noi_dung_content" class="form-label">Mô tả chi tiết sản phẩm</label>
                                        <div id="quill-editor" style="height: 400px;"></div>
                                        <textarea name="noi_dung" id="noi_dung_content" class="d-none"></textarea>
                                    </div>

                                    <!-- Main Image -->
                                    <div class="mb-3">
                                        <label for="hinh_anh" class="form-label">Hình ảnh</label>
                                        <input type="file" id="hinh_anh" name="hinh_anh" class="form-control @error('hinh_anh') is-invalid @enderror">
                                        @error('hinh_anh')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="mt-2">
                                            <img id="imagePreview" src="#" alt="Hình ảnh preview" style="display: none; width:200px;">
                                        </div>
                                    </div>

                                    <!-- Additional Images -->
                                    <div class="mb-3">
                                        <label for="additional_images" class="form-label">Album hình ảnh</label>
                                        <i id="add-row" class="mdi mdi-plus text-muted fs-18 rounded-2 border p-1 ms-3" style="cursor:pointer"></i>
                                        <table class="table align-middle table-nowrap mb-0">
                                            <tbody id="image-table-body">
                                                <tr>
                                                    <td class="d-flex align-item-center">
                                                        <img id="preview_0" src="https://uxwing.com/wp-content/themes/uxwing/download/video-photography-multimedia/pictures-icon.svg" alt="Hình ảnh sản phẩm" style="width: 40px; margin-right:6px;">
                                                        <input type="file" name="list_hinh_anh[id_0]" class="form-control @error('hinh_anh') is-invalid @enderror" onchange="previewImage(this,0)">
                                                    </td>
                                                    <td><i class="mdi mdi-delete text-muted fs-18 rounded-2 border p-1" style="cursor:pointer" onclick="removeRow(this)"></i></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="is_type" class="form-label">Trạng thái</label>
                                    <div class="col-sm-10 d-flex gap-2">
                                        @foreach(['1' => 'Hiển thị', '0' => 'Ẩn'] as $value => $label)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_type" id="trang_thai_{{ $value }}" value="{{ $value }}" {{ old('is_type') == $value ? 'checked' : '' }}>
                                                <label class="form-check-label {{ $value == '1' ? 'text-success' : 'text-danger' }}" for="trang_thai_{{ $value }}">{{ $label }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- container-fluid -->
@endsection

@section('js')
<!-- Quill Editor Js -->
<script src="{{ asset('assets/admin/libs/quill/quill.min.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Quill editor
        var quill = new Quill("#quill-editor", {
            theme: "snow",
        });

        // Set initial content
        var oldContent = `{!! old('noi_dung') !!}`;
        quill.root.innerHTML = oldContent;

        // Update hidden textarea with Quill editor content
        quill.on('text-change', function() {
            document.getElementById('noi_dung_content').value = quill.root.innerHTML;
        });

        // Image preview for main image
        const fileInput = document.getElementById('hinh_anh');
        const imagePreview = document.getElementById('imagePreview');

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };

                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '#';
                imagePreview.style.display = 'none';
            }
        });

        // Add new image row to the table
        var rowCount = 1;
        document.getElementById('add-row').addEventListener('click', function() {
            var tableBody = document.getElementById('image-table-body');
            var newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td class="d-flex align-item-center">
                    <img id="preview_${rowCount}" src="https://uxwing.com/wp-content/themes/uxwing/download/video-photography-multimedia/pictures-icon.svg" alt="Hình ảnh sản phẩm" style="width: 40px; margin-right:6px;">
                    <input type="file" name="list_hinh_anh[id_${rowCount}]" class="form-control" onchange="previewImage(this, ${rowCount})">
                </td>
                <td><i class="mdi mdi-delete text-muted fs-18 rounded-2 border p-1" style="cursor:pointer" onclick="removeRow(this)"></i></td>
            `;

            tableBody.appendChild(newRow);
            rowCount++;
        });
    });

    // Preview image function
    function previewImage(input, rowIndex) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById(`preview_${rowIndex}`).src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Remove image row function
    function removeRow(item) {
        item.closest('tr').remove();
    }
</script>
@endsection

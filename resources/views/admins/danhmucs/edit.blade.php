@extends('layouts.admin')

@section('title')
{{$title}}
@endsection

@section('css')
@endsection

@section('content')
<div class="content">
    <!-- Start Content-->
    <div class="container-xxl">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Quản lý danh mục </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{$title}}</h5>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <form action="{{ route('admins.danhmucs.update', $danhMuc->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="ten_danh_muc" class="form-label">Tên danh mục </label>
                                        <input type="text" id="ten_danh_muc" name="ten_danh_muc" class="form-control @error('ten_danh_muc') is-invalid @enderror" value="{{ old('ten_danh_muc', $danhMuc->ten_danh_muc) }}">
                                        @error('ten_danh_muc')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="hinh_anh" class="form-label">Hình ảnh </label>
                                        <input type="file" id="hinh_anh" name="hinh_anh" class="form-control @error('hinh_anh') is-invalid @enderror">
                                        @error('hinh_anh')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                        <div class="mt-2">
                                           
                                            <img id="img_danh_muc" src="{{ Storage::url($danhMuc->hinh_anh) }}" alt="Hình ảnh" style=" width:200px; height: auto;">
                                          
                                         
                                        </div>
                                    </div>
                                </div>

                               
                                <div class="col-sm-10 mb-3 gap-2">
                                    <label for="trang_thai" class="form-label">Trạng thái</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="trang_thai" id="trang_thai_show" value="1" {{ $danhMuc->trang_thai == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="trang_thai_show">Hiển thị</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="trang_thai" id="trang_thai_hide" value="0" {{ $danhMuc->trang_thai == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="trang_thai_hide">Ẩn</label>
                                    </div>
                                </div>


                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('hinh_anh');
        const img_danh_muc = document.getElementById('img_danh_muc');

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    img_danh_muc.src = e.target.result;
                    img_danh_muc.style.display = 'block';
                };

                reader.readAsDataURL(file);
            } else {
                img_danh_muc.src = '#';
                img_danh_muc.style.display = 'none';
            }
        });
    });
</script>
@endsection
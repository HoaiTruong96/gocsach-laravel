@extends('layouts.admin')
@section('title', 'Thêm Tác giả')
@section('header', 'Thêm Tác giả mới')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div
            class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 transition-colors duration-300">

            <form action="{{ route('admin.authors.store') }}" method="POST">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tên tác giả
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', request('name')) }}"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white transition-colors"
                            placeholder="VD: Nguyễn Nhật Ánh">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Ảnh (URL)</label>
                        <input type="text" name="photo" value="{{ old('photo') }}"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white transition-colors"
                            placeholder="https://example.com/photo.jpg">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Năm sinh</label>
                            @include('admin.partials.custom-pickers', [
                                'type' => 'year',
                                'name' => 'birth_year',
                                'value' => old('birth_year'),
                                'placeholder' => 'Chọn năm sinh...'
                            ])
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Năm mất</label>
                            @include('admin.partials.custom-pickers', [
                                'type' => 'year',
                                'name' => 'death_year',
                                'value' => old('death_year'),
                                'placeholder' => 'Còn sống...'
                            ])
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Quốc tịch</label>
                        <input type="text" name="nationality" value="{{ old('nationality') }}"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white transition-colors"
                            placeholder="Việt Nam">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tiểu sử</label>
                        <textarea name="bio" rows="5"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white transition-colors resize-y min-h-[120px]"
                            placeholder="Giới thiệu về tác giả...">{{ old('bio') }}</textarea>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="submit"
                            class="flex-1 bg-blue-600 text-white py-2.5 rounded-lg hover:bg-blue-700 font-medium transition">
                            <i class="fas fa-plus mr-1"></i> Thêm tác giả
                        </button>
                        <a href="{{ route('admin.authors.index') }}"
                            class="px-6 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 font-medium transition">
                            Hủy
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
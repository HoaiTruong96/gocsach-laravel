@extends('layouts.admin')
@section('title', 'Sửa Tác giả')
@section('header', 'Chỉnh sửa Tác giả')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div
            class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 transition-colors duration-300">

            {{-- Header --}}
            <div class="flex items-center gap-4 mb-6 pb-6 border-b dark:border-slate-700">
                @if($author->photo)
                    <img src="{{ $author->photo }}" alt="{{ $author->name }}" class="w-16 h-16 rounded-full object-cover">
                @else
                    <div
                        class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold">
                        {{ substr($author->name, 0, 1) }}
                    </div>
                @endif
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ $author->name }}</h2>
                    <p class="text-sm text-gray-500 dark:text-slate-400">Slug: {{ $author->slug }}</p>
                </div>
            </div>

            <form action="{{ route('admin.authors.update', $author->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tên tác giả
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $author->name) }}"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white transition-colors">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Ảnh (URL)</label>
                        <input type="text" name="photo" value="{{ old('photo', $author->photo) }}"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white transition-colors"
                            placeholder="https://example.com/photo.jpg">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Năm sinh</label>
                            <input type="number" name="birth_year" value="{{ old('birth_year', $author->birth_year) }}"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white transition-colors"
                                placeholder="1955">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Năm mất</label>
                            <input type="number" name="death_year" value="{{ old('death_year', $author->death_year) }}"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white transition-colors"
                                placeholder="Để trống nếu còn sống">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Quốc tịch</label>
                        <input type="text" name="nationality" value="{{ old('nationality', $author->nationality) }}"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white transition-colors"
                            placeholder="Việt Nam">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tiểu sử</label>
                        <textarea name="bio" rows="4"
                            class="w-full px-4 py-2 border dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-slate-700 text-gray-800 dark:text-white transition-colors"
                            placeholder="Giới thiệu về tác giả...">{{ old('bio', $author->bio) }}</textarea>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="submit"
                            class="flex-1 bg-blue-600 text-white py-2.5 rounded-lg hover:bg-blue-700 font-medium transition">
                            <i class="fas fa-save mr-1"></i> Lưu thay đổi
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
@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Back Navigation -->
    <div class="mb-6">
        <a href="/posts/{{ $post->id }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors group">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 group-hover:-translate-x-1 transition-transform">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Batal
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white border border-slate-150 rounded-2xl p-6 sm:p-8 shadow-sm">
        <div class="border-b border-slate-100 pb-5 mb-6">
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Edit Artikel</h1>
            <p class="mt-1.5 text-sm text-slate-500">Perbarui judul atau isi artikel Anda dengan data terbaru.</p>
        </div>

        <form action="/posts/{{ $post->id }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Title Input -->
            <div>
                <label for="title" class="block text-sm font-semibold text-slate-900 mb-2">Judul Artikel</label>
                <input type="text" name="title" id="title" required placeholder="Masukkan judul..." 
                    class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-slate-900 placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 transition-all text-sm @error('title') border-rose-500 focus:border-rose-500 focus:ring-rose-500/10 @enderror"
                    value="{{ old('title', $post->title) }}">
                @error('title')
                    <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content Input -->
            <div>
                <label for="content" class="block text-sm font-semibold text-slate-900 mb-2">Isi Artikel</label>
                <textarea name="content" id="content" required rows="10" placeholder="Tuliskan isi artikel..." 
                    class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-slate-900 placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 transition-all text-sm leading-relaxed @error('content') border-rose-500 focus:border-rose-500 focus:ring-rose-500/10 @enderror">{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="/posts/{{ $post->id }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
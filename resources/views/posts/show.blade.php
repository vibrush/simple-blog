@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Back Navigation -->
    <div class="mb-6">
        <a href="/" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors group">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 group-hover:-translate-x-1 transition-transform">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    <!-- Article Content Card -->
    <article class="bg-white border border-slate-150 rounded-2xl p-6 sm:p-10 shadow-sm">
        <div class="flex items-center gap-x-4 text-xs mb-6">
            <time datetime="{{ $post->created_at }}" class="text-slate-500 flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                {{ $post->created_at->format('d M Y, H:i') }} ({{ $post->created_at->diffForHumans() }})
            </time>
            <span class="rounded-full bg-indigo-50 px-3 py-1 font-medium text-indigo-700 text-xs">Artikel</span>
        </div>

        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl mb-6 leading-tight">
            {{ $post->title }}
        </h1>

        <div class="prose prose-slate max-w-none">
            <p class="text-slate-700 text-base leading-relaxed whitespace-pre-line">
                {{ $post->content }}
            </p>
        </div>

        @if(auth()->check() && $post->user_id === auth()->id())
            <div class="flex items-center justify-end gap-2 mt-8 pt-6 border-t border-slate-100">
                <!-- Edit Button -->
                <a href="/posts/{{ $post->id }}/edit" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-indigo-600 hover:border-indigo-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                    Edit Artikel
                </a>

                <!-- Delete Button -->
                <form action="/posts/{{ $post->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-rose-50 px-3.5 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-100 hover:text-rose-700 transition-colors border border-transparent">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                        Hapus Artikel
                    </button>
                </form>
            </div>
        @endif
    </article>
</div>
@endsection
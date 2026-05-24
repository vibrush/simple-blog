@extends('layouts.app')

@section('content')
<div class="space-y-10">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100 pb-8">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 mt-2 sm:text-4xl">
                Daftar Artikel Terkini
            </h1>
            <p class="mt-2 text-slate-500 text-base max-w-2xl">
                Temukan ide, wawasan baru, dan panduan pemrograman terbaik yang ditulis oleh komunitas developer.
            </p>
        </div>
        @auth
        @endauth
    </div>

    <!-- Articles List -->
    <div class="space-y-6">
        @forelse($posts as $post)
            <article class="group flex flex-col items-start justify-between rounded-2xl border border-slate-150 bg-white p-6 shadow-sm hover:shadow-md hover:border-indigo-100 hover:bg-slate-50/50 transition-all duration-300">
                <!-- Meta Info -->
                <div class="flex items-center gap-x-4 text-xs">
                    <time datetime="{{ $post->created_at }}" class="text-slate-500 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        {{ $post->created_at->diffForHumans() }}
                    </time>
                    <span class="relative z-10 rounded-full bg-slate-100 px-3 py-1.5 font-medium text-slate-600">Artikel</span>
                </div>

                <!-- Title & Content -->
                <div class="w-full">
                    <h3 class="mt-4 text-xl font-bold tracking-tight text-slate-900 group-hover:text-indigo-600 transition-colors duration-200">
                        <a href="/posts/{{ $post->id }}">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600 line-clamp-3">
                        {{ $post->content }}
                    </p>
                </div>

                <!-- Footer Actions -->
                <div class="flex w-full items-center justify-between gap-4 mt-6 pt-6 border-t border-slate-100">
                    <a href="/posts/{{ $post->id }}" class="inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 hover:text-indigo-500 group/link">
                        Baca Selengkapnya
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 group-hover/link:translate-x-1 transition-transform">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>

                    @auth
                        <div class="flex items-center gap-2">
                            <!-- Edit Button -->
                            <a href="/posts/{{ $post->id }}/edit" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-indigo-600 hover:border-indigo-200 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                                Edit
                            </a>

                            <!-- Delete Button -->
                            <form action="/posts/{{ $post->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-100 hover:text-rose-700 transition-colors border border-transparent">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </article>
        @empty
            <div class="text-center py-16 px-4 bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto h-12 w-12 text-slate-300 mb-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                <h3 class="text-sm font-semibold text-slate-900">Belum ada artikel</h3>
                <p class="mt-1 text-sm text-slate-500">Mulai berbagi ide dan wawasan baru dengan menulis artikel pertamamu.</p>
                @auth
                    <div class="mt-6">
                        <a href="/posts/create" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tulis Artikel Pertama
                        </a>
                    </div>
                @else
                    <div class="mt-6">
                        <a href="/login" class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 transition-colors">
                            Masuk untuk Menulis
                        </a>
                    </div>
                @endauth
            </div>
        @endforelse
    </div>
</div>
@endsection
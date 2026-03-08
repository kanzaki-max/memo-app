@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">メモ一覧</h1>
    <a href="{{ route('memos.create') }}"
       class="bg-black text-white px-4 py-2 rounded-lg shadow">
        ＋ 新規作成
    </a>
</div>

@foreach($memos as $memo)
    <div class="bg-white rounded-xl shadow p-6 mb-4 hover:shadow-lg transition">

        <div class="flex justify-between items-center mb-2">
            <span class="text-sm text-gray-500">
                {{ $memo->situation ?? '未分類' }}
            </span>

            <span class="text-sm text-gray-400">
                {{ $memo->created_at->format('Y.m.d') }}
            </span>
        </div>

        <h2 class="text-lg font-semibold mb-2">
            {{ Str::limit($memo->summary, 60) }}
        </h2>

        <p class="text-gray-600 text-sm">
            {{ Str::limit($memo->original_text, 100) }}
        </p>

        @if($memo->self_score)
            <div class="mt-3">
                <span class="text-yellow-500">
                    評価：{{ $memo->self_score }}/5
                </span>
            </div>
        @endif

    </div>
@endforeach

@endsection
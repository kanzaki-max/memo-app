@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 flex">

    {{-- サイドバー --}}
    <div class="w-64 bg-indigo-900 text-white p-6">
        <h2 class="text-lg font-bold mb-6">メモ管理</h2>

        <nav class="space-y-3 text-sm">
            <a href="/" class="block hover:text-blue-400">ノート一覧</a>
            <a href="#" class="block hover:text-blue-400">タグ</a>
            <a href="#" class="block hover:text-blue-400">お気に入り</a>
        </nav>
    </div>

    {{-- メイン --}}
    <div class="flex-1 p-10">

        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl p-10">

            <h1 class="text-2xl font-bold mb-6">テーマ管理</h1>

            {{-- テーマ追加フォーム --}}
            <form method="POST" action="/themes" class="space-y-4 mb-10">
            @csrf

                <input
                    name="name"
                    placeholder="テーマ名"
                    class="w-full border rounded-lg p-2"
                >

                <select name="color" class="border rounded-lg p-2 w-full">

                    <option value="red">赤</option>
                    <option value="blue">青</option>
                    <option value="yellow">黄</option>
                    <option value="green">緑</option>
                    <option value="purple">紫</option>
                    <option value="pink">ピンク</option>
                    <option value="orange">オレンジ</option>
                    <option value="gray">グレー</option>
                    <option value="indigo">インディゴ</option>
                    <option value="teal">ティール</option>

                </select>

                <button
                    class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-xl shadow">
                    テーマ追加
                </button>

            </form>

            <hr class="mb-6">

            {{-- テーマ一覧 --}}
            <div class="space-y-3">

                @foreach($themes as $theme)

                @php

                $colors = [
                'red' => ['bg-red-50','border-red-400','text-red-800'],
                'blue' => ['bg-blue-50','border-blue-400','text-blue-800'],
                'yellow' => ['bg-yellow-50','border-yellow-400','text-yellow-800'],
                'green' => ['bg-green-50','border-green-400','text-green-800'],
                'purple' => ['bg-purple-50','border-purple-400','text-purple-800'],
                'pink' => ['bg-pink-50','border-pink-400','text-pink-800'],
                'orange' => ['bg-orange-50','border-orange-400','text-orange-800'],
                'gray' => ['bg-gray-100','border-gray-400','text-gray-800'],
                'indigo' => ['bg-indigo-50','border-indigo-400','text-indigo-800'],
                'teal' => ['bg-teal-50','border-teal-400','text-teal-800'],
                ];

                $themeColor = $colors[$theme->color_name];

                @endphp

                <div class="flex justify-between items-center p-3 border rounded-lg">

                    <span class="px-3 py-1 text-sm rounded-full
                        {{ $themeColor[0] }} {{ $themeColor[2] }}">
                        {{ $theme->name }}
                    </span>

                    @if(!$theme->is_default)
                    <form method="POST" action="/themes/delete/{{ $theme->id }}">
                        @csrf
                        <button class="text-red-500 hover:text-red-700 text-sm">
                            削除
                        </button>
                    </form>
                    @endif

                </div>

                @endforeach
                <div class="mt-6 flex justify-end">

                    <a href="{{ route('memos.create') }}"
                        class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 text-sm shadow">
                        ← メモ入力に戻る
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
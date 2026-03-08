@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex">

    {{-- サイドバー --}}
    <div class="w-64 bg-indigo-900 text-white p-6">
        <h2 class="text-lg font-bold mb-6">メモ管理</h2>

        <nav class="space-y-3 text-sm">
            <a href="#" class="block hover:text-blue-400">ノート一覧</a>
            <a href="#" class="block hover:text-blue-400">タグ</a>
            <a href="#" class="block hover:text-blue-400">お気に入り</a>
        </nav>
    </div>

    {{-- メイン --}}
    <div class="flex-1 p-10">

        <label class="flex items-center gap-2 mb-4">
            <input type="checkbox" id="expertMode">
            エキスパートモード
        </label>

        <div class="relative max-w-6xl mx-auto bg-white rounded-2xl shadow-xl p-10">

            <h1 class="text-2xl font-bold mb-6">
                <!-- 全体コピーアイコン -->
                <button 
                    type="button"
                    id="copyAllTopBtn"
                    class="absolute top-6 right-6 text-gray-400 hover:text-blue-500 text-sm"
                    title="全体をコピー">
                    全体をコピー
                </button>
                新規メモ作成
            </h1>

            {{-- 上部フォーマットツールバー --}}
            <div id="editorToolbar" class="flex gap-3 mb-4 p-3 bg-gray-50 border rounded-lg">

                <button type="button"
                    data-command="bold"
                    class="toolbar-btn px-3 py-1 rounded-md border border-gray-300 hover:bg-gray-100 transition">
                    <span class="font-bold">B</span>
                </button>

                <button type="button"
                    data-command="italic"
                    class="toolbar-btn px-3 py-1 rounded-md border border-gray-300 hover:bg-gray-100 transition">
                    <span class="italic">I</span>
                </button>

                <button type="button"
                    data-command="underline"
                    class="toolbar-btn px-3 py-1 rounded-md border border-gray-300 hover:bg-gray-100 transition">
                    <span class="underline">U</span>
                </button>

                <button type="button"
                    data-color="red"
                    class="color-btn px-3 py-1 rounded-md border border-gray-300 hover:bg-gray-100 transition text-red-500">
                    ●
                </button>

                <button type="button"
                    data-color="blue"
                    class="color-btn px-3 py-1 rounded-md border border-gray-300 hover:bg-gray-100 transition text-blue-500">
                    ●
                </button>

                <button type="button"
                    data-color="black"
                    class="color-btn px-3 py-1 rounded-md border border-gray-300 hover:bg-gray-100 transition text-black">
                    ●
                </button>

            </div>

            {{-- タグボタン --}}
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold">テーマ</h2>

                <a href="{{ route('themes.index') }}"
                class="text-sm text-blue-500 hover:underline">
                ＋テーマ管理
                </a>
            </div>
            <div class="flex flex-wrap gap-3 mb-6">

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

            @endphp

            @foreach($themes as $theme)

            @php
            $themeColor = $colors[$theme->color_name] ?? $colors['gray'];
            @endphp

            <button
            type="button"
            onclick="addBlock('{{ $theme->name }}', '{{ $themeColor[0] }} {{ $themeColor[1] }}')"
            class="px-4 py-1 {{ $themeColor[0] }} {{ $themeColor[2] }} rounded-full text-sm"
            >
            {{ $theme->name }}
            </button>

            @endforeach

            </div>
            <!-- <div class="flex flex-wrap gap-3 mb-6">
                <button type="button" onclick="addBlock('議題', 'bg-yellow-50 border-yellow-400')" class="px-4 py-1 bg-yellow-200 text-yellow-800 rounded-full text-sm">
                    議題
                </button>

                <button type="button" onclick="addBlock('アイデア', 'bg-blue-50 border-blue-400')" class="px-4 py-1 bg-blue-200 text-blue-800 rounded-full text-sm">
                    アイデア
                </button>

                <button type="button" onclick="addBlock('決定事項', 'bg-green-50 border-green-400')" class="px-4 py-1 bg-green-200 text-green-800 rounded-full text-sm">
                    決定事項
                </button>

                <button type="button" onclick="addBlock('リスク', 'bg-red-50 border-red-400')" class="px-4 py-1 bg-red-200 text-red-800 rounded-full text-sm">
                    リスク
                </button>
            </div> -->

            <form action="{{ route('memos.store') }}" method="POST" class="space-y-6">
                @csrf

                <input 
                    type="text"
                    name="title"
                    placeholder="タイトルを入力..."
                    class="w-full text-xl font-semibold border-b border-gray-300 focus:outline-none focus:border-blue-500 pb-2"
                >

                <div id="memoBlocks" class="space-y-4"></div>

                <!-- <div class="flex justify-end">
                    <button class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-xl shadow">
                        保存する
                    </button>
                </div> -->
            </form>

        </div>
    </div>

</div>

<script>
const expertMode = document.getElementById("expertMode");
let activeEditor = null;

function addBlock(title, colorClasses) {

    const container = document.getElementById('memoBlocks');

    const block = document.createElement('div');
    block.className = `relative p-4 border-l-4 rounded-lg ${colorClasses}`;

    block.innerHTML = `
        <div class="flex justify-between items-start mb-2">
            <p class="font-semibold">${title}</p>

            <div class="flex gap-2 items-center">

                <button type="button"
                    class="copyBtn text-gray-400 hover:text-blue-500 text-sm">
                    コピー
                </button>

                <button type="button"
                    onclick="this.closest('.relative').remove()"
                    class="text-gray-400 hover:text-red-500 text-sm">
                    ✕
                </button>
            </div>
        </div>

        <div contenteditable="true"
            class="memoEditor w-full bg-transparent focus:outline-none min-h-[100px] border rounded p-2">
        </div>

        <input type="hidden" name="content[]" class="hiddenContent">

        <p class="text-right text-xs text-gray-400 charCount hidden">
            あと20文字
        </p>
    `;

    container.appendChild(block);

    const editor = block.querySelector(".memoEditor");
    const counter = block.querySelector(".charCount");

    editor.addEventListener("focus", function () {
        activeEditor = editor;
    });

    /* ===== エキスパートモード文字数制限 ===== */

    function updateCount() {
        const text = editor.innerText;
        const remaining = 20 - text.length;

        counter.innerText = "あと" + remaining + "文字";

        if (remaining <= 5) {
            counter.classList.remove("text-gray-400");
            counter.classList.add("text-red-500");
        } else {
            counter.classList.remove("text-red-500");
            counter.classList.add("text-gray-400");
        }

        if (remaining < 0) {
            editor.innerText = text.substring(0, 20);
        }
    }

    editor.addEventListener("input", function () {
        if (expertMode.checked) {
            updateCount();
        }
    });

    if (expertMode.checked) {
        counter.classList.remove("hidden");
        updateCount();
    }

    /* ===== コピー処理 ===== */

    block.querySelector(".copyBtn").addEventListener("click", function () {

        const heading = block.querySelector("p").innerText;
        const content = editor.innerText;

        if (content.trim() === "") {
            alert("コピーする内容がありません");
            return;
        }

        const textToCopy = "【" + heading + "】\n" + content;

        navigator.clipboard.writeText(textToCopy)
            .then(() => {
                this.innerText = "✓";
                setTimeout(() => this.innerText = "コピー", 1500);
            });
    });
}

/* エキスパートモード切替 */
expertMode.addEventListener("change", function () {

    const editors = document.querySelectorAll(".memoEditor");

    editors.forEach(editor => {

        const counter = editor.parentElement.querySelector(".charCount");

        if (expertMode.checked) {

            counter.classList.remove("hidden");

            const text = editor.innerText;
            if (text.length > 20) {
                editor.innerText = text.substring(0, 20);
            }

            counter.innerText = "あと" + (20 - editor.innerText.length) + "文字";

        } else {
            counter.classList.add("hidden");
        }

    });
});
/*
textareas.forEach(textarea => {

    const counter = textarea.parentElement.querySelector(".charCount");

    if (expertMode.checked) {
        textarea.maxLength = 20;
        counter.classList.remove("hidden");
        counter.innerText = "あと" + (20 - textarea.value.length) + "文字";
    } else {
        textarea.removeAttribute("maxLength");
        counter.classList.add("hidden");
    }

});
*/
document.getElementById("copyAllTopBtn").addEventListener("click", function () {

    const title = document.querySelector('input[name="title"]').value;
    const blocks = document.querySelectorAll("#memoBlocks > div");

    let fullText = "";

    if (title.trim() !== "") {
        fullText += "■ " + title + "\n\n";
    }

    blocks.forEach(block => {
        const heading = block.querySelector("p").innerText;
        const content = block.querySelector(".memoEditor").innerText;

        if (content.trim() !== "") {
            fullText += "【" + heading + "】\n";
            fullText += content + "\n\n";
        }
    });

    if (fullText.trim() === "") {
        alert("コピーする内容がありません");
        return;
    }

    navigator.clipboard.writeText(fullText)
        .then(() => {
            this.innerText = "✓";
            setTimeout(() => this.innerText = "全体をコピー", 1500);
        });
});

document.querySelector("form").addEventListener("submit", function() {

    document.querySelectorAll("#memoBlocks > div").forEach(block => {
        block.querySelector(".hiddenContent").value =
            block.querySelector(".memoEditor").innerHTML;
    });

});

/* ===== ツールバー処理 ===== */

document.querySelectorAll(".toolbar-btn").forEach(btn => {
    btn.addEventListener("click", function () {

        if (!activeEditor) return;

        activeEditor.focus();
        document.execCommand(this.dataset.command);

        updateToolbarState();
    });
});

document.querySelectorAll(".color-btn").forEach(btn => {
    btn.addEventListener("click", function () {

        if (!activeEditor) return;

        activeEditor.focus();
        document.execCommand("foreColor", false, this.dataset.color);

        updateToolbarState();
    });
});

function updateToolbarState() {

    const toggleCommands = [
        "bold",
        "italic",
        "underline"
    ];

    toggleCommands.forEach(command => {

        const button = document.querySelector(`[data-command="${command}"]`);
        if (!button) return;

        if (document.queryCommandState(command)) {
            button.classList.add("ring-2", "ring-indigo-500", "bg-indigo-50");
        } else {
            button.classList.remove("ring-2", "ring-indigo-500", "bg-indigo-50");
        }

    });

    /* ===== 文字色 ===== */

    const currentColor = document.queryCommandValue("foreColor");

    document.querySelectorAll(".color-btn").forEach(btn => {

        btn.classList.remove("ring-2", "ring-indigo-500");

        if (!currentColor && btn.dataset.color === "black") {
            btn.classList.add("ring-2", "ring-indigo-500");
        }

        else if (currentColor &&
            currentColor.toLowerCase().includes(btn.dataset.color)) {

            btn.classList.add("ring-2", "ring-indigo-500");
        }

    });

    /* ===== フォントサイズ ===== */

    const currentSize = document.queryCommandValue("fontSize");
    const sizeSelect = document.getElementById("fontSize");

    if (sizeSelect && currentSize) {
        sizeSelect.value = currentSize;
    }
}

    document.addEventListener("selectionchange", function () {
        if (activeEditor) {
            updateToolbarState();
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const container = document.getElementById('memoBlocks');

    new Sortable(container, {
        animation: 250,
        ghostClass: 'bg-gray-100'
    });

});
</script>
@endsection
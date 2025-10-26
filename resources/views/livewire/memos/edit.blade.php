<?php

use App\Models\Memo;
use Illuminate\Support\Facades\Route;
use function Livewire\Volt\{state, rules, mount};

// メモIDをルートパラメータから取得
$memoId = Route::current()->parameter('memo');

// 状態の初期化
state([
    'title' => '',
    'body' => '',
    'memo' => null,
]);

// バリデーションルール
rules([
    'title' => ['required', 'max:50'],
    'body' => ['required', 'max:2000'],
]);

// マウント時にメモを取得
mount(function () use ($memoId) {
    $this->memo = Memo::findOrFail($memoId);

    // 権限チェック
    if ($this->memo->user_id !== auth()->id()) {
        abort(403);
    }

    // フォームに値をセット
    $this->title = $this->memo->title;
    $this->body = $this->memo->body;
});

// フォーム送信処理
$updateMemo = function () {
    $this->validate();

    // メモを更新
    $this->memo->update([
        'title' => $this->title,
        'body' => $this->body,
    ]);

    // メモ詳細画面にリダイレクト
    return redirect()->route('memos.show', $this->memo);
};

?>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">
                    {{ __('メモ編集') }}
                </h1>

                <form wire:submit="updateMemo" class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('タイトル') }}
                        </label>
                        <input wire:model="title" type="text" id="title"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="body" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('本文') }}
                        </label>
                        <textarea wire:model="body" id="body" rows="10"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"></textarea>
                        @error('body')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('memos.show', $memo) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('キャンセル') }}
                        </a>

                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('更新') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

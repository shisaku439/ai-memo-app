<?php

use App\Models\Memo;
use Illuminate\Support\Facades\Route;
use function Livewire\Volt\{state, mount};

// メモIDをルートパラメータから取得
$memoId = Route::current()->parameter('memo');

// マウント時にメモを取得
state(['memo' => null]);

mount(function () use ($memoId) {
    $this->memo = Memo::findOrFail($memoId);
});

?>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                        {{ $memo->title }}
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ __('作成日') }}: {{ $memo->created_at->format('Y年m月d日') }}
                    </p>
                </div>

                <div class="prose dark:prose-invert max-w-none">
                    <div class="whitespace-pre-wrap">{{ $memo->body }}</div>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <div>
                        <a href="{{ route('memos.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('戻る') }}
                        </a>
                    </div>

                    <div>
                        @if ($memo->user_id === auth()->id())
                            <a href="{{ route('memos.edit', $memo) }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('編集') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

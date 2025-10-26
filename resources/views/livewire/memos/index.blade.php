<?php

use App\Models\Memo;
use Illuminate\Support\Collection;
use function Livewire\Volt\{state, mount};

state(['memos' => Collection::empty()]);

mount(function () {
    // ログインユーザーのメモを取得
    $this->memos = auth()->user()->memos()->latest()->get();
});

?>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                        {{ __('メモ一覧') }}
                    </h1>
                    <a href="{{ route('memos.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        {{ __('新規作成') }}
                    </a>
                </div>

                @if ($memos->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-500 dark:text-gray-400">{{ __('メモがありません') }}</p>
                    </div>
                @else
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($memos as $memo)
                            <li class="py-3">
                                <a href="{{ route('memos.show', $memo) }}"
                                    class="block hover:bg-gray-50 dark:hover:bg-gray-700 px-4 py-3 rounded-lg transition-colors">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            {{ $memo->title }}
                                        </span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $memo->created_at->format('Y/m/d') }}
                                        </span>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>

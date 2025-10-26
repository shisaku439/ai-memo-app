<?php

namespace Database\Seeders;

use App\Models\Memo;
use App\Models\User;
use Illuminate\Database\Seeder;

class MemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ユーザーを取得または作成
        $user = User::first() ?? User::factory()->create();

        // サンプルメモを作成
        Memo::create([
            'user_id' => $user->id,
            'title' => 'PHP',
            'body' => 'PHPは、Hypertext Preprocessorの略です。',
        ]);

        Memo::create([
            'user_id' => $user->id,
            'title' => 'HTML',
            'body' => 'HTMLは、Hypertext Markup Languageの略です。',
        ]);

        Memo::create([
            'user_id' => $user->id,
            'title' => 'CSS',
            'body' => "CSSは、\nCascading Style Sheets\nの略です。",
        ]);

        Memo::create([
            'user_id' => $user->id,
            'title' => '混在',
            'body' => "Test123 てすとアイウエオｱｲｳｴｵ\n漢字！ＡＢＣ ａｂｃ １２３   😊✨",
        ]);
    }
}

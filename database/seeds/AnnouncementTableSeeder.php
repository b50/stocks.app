<?php

use Illuminate\Database\Seeder;

class AnnouncementTableSeeder extends Seeder {

    public function run()
    {
        DB::table('announcements')->delete();
        \App\Models\Announcement::create([
            'id' => 1,
            'content' => 'This is an old announcement...',
            'user_id' => 1
        ]);
        \App\Models\Announcement::create([
            'id' => 2,
            'content' => 'This is an announcement...',
            'user_id' => 1
        ]);
    }
}

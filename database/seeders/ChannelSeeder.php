<?php

namespace Database\Seeders;

use App\Models\Channel;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Channel::truncate();

        DB::table('channels')->insert([
            [
                'user1_id' => 1,
                'user2_id' => 2,
                'name' => 'chat-1-2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user1_id' => 1,
                'user2_id' => 3,
                'name' => 'chat-1-3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user1_id' => 1,
                'user2_id' => 4,
                'name' => 'chat-1-4',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user1_id' => 1,
                'user2_id' => 5,
                'name' => 'chat-1-5',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user1_id' => 1,
                'user2_id' => 6,
                'name' => 'chat-1-6',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user1_id' => 1,
                'user2_id' => 7,
                'name' => 'chat-1-7',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user1_id' => 1,
                'user2_id' => 8,
                'name' => 'chat-1-8',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user1_id' => 1,
                'user2_id' => 9,
                'name' => 'chat-1-9',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}

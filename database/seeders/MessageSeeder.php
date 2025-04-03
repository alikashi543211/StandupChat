<?php

namespace Database\Seeders;

use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Message::truncate();

        DB::table('messages')->insert([
            [
                'channel_id' => 1,
                'user_id' => 1,
                'message' => 'Assalam-o-Alaikum',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 1,
                'user_id' => 2,
                'message' => 'Walaikum Salam',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 1,
                'user_id' => 1,
                'message' => 'How are you?',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 1,
                'user_id' => 2,
                'message' => 'I am fine and what about you?',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 1,
                'user_id' => 1,
                'message' => 'I am also fine !',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 1,
                'user_id' => 2,
                'message' => 'Good !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Second User Chat
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'Hello, How are you ?',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 3,
                'message' => 'I am fine and what about you ?',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'channel_id' => 2,
                'user_id' => 1,
                'message' => 'I am Fine !!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}

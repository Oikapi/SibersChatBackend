<?php

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChannelUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $channels = Channel::all();

        // Attach users to channels
        foreach ($channels as $channel) {
            $channel->users()->attach(
                $users->random(rand(1, 5))->pluck('id')->toArray()
            );
        }
    }
}

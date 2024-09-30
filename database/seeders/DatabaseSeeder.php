<?php

namespace Database\Seeders;

use App\Models\Commend;
use App\Models\Post;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Psy\Readline\Hoa\Console;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        User::factory()
//            ->has(Post::factory()->count(5))
//            ->count(3)
//            ->create();
//
//
        $users = User::factory(5)->create();
        foreach ($users as $user) {
//          $post = Post::factory()->create(['user_id'=>$user->id]);
            $post = Post::factory()->for($user)->create();
            foreach ($users as $newUser) {
                if($user->id != $newUser->id) {
                    Commend::factory()->for($newUser)->for($post)->create() ;
                }

            }

        }

    }
}

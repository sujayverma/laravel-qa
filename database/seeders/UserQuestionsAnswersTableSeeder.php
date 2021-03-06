<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\User;
use App\Models\Answer;

class UserQuestionsAnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('answers')->delete();
        \DB::table('questions')->delete();
        \DB::table('users')->delete();
        
        // \App\Models\User::factory(10)->create();
        // Creates 3 users
        User::factory(3)->create()->each(function($u){
            $u->questions() // for each users save random 1 to 5 questions using hasMany relation function questions()
            ->saveMany(
                Question::factory(rand(1,5))->make()
            )->each(function($q){
                $q->answers() // for each questions save 1 to 5 answers using DB relation hasMany fucntion answers.
                    ->saveMany(
                        Answer::factory(rand(1,5))->make()
                    );
            });
        });
    }
}

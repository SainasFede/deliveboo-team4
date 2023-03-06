<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamMembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $team_members_array = config('team.team_members');
        // Swimmer-Rubber-Duck.webp
        foreach($team_members_array as $team_member){
            $new_member = new TeamMember();
            $new_member->name = $team_member['name'];
            $new_member->surname = $team_member['surname'];
            $new_member->li_link = $team_member['li_link'];
            $new_member->gh_link = $team_member['gh_link'];
            $new_member->img = $team_member['img'];
            $new_member->save();
        }

    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workers = \App\Models\User::where('id','=',3)->get(['id','name']); //Get Emily's user
        \App\Models\Task::factory(1)->create([
            'name' => 'Job offer at LinkedIn',
            'description' => 'As the first step in recruiting a new Full Stack developer, create a job offer at LinkedIn. The more information about the role, the better. Contact Mark Lloyd (CTO) if more information about the role is needed.',
            'status' => 4,
            'deadline' => '2023-05-02 23:59:00',
            'workers' => json_encode($workers),
            'priority' => 5,
            'updated_at' => '2023-05-02 13:00:00'
        ]);
        \App\Models\Task::factory()->create([
            'name' => 'Contact Jorge at LinkedIn',
            'description' => 'Found a LinkedIn profile that may fit the job role. His name is Jorge Gomez. Send him a message.',
            'status' => 4,
            'deadline' => '2023-05-03 23:59:00',
            'workers' => json_encode($workers),
            'priority' => 5,
            'updated_at' => '2023-05-03 13:00:00'
        ]);
        \App\Models\Task::factory()->create([
            'name' => 'Book Jorge\'s 1st Interview',
            'description' => 'Jorge answered first message. Check with him his availability for an interview',
            'status' => 4,
            'deadline' => '2023-05-09 23:59:00',
            'workers' => json_encode($workers),
            'priority' => 5,
            'updated_at' => '2023-05-09 10:26:00'
        ]);
        \App\Models\Task::factory()->create([
            'name' => 'Interview with Jorge',
            'description' => 'Arranged a Teams meeting with Jorge on May 11th, at 01:00p.m.',
            'status' => 4,
            'deadline' => '2023-05-11 13:00:00',
            'workers' => json_encode($workers),
            'priority' => 5,
            'updated_at' => '2023-05-11 12:36:00'
        ]);
        \App\Models\Task::factory()->create([
            'name' => 'Second 1st Interview with Jorge',
            'description' => 'First meeting had to be cancelled, so it is necessary to book another one. UPDATE: next meeting will be on May 17th at 01:00p.m.',
            'status' => 4,
            'workers' => json_encode($workers),
            'priority' => 5,
            'updated_at' => '2023-05-12 17:32:00'
        ]);
        \App\Models\Task::factory()->create([
            'name' => 'Jorge\'s 1st Interview',
            'description' => 'Sent Jorge a link to Teams meeting. Review the form for this first interview. UPDATE: interview went quite fine. Talk to Mark Lloyd and check if he wants to meet Jorge',
            'status' => 4,
            'deadline' => '2023-05-17 13:00:00',
            'workers' => json_encode($workers),
            'priority' => 5,
            'updated_at' => '2023-05-17 13:45:00'
        ]);
        \App\Models\Task::factory()->create([
            'name' => 'Book 2nd Interview with Jorge',
            'description' => 'Talked to Mark and Jorge. Booked a meeting to May 19th at 01:30p.m.',
            'status' => 4,
            'deadline' => '2023-05-18 23:59:59',
            'workers' => json_encode($workers),
            'priority' => 5,
            'updated_at' => '2023-05-18 11:09:00'
        ]);

        \App\Models\Task::factory()->create([
            'name' => 'Second Interview with Jorge',
            'description' => 'Meet with Jorge via Teams. Explain the company, the role, and the test. UPDATE: meeting went quite well. Talk to Emily to see which are the next steps.',
            'status' => 4,
            'deadline' => '2023-05-19 13:30:00',
            'workers' => json_encode($workers),
            'priority' => 5,
            'updated_at' => '2023-05-19 14:15:00'
        ]);
        $workers = \App\Models\User::where('id','=',2)->get(['id','name']); //Get Mark's user
        \App\Models\Task::factory()->create([
            'name' => 'Second Interview with Jorge',
            'description' => 'Meet with Jorge via Teams. Explain the company, the role, and the test. UPDATE: meeting went quite well. Talk to Emily to see which are the next steps.',
            'status' => 4,
            'deadline' => '2023-05-19 13:30:00',
            'workers' => json_encode($workers),
            'priority' => 5,
            'updated_at' => '2023-05-19 14:15:00'
        ]);
        $workers = \App\Models\User::where('id','>=',2)->where('id','<=',3)->get(['id','name']); //Get Mark's and Emily's users
        \App\Models\Task::factory()->create([
            'name' => 'Create Jorge\' test',
            'description' => 'Mark and Emily should come up with a test to apply to Jorge as the last round of interview. UPDATE: test is ready. Sent Jorge instructions via e-mail.',
            'status' => 4,
            'workers' => json_encode($workers),
            'priority' => 5,
            'updated_at' => '2023-06-19 15:25:00'
        ]);
        $workers = \App\Models\User::where('id','=',1)->get(['id','name']); //Get Jorge's user
        \App\Models\Task::factory()->create([
            'name' => 'Take test',
            'description' => 'Recieved test instructions via e-mail. Build a Testing App according to the instructions in the email and in the GitHub Repo URL',
            'status' => 2,
            'deadline' => '2023-06-07 23:59:59',
            'workers' => json_encode($workers),
            'priority' => 99,
        ]);
        $workers = \App\Models\User::where('id','=',2)->get(['id','name']); //Get Mark's user
        \App\Models\Task::factory()->create([
            'name' => 'Review Jorge\'s code',
            'description' => 'Wait Jorge submit the Testing App. review his code and add comments to things the dev team believe could be improved or are blockers.',
            'status' => 1,
            'workers' => json_encode($workers),
            'priority' => 1,
        ]);
        $workers = \App\Models\User::where('id','=',3)->get(['id','name']); //Get Emily's user
        \App\Models\Task::factory()->create([
            'name' => 'Give Jorge\'s results',
            'description' => 'Wait Mark send the results and then contact Jorge to give the good or the bad news.',
            'status' => 1,
            'workers' => json_encode($workers),
            'priority' => 1,
        ]);
    }
}

// \App\Models\Task::factory()->create([
        //     'name' => 'Second Interview with Jorge',
        //     'description' => 'Meet with Jorge via Teams. Explain the company, the role, and the test. UPDATE: meeting went quite well. Talk to Emily to see which are the next steps.',
        //     'status' => 4,
        //     'deadline' => '2023-05-19 13:30:00',
        //     'workers' => json_encode($workers),
        //     'priority' => 5,
        //     'updated_at' => '2023-05-19 14:15:00'
        // ]);
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserPivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            1 => [
                'role' => [1],
            ],

        ];

        foreach ($items as $id => $item) {
            $user = User::find($id);

            foreach ($item as $key => $ids) {
                $user->{$key}()->sync($ids);
            }
        }
    }
}

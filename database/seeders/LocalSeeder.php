<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = fake('pt_BR');

        foreach (range(1, 3) as $index) {

            $company = Company::updateOrCreate(
                [
                    'email' => $faker->companyEmail(),
                    'cnpj'  => $faker->cnpj(false)
                ],
                [
                    'name'  => $faker->company(),
                    'phone' => $faker->cellphone(false, true) 
                ]
            );

            $roles = [];

            foreach (range(1, 3) as $role_index) {

                $role = Role::updateOrCreate(
                    [
                        'name' => fake('en_US')->jobTitle()
                    ],
                    [
                        'company_id' => $company->id
                    ]
                );

                $roles[] = $role->id;
        
                $role->permissions()->sync(
                    Permission::query()->pluck('id')->toArray()
                );
                
            }

            foreach (range(1, rand(5, 10)) as $user_index) {

                $user = User::updateOrCreate(
                    [
                        'email' => $faker->email()
                    ],
                    [
                        'name'  => $faker->name(),
                        'password' => bcrypt('123456789'),
                        'company_id' => $company->id,
                    ]
                );
        
                $user->roles()->sync(
                    array_map(
                        function ($value) use ($roles) {
                            return $roles[$value];
                        },
                        (array) array_rand($roles, rand(1, 3))
                    )
                );
                
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actions  = [
            [
                'key' => 'access',
                'description' => 'Acessar'
            ],
            [
                'key' => 'view',
                'description' => 'Visualizar'
            ],
            [
                'key' => 'create',
                'description' => 'Criar'
            ],
            [
                'key' => 'edit',
                'description' => 'Editar'
            ],
            [
                'key' => 'delete',
                'description' => 'Excluir'
            ],
        ];

        $scopes = [
            [
                'key' => 'user',
                'description' => 'Usuários'
            ]
        ];

        foreach ($scopes as $scope) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'scope'       => "{$scope['description']}",
                    'key'         => "{$scope['key']}_{$action['key']}",
                    'description' => "{$scope['description']} - {$action['description']}",
                ]);
            }
        }
    }
}

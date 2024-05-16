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
            ],
            [
                'key' => 'employee_finance_movement',
                'description' => 'Movimentação Financeira de Funcionários',
                'extra_actions' => [
                    [
                        'key' => 'approve',
                        'description' => 'Aprovar'
                    ]
                ]
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

            if ( isset($scope['extra_actions']) ) {
                foreach ($scope['extra_actions'] as $extra_action) {
                    Permission::firstOrCreate([
                        'scope'       => "{$scope['description']}",
                        'key'         => "{$extra_action['key']}",
                        'description' => "{$scope['description']} - {$extra_action['description']}",
                    ]);
                }
            }
        }
    }
}

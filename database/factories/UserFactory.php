<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'role_id' => Role::where('name', 'Teknisi')->first()?->id ?? 2,
            'name' => $this->faker->name(),
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'password' => bcrypt('password123'),
            'technician_code' => null,
            'status' => 'active',
            'last_login_at' => null,
            'remember_token' => null,
        ];
    }

    public function admin(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => Role::where('name', 'Super Admin')->first()?->id ?? 1,
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@xray.local',
                'phone' => '081234567890',
                'password' => bcrypt('admin123'),
                'technician_code' => 'ADMIN-001',
                'status' => 'active',
            ];
        });
    }

    public function teknisi(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => Role::where('name', 'Teknisi')->first()?->id ?? 2,
                'status' => 'active',
            ];
        });
    }

    public function supervisor(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => Role::where('name', 'Supervisor')->first()?->id ?? 3,
                'status' => 'active',
            ];
        });
    }
}
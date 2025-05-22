<?php

namespace Database\Factories;

use App\Models\Tb_karyawan;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tb_karyawan>
 */
class Tb_karyawanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Tb_karyawan::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'alamat_karyawan' => $this->faker->address(),
            'no_telepon' => $this->faker->phoneNumber(),
            'qr_code' => Str::random(12),
            'active_st' => $this->faker->boolean(80), // 80% kemungkinan true
        ];

    }
}
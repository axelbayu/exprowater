<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        $statuses = ['pending', 'diproses', 'selesai', 'dibatalkan'];
        
        return [
            'nama_pelanggan' => $this->faker->name(),
            'telepon' => $this->faker->phoneNumber(),
            'produk' => $this->faker->word(),
            'jumlah' => $this->faker->numberBetween(1, 100),
            'total_harga' => $this->faker->numberBetween(100000, 10000000),
            'status' => $this->faker->randomElement($statuses),
            'tanggal_order' => $this->faker->dateTimeThisMonth(),
            'catatan' => $this->faker->optional()->sentence(),
        ];
    }
}

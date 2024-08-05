<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'telefone' => $this->faker->phoneNumber,
            'CPF' => $this->generatedCpf()
        ];
    }

    private function generatedCpf()
    {
     $cpf = '';
        for ($i = 0; $i < 9; $i++) {
            $cpf .= mt_rand(0, 9);
        }

        $cpf .= $this->calculateCpfDigit($cpf);
        $cpf .= $this->calculateCpfDigit($cpf);

        return $cpf;
    }

    private function calculateCpfDigit($cpf)
    {
        $sum = 0;
        $length = strlen($cpf);

        for ($i = 0; $i < $length; $i++) {
            $sum += (int)$cpf[$i] * (10 - $i);
        }

        $remainder = $sum % 11;
        return $remainder < 2 ? 0 : 11 - $remainder;
    }
}

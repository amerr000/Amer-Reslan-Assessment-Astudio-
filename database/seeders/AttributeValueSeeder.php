<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AttributeValue;

class AttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AttributeValue::create([
            'attribute_id' => 1,
            'project_id' => 1,
            'value' => 'IT',
        ]);

        AttributeValue::create([
            'attribute_id' => 2,
            'project_id' => 1,
            'value' => '2024-03-01',
        ]);

        AttributeValue::create([
            'attribute_id' => 3,
            'project_id' => 1,
            'value' => '2024-06-01',
        ]);
    }
}

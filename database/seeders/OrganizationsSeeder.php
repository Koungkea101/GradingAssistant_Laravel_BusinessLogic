<?php

namespace Database\Seeders;

use App\Models\Organizations;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 random organizations using the factory
        Organizations::factory(10)->create();

        // Create or update specific organizations for testing
        Organizations::updateOrCreate(
            ['slug' => 'sample-university'],
            [
                'name' => 'Sample University',
                'email' => 'admin@sampleuniversity.edu',
                'phone' => '+1-555-123-4567',
                'address' => '123 Education St, Learning City, LC 12345',
                'is_active' => true,
            ]
        );

        Organizations::updateOrCreate(
            ['slug' => 'demo-school-district'],
            [
                'name' => 'Demo School District',
                'email' => 'info@demoschool.edu',
                'phone' => '+1-555-987-6543',
                'address' => '456 School Ave, Education Town, ET 67890',
                'is_active' => true,
            ]
        );
    }
}

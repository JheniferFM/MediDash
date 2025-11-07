<?php

namespace Database\Seeders;

use App\Models\User;
use App\Infrastructure\Models\Patient;
use App\Infrastructure\Models\Doctor;
use App\Infrastructure\Models\Appointment;
use App\Infrastructure\Models\Exam;
use App\Infrastructure\Models\Prescription;
use App\Infrastructure\Models\Role;
use Illuminate\Support\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Usuário de teste (com senha padrão)
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );

        // Papéis básicos
        $roles = [
            ['name' => 'Administrator', 'slug' => 'admin'],
            ['name' => 'Doctor', 'slug' => 'doctor'],
            ['name' => 'Receptionist', 'slug' => 'receptionist'],
        ];
        foreach ($roles as $r) {
            Role::firstOrCreate(['slug' => $r['slug']], $r);
        }
        $adminRole = Role::where('slug','admin')->first();
        if ($adminRole && !$user->roles()->where('slug','admin')->exists()) {
            $user->roles()->attach($adminRole->id);
        }

        // Base de pacientes e médicos
        Patient::factory()->count(200)->create();
        Doctor::factory()->count(30)->create();

        // Consultas: distribuídas em ~2 semanas, com parte hoje agendada
        // Primeiro, criar uma base geral
        Appointment::factory()->count(220)->create();
        // Em seguida, reforçar consultas de hoje para alimentar o gauge e KPIs
        Appointment::factory()->scheduledToday()->count(60)->create();

        // Exames: pendentes, agendados, realizados, cancelados
        // Cria uma mistura rica para a pizza e para KPIs
        Exam::factory()->count(120)->create([ 'status' => 'pending' ]);
        Exam::factory()->count(90)->create([ 'status' => 'scheduled' ]);
        Exam::factory()->count(70)->create([ 'status' => 'performed' ]);
        Exam::factory()->count(30)->create([ 'status' => 'cancelled' ]);

        // Prescrições básicas
        $patients = \App\Infrastructure\Models\Patient::pluck('id');
        $doctors = \App\Infrastructure\Models\Doctor::pluck('id');
        if ($patients->count() > 0 && $doctors->count() > 0) {
            for ($i=0; $i<50; $i++) {
                Prescription::create([
                    'patient_id' => $patients->random(),
                    'doctor_id' => $doctors->random(),
                    'content' => 'Take medication as prescribed. Follow-up in 7 days.',
                ]);
            }
        }
    }
}

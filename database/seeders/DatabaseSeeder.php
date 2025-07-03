<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Contact;
use App\Models\Subject;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Note;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Subjects first
        $subjects = [
            ['name' => 'Mathematics', 'code' => 'MATH', 'description' => 'Basic mathematics course'],
            ['name' => 'Physics', 'code' => 'PHYS', 'description' => 'Introduction to physics'],
            ['name' => 'Chemistry', 'code' => 'CHEM', 'description' => 'General chemistry'],
            ['name' => 'Biology', 'code' => 'BIO', 'description' => 'Life sciences'],
            ['name' => 'History', 'code' => 'HIST', 'description' => 'World history'],
            ['name' => 'Literature', 'code' => 'LIT', 'description' => 'Hungarian literature'],
            ['name' => 'English', 'code' => 'ENG', 'description' => 'English language'],
            ['name' => 'Physical Education', 'code' => 'PE', 'description' => 'Physical fitness and sports'],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }

        // Create Rooms
        $rooms = [
            ['name' => 'Room 101', 'location' => 'First Floor', 'capacity' => 30],
            ['name' => 'Room 102', 'location' => 'First Floor', 'capacity' => 25],
            ['name' => 'Room 201', 'location' => 'Second Floor', 'capacity' => 35],
            ['name' => 'Room 202', 'location' => 'Second Floor', 'capacity' => 28],
            ['name' => 'Lab A', 'location' => 'Science Wing', 'capacity' => 20],
            ['name' => 'Lab B', 'location' => 'Science Wing', 'capacity' => 20],
            ['name' => 'Gymnasium', 'location' => 'Sports Complex', 'capacity' => 50],
            ['name' => 'Library', 'location' => 'Main Building', 'capacity' => 40],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }

        // Create Owner
        $owner = User::create([
            'name' => 'System Owner',
            'password' => Hash::make('password'),
            'role' => 'Owner',
            'is_active' => true,
        ]);

        Contact::create([
            'user_id' => $owner->id,
            'phone' => '+36-1-234-5678',
            'email' => 'owner@school.com',
            'city' => 'Budapest',
            'street' => 'Fő utca',
            'house_number' => '1',
            'zip_code' => '1011',
        ]);

        // Create Schedule Admin
        $scheduleAdmin = User::create([
            'name' => 'Schedule Administrator',
            'password' => Hash::make('password'),
            'role' => 'Schedule_admin',
            'is_active' => true,
        ]);

        Contact::create([
            'user_id' => $scheduleAdmin->id,
            'phone' => '+36-1-234-5679',
            'email' => 'admin@school.com',
            'city' => 'Budapest',
            'street' => 'Kossuth utca',
            'house_number' => '12',
            'zip_code' => '1053',
        ]);

        // Create Teachers
        $teacherData = [
            ['name' => 'Dr. Kovács János', 'email' => 'kovacs.janos@school.com', 'specialty' => 'Mathematics'],
            ['name' => 'Nagy Éva', 'email' => 'nagy.eva@school.com', 'specialty' => 'Physics'],
            ['name' => 'Szabó Péter', 'email' => 'szabo.peter@school.com', 'specialty' => 'Chemistry'],
            ['name' => 'Tóth Mária', 'email' => 'toth.maria@school.com', 'specialty' => 'Biology'],
            ['name' => 'Horváth Zoltán', 'email' => 'horvath.zoltan@school.com', 'specialty' => 'History'],
            ['name' => 'Kiss Anna', 'email' => 'kiss.anna@school.com', 'specialty' => 'Literature'],
            ['name' => 'Varga Tamás', 'email' => 'varga.tamas@school.com', 'specialty' => 'English'],
            ['name' => 'Molnár Gábor', 'email' => 'molnar.gabor@school.com', 'specialty' => 'Physical Education'],
        ];

        $teachers = [];
        foreach ($teacherData as $index => $data) {
            $user = User::create([
                'name' => $data['name'],
                'password' => Hash::make('password'),
                'role' => 'Teacher',
                'is_active' => true,
            ]);

            $teacher = Teacher::create([
                'user_id' => $user->id,
                'subject_specialty' => $data['specialty'],
                'is_active' => true,
            ]);

            Contact::create([
                'user_id' => $user->id,
                'phone' => '+36-1-' . str_pad(234 + $index, 3, '0', STR_PAD_LEFT) . '-' . str_pad(5680 + $index, 4, '0', STR_PAD_LEFT),
                'email' => $data['email'],
                'city' => 'Budapest',
                'street' => 'Tanár utca',
                'house_number' => (string)($index + 1),
                'zip_code' => '1' . str_pad($index + 10, 3, '0', STR_PAD_LEFT),
            ]);

            $teachers[] = $teacher;
        }

        // Create Students
        $studentData = [
            ['name' => 'Balázs Péter', 'email' => 'balazs.peter@student.com', 'class' => '9A', 'birth_date' => '2009-03-15'],
            ['name' => 'Farkas Eszter', 'email' => 'farkas.eszter@student.com', 'class' => '9A', 'birth_date' => '2009-07-22'],
            ['name' => 'Lakatos Dávid', 'email' => 'lakatos.david@student.com', 'class' => '9A', 'birth_date' => '2009-01-08'],
            ['name' => 'Németh Viktória', 'email' => 'nemeth.viktoria@student.com', 'class' => '9A', 'birth_date' => '2009-11-30'],
            ['name' => 'Papp Máté', 'email' => 'papp.mate@student.com', 'class' => '9B', 'birth_date' => '2009-05-12'],
            ['name' => 'Rácz Lilla', 'email' => 'racz.lilla@student.com', 'class' => '9B', 'birth_date' => '2009-09-18'],
            ['name' => 'Simon Bence', 'email' => 'simon.bence@student.com', 'class' => '9B', 'birth_date' => '2009-02-25'],
            ['name' => 'Takács Nóra', 'email' => 'takacs.nora@student.com', 'class' => '9B', 'birth_date' => '2009-12-03'],
            ['name' => 'Fekete Gergő', 'email' => 'fekete.gergo@student.com', 'class' => '10A', 'birth_date' => '2008-04-14'],
            ['name' => 'Juhász Sára', 'email' => 'juhasz.sara@student.com', 'class' => '10A', 'birth_date' => '2008-08-07'],
        ];

        $students = [];
        foreach ($studentData as $index => $data) {
            $user = User::create([
                'name' => $data['name'],
                'password' => Hash::make('password'),
                'role' => 'Student',
                'is_active' => true,
            ]);

            $student = Student::create([
                'user_id' => $user->id,
                'student_number' => 'STU' . str_pad($index + 1001, 4, '0', STR_PAD_LEFT),
                'class' => $data['class'],
                'birth_date' => $data['birth_date'],
                'is_active' => true,
            ]);

            Contact::create([
                'user_id' => $user->id,
                'phone' => '+36-20-' . str_pad(123 + $index, 3, '0', STR_PAD_LEFT) . '-' . str_pad(4567 + $index, 4, '0', STR_PAD_LEFT),
                'email' => $data['email'],
                'city' => 'Budapest',
                'street' => 'Diák utca',
                'house_number' => (string)($index + 1),
                'zip_code' => '1' . str_pad($index + 20, 3, '0', STR_PAD_LEFT),
            ]);

            $students[] = $student;
        }

        // Create Schedules
        $scheduleData = [
            ['subject_id' => 1, 'teacher_id' => 1, 'room_id' => 1, 'weekday' => 'H', 'start_time' => '08:00', 'end_time' => '08:45', 'group' => '9A'],
            ['subject_id' => 2, 'teacher_id' => 2, 'room_id' => 5, 'weekday' => 'H', 'start_time' => '09:00', 'end_time' => '09:45', 'group' => '9A'],
            ['subject_id' => 3, 'teacher_id' => 3, 'room_id' => 6, 'weekday' => 'K', 'start_time' => '08:00', 'end_time' => '08:45', 'group' => '9A'],
            ['subject_id' => 4, 'teacher_id' => 4, 'room_id' => 5, 'weekday' => 'K', 'start_time' => '09:00', 'end_time' => '09:45', 'group' => '9A'],
            ['subject_id' => 5, 'teacher_id' => 5, 'room_id' => 2, 'weekday' => 'Sze', 'start_time' => '08:00', 'end_time' => '08:45', 'group' => '9A'],
            ['subject_id' => 6, 'teacher_id' => 6, 'room_id' => 8, 'weekday' => 'Sze', 'start_time' => '09:00', 'end_time' => '09:45', 'group' => '9A'],
            ['subject_id' => 7, 'teacher_id' => 7, 'room_id' => 3, 'weekday' => 'Cs', 'start_time' => '08:00', 'end_time' => '08:45', 'group' => '9A'],
            ['subject_id' => 8, 'teacher_id' => 8, 'room_id' => 7, 'weekday' => 'Cs', 'start_time' => '09:00', 'end_time' => '09:45', 'group' => '9A'],
            ['subject_id' => 1, 'teacher_id' => 1, 'room_id' => 1, 'weekday' => 'P', 'start_time' => '08:00', 'end_time' => '08:45', 'group' => '9A'],
            ['subject_id' => 2, 'teacher_id' => 2, 'room_id' => 5, 'weekday' => 'P', 'start_time' => '09:00', 'end_time' => '09:45', 'group' => '9A'],

            // Schedules for 9B
            ['subject_id' => 1, 'teacher_id' => 1, 'room_id' => 1, 'weekday' => 'H', 'start_time' => '10:00', 'end_time' => '10:45', 'group' => '9B'],
            ['subject_id' => 2, 'teacher_id' => 2, 'room_id' => 5, 'weekday' => 'H', 'start_time' => '11:00', 'end_time' => '11:45', 'group' => '9B'],
            ['subject_id' => 3, 'teacher_id' => 3, 'room_id' => 6, 'weekday' => 'K', 'start_time' => '10:00', 'end_time' => '10:45', 'group' => '9B'],
            ['subject_id' => 4, 'teacher_id' => 4, 'room_id' => 5, 'weekday' => 'K', 'start_time' => '11:00', 'end_time' => '11:45', 'group' => '9B'],

            // Schedules for 10A
            ['subject_id' => 1, 'teacher_id' => 1, 'room_id' => 2, 'weekday' => 'H', 'start_time' => '12:00', 'end_time' => '12:45', 'group' => '10A'],
            ['subject_id' => 2, 'teacher_id' => 2, 'room_id' => 6, 'weekday' => 'H', 'start_time' => '13:00', 'end_time' => '13:45', 'group' => '10A'],
        ];

        $schedules = [];
        foreach ($scheduleData as $data) {
            $schedule = Schedule::create($data);
            $schedules[] = $schedule;
        }

        // Create Enrollments (enroll students in their class schedules)
        foreach ($students as $student) {
            foreach ($schedules as $schedule) {
                if (str_contains($schedule->group, $student->class)) {
                    Enrollment::create([
                        'student_id' => $student->id,
                        'schedule_id' => $schedule->id,
                        'is_active' => true,
                    ]);
                }
            }
        }

        // Create sample Grades
        $gradeValues = [5, 4, 4, 3, 5, 2, 4, 3, 5, 4];
        $gradeIndex = 0;

        foreach ($students as $studentIndex => $student) {
            if ($studentIndex < 5) { // Only for first 5 students
                foreach (range(1, 4) as $subjectId) { // First 4 subjects
                    Grade::create([
                        'student_id' => $student->id,
                        'subject_id' => $subjectId,
                        'teacher_id' => $subjectId, // Teacher ID matches subject ID in our setup
                        'grade' => $gradeValues[$gradeIndex % count($gradeValues)],
                        'description' => 'Test assignment grade',
                        'graded_at' => now()->subDays(rand(1, 30)),
                        'is_active' => true,
                    ]);
                    $gradeIndex++;
                }
            }
        }

        // Create sample Notes
        $noteTexts = [
            'Today we covered basic algebra. Students showed good understanding.',
            'Excellent participation in physics experiments.',
            'Need to review chemical equations next class.',
            'Biology lab went well, students are engaged.',
            'Historical timeline exercise completed successfully.',
        ];

        foreach (range(1, 5) as $i) {
            Note::create([
                'teacher_id' => $i,
                'subject_id' => $i,
                'schedule_id' => $i,
                'note_text' => $noteTexts[$i - 1],
                'is_active' => true,
            ]);
        }

        $this->command->info('Database seeded successfully with test users and data!');
        $this->command->info('Login information:');
        $this->command->info('All users have password: password');
        $this->command->info('');
        $this->command->info('User roles and names:');
        $this->command->info('Owner: System Owner');
        $this->command->info('Admin: Schedule Administrator');
        $this->command->info('Teachers: Dr. Kovács János, Nagy Éva, Szabó Péter, etc.');
        $this->command->info('Students: Balázs Péter, Farkas Eszter, Lakatos Dávid, etc.');
        $this->command->info('');
        $this->command->info('Note: Email addresses are stored in the contacts table, not users table.');
        $this->command->info('Contact emails: owner@school.com, admin@school.com, kovacs.janos@school.com, etc.');
    }
}

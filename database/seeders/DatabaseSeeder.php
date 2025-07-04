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
            ['name' => 'Geography', 'code' => 'GEO', 'description' => 'World geography and earth sciences'],
            ['name' => 'Art', 'code' => 'ART', 'description' => 'Visual arts and creativity'],
            ['name' => 'Music', 'code' => 'MUS', 'description' => 'Music theory and performance'],
            ['name' => 'Computer Science', 'code' => 'CS', 'description' => 'Programming and digital literacy'],
            ['name' => 'French', 'code' => 'FR', 'description' => 'French language'],
            ['name' => 'German', 'code' => 'DE', 'description' => 'German language'],
            ['name' => 'Philosophy', 'code' => 'PHIL', 'description' => 'Introduction to philosophy'],
            ['name' => 'Economics', 'code' => 'ECON', 'description' => 'Basic economics principles'],
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
            ['name' => 'Room 301', 'location' => 'Third Floor', 'capacity' => 32],
            ['name' => 'Room 302', 'location' => 'Third Floor', 'capacity' => 28],
            ['name' => 'Computer Lab', 'location' => 'Technology Wing', 'capacity' => 24],
            ['name' => 'Art Studio', 'location' => 'Arts Wing', 'capacity' => 20],
            ['name' => 'Music Room', 'location' => 'Arts Wing', 'capacity' => 25],
            ['name' => 'Language Lab', 'location' => 'Language Wing', 'capacity' => 22],
            ['name' => 'Conference Room', 'location' => 'Administration', 'capacity' => 15],
            ['name' => 'Auditorium', 'location' => 'Main Building', 'capacity' => 200],
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
            ['name' => 'Dr. Lukács Péter', 'email' => 'lukacs.peter@school.com', 'specialty' => 'Geography'],
            ['name' => 'Balogh Katalin', 'email' => 'balogh.katalin@school.com', 'specialty' => 'Art'],
            ['name' => 'Farkas László', 'email' => 'farkas.laszlo@school.com', 'specialty' => 'Music'],
            ['name' => 'Juhász Róbert', 'email' => 'juhasz.robert@school.com', 'specialty' => 'Computer Science'],
            ['name' => 'Mme. Dubois Claire', 'email' => 'dubois.claire@school.com', 'specialty' => 'French'],
            ['name' => 'Herr Weber Klaus', 'email' => 'weber.klaus@school.com', 'specialty' => 'German'],
            ['name' => 'Dr. Papp Gergely', 'email' => 'papp.gergely@school.com', 'specialty' => 'Philosophy'],
            ['name' => 'Simon Andrea', 'email' => 'simon.andrea@school.com', 'specialty' => 'Economics'],
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
            // Class 9A (15 students)
            ['name' => 'Balázs Péter', 'email' => 'balazs.peter@student.com', 'class' => '9A', 'birth_date' => '2009-03-15'],
            ['name' => 'Farkas Eszter', 'email' => 'farkas.eszter@student.com', 'class' => '9A', 'birth_date' => '2009-07-22'],
            ['name' => 'Lakatos Dávid', 'email' => 'lakatos.david@student.com', 'class' => '9A', 'birth_date' => '2009-01-08'],
            ['name' => 'Németh Viktória', 'email' => 'nemeth.viktoria@student.com', 'class' => '9A', 'birth_date' => '2009-11-30'],
            ['name' => 'Rácz Bence', 'email' => 'racz.bence@student.com', 'class' => '9A', 'birth_date' => '2009-04-12'],
            ['name' => 'Takács Lilla', 'email' => 'takacs.lilla@student.com', 'class' => '9A', 'birth_date' => '2009-08-25'],
            ['name' => 'Varga Márton', 'email' => 'varga.marton@student.com', 'class' => '9A', 'birth_date' => '2009-02-14'],
            ['name' => 'Molnár Fanni', 'email' => 'molnar.fanni@student.com', 'class' => '9A', 'birth_date' => '2009-10-03'],
            ['name' => 'Kelemen Ádám', 'email' => 'kelemen.adam@student.com', 'class' => '9A', 'birth_date' => '2009-06-18'],
            ['name' => 'Oláh Dóra', 'email' => 'olah.dora@student.com', 'class' => '9A', 'birth_date' => '2009-09-07'],
            ['name' => 'Pintér Kristóf', 'email' => 'pinter.kristof@student.com', 'class' => '9A', 'birth_date' => '2009-12-21'],
            ['name' => 'Balogh Zsófia', 'email' => 'balogh.zsofia@student.com', 'class' => '9A', 'birth_date' => '2009-05-09'],
            ['name' => 'Fekete Levente', 'email' => 'fekete.levente@student.com', 'class' => '9A', 'birth_date' => '2009-01-26'],
            ['name' => 'Juhász Emese', 'email' => 'juhasz.emese@student.com', 'class' => '9A', 'birth_date' => '2009-07-14'],
            ['name' => 'Szántó Benedek', 'email' => 'szanto.benedek@student.com', 'class' => '9A', 'birth_date' => '2009-11-05'],

            // Class 9B (14 students)
            ['name' => 'Papp Máté', 'email' => 'papp.mate@student.com', 'class' => '9B', 'birth_date' => '2009-05-12'],
            ['name' => 'Rácz Lilla', 'email' => 'racz.lilla@student.com', 'class' => '9B', 'birth_date' => '2009-09-18'],
            ['name' => 'Simon Bence', 'email' => 'simon.bence@student.com', 'class' => '9B', 'birth_date' => '2009-02-25'],
            ['name' => 'Takács Nóra', 'email' => 'takacs.nora@student.com', 'class' => '9B', 'birth_date' => '2009-12-03'],
            ['name' => 'Kovács Zoltán', 'email' => 'kovacs.zoltan@student.com', 'class' => '9B', 'birth_date' => '2009-03-28'],
            ['name' => 'Nagy Réka', 'email' => 'nagy.reka@student.com', 'class' => '9B', 'birth_date' => '2009-08-11'],
            ['name' => 'Szabó Richárd', 'email' => 'szabo.richard@student.com', 'class' => '9B', 'birth_date' => '2009-01-17'],
            ['name' => 'Tóth Vivien', 'email' => 'toth.vivien@student.com', 'class' => '9B', 'birth_date' => '2009-10-22'],
            ['name' => 'Horváth Dominik', 'email' => 'horvath.dominik@student.com', 'class' => '9B', 'birth_date' => '2009-06-04'],
            ['name' => 'Kiss Jázmin', 'email' => 'kiss.jazmin@student.com', 'class' => '9B', 'birth_date' => '2009-04-19'],
            ['name' => 'Varga Gergő', 'email' => 'varga.gergo@student.com', 'class' => '9B', 'birth_date' => '2009-11-13'],
            ['name' => 'Molnár Hanna', 'email' => 'molnar.hanna@student.com', 'class' => '9B', 'birth_date' => '2009-07-30'],
            ['name' => 'Kelemen Mátyás', 'email' => 'kelemen.matyas@student.com', 'class' => '9B', 'birth_date' => '2009-02-08'],
            ['name' => 'Oláh Rebeka', 'email' => 'olah.rebeka@student.com', 'class' => '9B', 'birth_date' => '2009-12-16'],

            // Class 10A (16 students)
            ['name' => 'Fekete Gergő', 'email' => 'fekete.gergo@student.com', 'class' => '10A', 'birth_date' => '2008-04-14'],
            ['name' => 'Juhász Sára', 'email' => 'juhasz.sara@student.com', 'class' => '10A', 'birth_date' => '2008-08-07'],
            ['name' => 'Lukács Tamás', 'email' => 'lukacs.tamas@student.com', 'class' => '10A', 'birth_date' => '2008-01-23'],
            ['name' => 'Balogh Kira', 'email' => 'balogh.kira@student.com', 'class' => '10A', 'birth_date' => '2008-09-15'],
            ['name' => 'Farkas Balázs', 'email' => 'farkas.balazs@student.com', 'class' => '10A', 'birth_date' => '2008-03-02'],
            ['name' => 'Lakatos Petra', 'email' => 'lakatos.petra@student.com', 'class' => '10A', 'birth_date' => '2008-11-28'],
            ['name' => 'Németh Áron', 'email' => 'nemeth.aaron@student.com', 'class' => '10A', 'birth_date' => '2008-06-10'],
            ['name' => 'Papp Csenge', 'email' => 'papp.csenge@student.com', 'class' => '10A', 'birth_date' => '2008-02-27'],
            ['name' => 'Rácz Olivér', 'email' => 'racz.oliver@student.com', 'class' => '10A', 'birth_date' => '2008-10-14'],
            ['name' => 'Szabó Luca', 'email' => 'szabo.luca@student.com', 'class' => '10A', 'birth_date' => '2008-05-31'],
            ['name' => 'Tóth Milán', 'email' => 'toth.milan@student.com', 'class' => '10A', 'birth_date' => '2008-12-08'],
            ['name' => 'Varga Noémi', 'email' => 'varga.noemi@student.com', 'class' => '10A', 'birth_date' => '2008-08-25'],
            ['name' => 'Molnár Zsombor', 'email' => 'molnar.zsombor@student.com', 'class' => '10A', 'birth_date' => '2008-04-12'],
            ['name' => 'Kelemen Júlia', 'email' => 'kelemen.julia@student.com', 'class' => '10A', 'birth_date' => '2008-01-19'],
            ['name' => 'Oláh Kristián', 'email' => 'olah.kristian@student.com', 'class' => '10A', 'birth_date' => '2008-09-06'],
            ['name' => 'Pintér Anita', 'email' => 'pinter.anita@student.com', 'class' => '10A', 'birth_date' => '2008-07-23'],

            // Class 10B (15 students)
            ['name' => 'Balogh Norbert', 'email' => 'balogh.norbert@student.com', 'class' => '10B', 'birth_date' => '2008-05-18'],
            ['name' => 'Fekete Orsolya', 'email' => 'fekete.orsolya@student.com', 'class' => '10B', 'birth_date' => '2008-12-04'],
            ['name' => 'Juhász Patrik', 'email' => 'juhasz.patrik@student.com', 'class' => '10B', 'birth_date' => '2008-03-21'],
            ['name' => 'Lukács Eszter', 'email' => 'lukacs.eszter@student.com', 'class' => '10B', 'birth_date' => '2008-10-09'],
            ['name' => 'Nagy Tibor', 'email' => 'nagy.tibor@student.com', 'class' => '10B', 'birth_date' => '2008-06-26'],
            ['name' => 'Papp Dia', 'email' => 'papp.dia@student.com', 'class' => '10B', 'birth_date' => '2008-02-13'],
            ['name' => 'Rácz Szabolcs', 'email' => 'racz.szabolcs@student.com', 'class' => '10B', 'birth_date' => '2008-11-30'],
            ['name' => 'Szabó Kiara', 'email' => 'szabo.kiara@student.com', 'class' => '10B', 'birth_date' => '2008-08-17'],
            ['name' => 'Tóth Zalán', 'email' => 'toth.zalan@student.com', 'class' => '10B', 'birth_date' => '2008-04-05'],
            ['name' => 'Varga Izabella', 'email' => 'varga.izabella@student.com', 'class' => '10B', 'birth_date' => '2008-01-22'],
            ['name' => 'Molnár Bálint', 'email' => 'molnar.balint@student.com', 'class' => '10B', 'birth_date' => '2008-09-08'],
            ['name' => 'Kelemen Lili', 'email' => 'kelemen.lili@student.com', 'class' => '10B', 'birth_date' => '2008-05-25'],
            ['name' => 'Oláh Márkusz', 'email' => 'olah.markusz@student.com', 'class' => '10B', 'birth_date' => '2008-12-12'],
            ['name' => 'Pintér Szonja', 'email' => 'pinter.szonja@student.com', 'class' => '10B', 'birth_date' => '2008-07-29'],
            ['name' => 'Szántó Botond', 'email' => 'szanto.botond@student.com', 'class' => '10B', 'birth_date' => '2008-03-16'],

            // Class 11A (13 students)
            ['name' => 'Kovács Adrienn', 'email' => 'kovacs.adrienn@student.com', 'class' => '11A', 'birth_date' => '2007-06-14'],
            ['name' => 'Nagy Kornél', 'email' => 'nagy.kornel@student.com', 'class' => '11A', 'birth_date' => '2007-02-28'],
            ['name' => 'Szabó Melinda', 'email' => 'szabo.melinda@student.com', 'class' => '11A', 'birth_date' => '2007-11-05'],
            ['name' => 'Tóth Viktor', 'email' => 'toth.viktor@student.com', 'class' => '11A', 'birth_date' => '2007-08-22'],
            ['name' => 'Horváth Katalin', 'email' => 'horvath.katalin@student.com', 'class' => '11A', 'birth_date' => '2007-04-09'],
            ['name' => 'Kiss Levente', 'email' => 'kiss.levente@student.com', 'class' => '11A', 'birth_date' => '2007-12-26'],
            ['name' => 'Varga Nikolett', 'email' => 'varga.nikolett@student.com', 'class' => '11A', 'birth_date' => '2007-09-13'],
            ['name' => 'Molnár Alex', 'email' => 'molnar.alex@student.com', 'class' => '11A', 'birth_date' => '2007-05-30'],
            ['name' => 'Kelemen Brigitta', 'email' => 'kelemen.brigitta@student.com', 'class' => '11A', 'birth_date' => '2007-01-17'],
            ['name' => 'Oláh Dániel', 'email' => 'olah.daniel@student.com', 'class' => '11A', 'birth_date' => '2007-10-04'],
            ['name' => 'Pintér Vivien', 'email' => 'pinter.vivien@student.com', 'class' => '11A', 'birth_date' => '2007-07-21'],
            ['name' => 'Balogh Nándor', 'email' => 'balogh.nandor@student.com', 'class' => '11A', 'birth_date' => '2007-03-08'],
            ['name' => 'Fekete Rózsa', 'email' => 'fekete.rozsa@student.com', 'class' => '11A', 'birth_date' => '2007-11-25'],

            // Class 12A (12 students)
            ['name' => 'Juhász Előd', 'email' => 'juhasz.elod@student.com', 'class' => '12A', 'birth_date' => '2006-04-15'],
            ['name' => 'Lukács Zsanett', 'email' => 'lukacs.zsanett@student.com', 'class' => '12A', 'birth_date' => '2006-12-02'],
            ['name' => 'Nagy Benedek', 'email' => 'nagy.benedek@student.com', 'class' => '12A', 'birth_date' => '2006-08-19'],
            ['name' => 'Papp Szilvia', 'email' => 'papp.szilvia@student.com', 'class' => '12A', 'birth_date' => '2006-05-06'],
            ['name' => 'Rácz Attila', 'email' => 'racz.attila@student.com', 'class' => '12A', 'birth_date' => '2006-01-23'],
            ['name' => 'Szabó Klaudia', 'email' => 'szabo.klaudia@student.com', 'class' => '12A', 'birth_date' => '2006-09-10'],
            ['name' => 'Tóth Gábor', 'email' => 'toth.gabor@student.com', 'class' => '12A', 'birth_date' => '2006-06-27'],
            ['name' => 'Varga Mónika', 'email' => 'varga.monika@student.com', 'class' => '12A', 'birth_date' => '2006-02-14'],
            ['name' => 'Molnár Krisztián', 'email' => 'molnar.krisztian@student.com', 'class' => '12A', 'birth_date' => '2006-11-01'],
            ['name' => 'Kelemen Éva', 'email' => 'kelemen.eva@student.com', 'class' => '12A', 'birth_date' => '2006-07-18'],
            ['name' => 'Oláh Márk', 'email' => 'olah.mark@student.com', 'class' => '12A', 'birth_date' => '2006-03-05'],
            ['name' => 'Pintér Lívia', 'email' => 'pinter.livia@student.com', 'class' => '12A', 'birth_date' => '2006-10-22'],
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
            // === CLASS 9A SCHEDULE ===
            // Monday (Hétfő)
            ['subject_id' => 1, 'teacher_id' => 1, 'room_id' => 1, 'weekday' => 'H', 'start_time' => '08:00', 'end_time' => '08:45', 'group' => '9A'],
            ['subject_id' => 2, 'teacher_id' => 2, 'room_id' => 5, 'weekday' => 'H', 'start_time' => '09:00', 'end_time' => '09:45', 'group' => '9A'],
            ['subject_id' => 3, 'teacher_id' => 3, 'room_id' => 6, 'weekday' => 'H', 'start_time' => '10:00', 'end_time' => '10:45', 'group' => '9A'],
            ['subject_id' => 7, 'teacher_id' => 7, 'room_id' => 3, 'weekday' => 'H', 'start_time' => '11:00', 'end_time' => '11:45', 'group' => '9A'],
            ['subject_id' => 8, 'teacher_id' => 8, 'room_id' => 7, 'weekday' => 'H', 'start_time' => '12:00', 'end_time' => '12:45', 'group' => '9A'],
            // Tuesday (Kedd)
            ['subject_id' => 4, 'teacher_id' => 4, 'room_id' => 5, 'weekday' => 'K', 'start_time' => '08:00', 'end_time' => '08:45', 'group' => '9A'],
            ['subject_id' => 5, 'teacher_id' => 5, 'room_id' => 2, 'weekday' => 'K', 'start_time' => '09:00', 'end_time' => '09:45', 'group' => '9A'],
            ['subject_id' => 6, 'teacher_id' => 6, 'room_id' => 8, 'weekday' => 'K', 'start_time' => '10:00', 'end_time' => '10:45', 'group' => '9A'],
            ['subject_id' => 9, 'teacher_id' => 9, 'room_id' => 2, 'weekday' => 'K', 'start_time' => '11:00', 'end_time' => '11:45', 'group' => '9A'],
            ['subject_id' => 10, 'teacher_id' => 10, 'room_id' => 4, 'weekday' => 'K', 'start_time' => '12:00', 'end_time' => '12:45', 'group' => '9A'],
            // Wednesday (Szerda)
            ['subject_id' => 1, 'teacher_id' => 1, 'room_id' => 1, 'weekday' => 'Sze', 'start_time' => '08:00', 'end_time' => '08:45', 'group' => '9A'],
            ['subject_id' => 11, 'teacher_id' => 11, 'room_id' => 4, 'weekday' => 'Sze', 'start_time' => '09:00', 'end_time' => '09:45', 'group' => '9A'],
            ['subject_id' => 12, 'teacher_id' => 12, 'room_id' => 3, 'weekday' => 'Sze', 'start_time' => '10:00', 'end_time' => '10:45', 'group' => '9A'],
            ['subject_id' => 13, 'teacher_id' => 13, 'room_id' => 3, 'weekday' => 'Sze', 'start_time' => '11:00', 'end_time' => '11:45', 'group' => '9A'],

            // === CLASS 9B SCHEDULE ===
            // Monday (Hétfő)
            ['subject_id' => 1, 'teacher_id' => 1, 'room_id' => 1, 'weekday' => 'H', 'start_time' => '13:00', 'end_time' => '13:45', 'group' => '9B'],
            ['subject_id' => 2, 'teacher_id' => 2, 'room_id' => 5, 'weekday' => 'H', 'start_time' => '14:00', 'end_time' => '14:45', 'group' => '9B'],
            ['subject_id' => 3, 'teacher_id' => 3, 'room_id' => 6, 'weekday' => 'H', 'start_time' => '15:00', 'end_time' => '15:45', 'group' => '9B'],
            ['subject_id' => 7, 'teacher_id' => 7, 'room_id' => 3, 'weekday' => 'H', 'start_time' => '16:00', 'end_time' => '16:45', 'group' => '9B'],
            // Tuesday (Kedd)
            ['subject_id' => 4, 'teacher_id' => 4, 'room_id' => 5, 'weekday' => 'K', 'start_time' => '13:00', 'end_time' => '13:45', 'group' => '9B'],
            ['subject_id' => 5, 'teacher_id' => 5, 'room_id' => 2, 'weekday' => 'K', 'start_time' => '14:00', 'end_time' => '14:45', 'group' => '9B'],
            ['subject_id' => 6, 'teacher_id' => 6, 'room_id' => 8, 'weekday' => 'K', 'start_time' => '15:00', 'end_time' => '15:45', 'group' => '9B'],
            ['subject_id' => 8, 'teacher_id' => 8, 'room_id' => 7, 'weekday' => 'K', 'start_time' => '16:00', 'end_time' => '16:45', 'group' => '9B'],
            // Wednesday (Szerda)
            ['subject_id' => 9, 'teacher_id' => 9, 'room_id' => 2, 'weekday' => 'Sze', 'start_time' => '13:00', 'end_time' => '13:45', 'group' => '9B'],
            ['subject_id' => 10, 'teacher_id' => 10, 'room_id' => 4, 'weekday' => 'Sze', 'start_time' => '14:00', 'end_time' => '14:45', 'group' => '9B'],
            ['subject_id' => 11, 'teacher_id' => 11, 'room_id' => 4, 'weekday' => 'Sze', 'start_time' => '15:00', 'end_time' => '15:45', 'group' => '9B'],
            ['subject_id' => 12, 'teacher_id' => 12, 'room_id' => 3, 'weekday' => 'Sze', 'start_time' => '16:00', 'end_time' => '16:45', 'group' => '9B'],

            // === CLASS 10A SCHEDULE ===
            // Monday (Hétfő)
            ['subject_id' => 1, 'teacher_id' => 1, 'room_id' => 2, 'weekday' => 'H', 'start_time' => '08:00', 'end_time' => '08:45', 'group' => '10A'],
            ['subject_id' => 2, 'teacher_id' => 2, 'room_id' => 6, 'weekday' => 'H', 'start_time' => '09:00', 'end_time' => '09:45', 'group' => '10A'],
            ['subject_id' => 3, 'teacher_id' => 3, 'room_id' => 5, 'weekday' => 'H', 'start_time' => '10:00', 'end_time' => '10:45', 'group' => '10A'],
            ['subject_id' => 4, 'teacher_id' => 4, 'room_id' => 6, 'weekday' => 'H', 'start_time' => '11:00', 'end_time' => '11:45', 'group' => '10A'],
            ['subject_id' => 5, 'teacher_id' => 5, 'room_id' => 3, 'weekday' => 'H', 'start_time' => '12:00', 'end_time' => '12:45', 'group' => '10A'],
            // Tuesday (Kedd)
            ['subject_id' => 6, 'teacher_id' => 6, 'room_id' => 8, 'weekday' => 'K', 'start_time' => '08:00', 'end_time' => '08:45', 'group' => '10A'],
            ['subject_id' => 7, 'teacher_id' => 7, 'room_id' => 2, 'weekday' => 'K', 'start_time' => '09:00', 'end_time' => '09:45', 'group' => '10A'],
            ['subject_id' => 8, 'teacher_id' => 8, 'room_id' => 7, 'weekday' => 'K', 'start_time' => '10:00', 'end_time' => '10:45', 'group' => '10A'],
            ['subject_id' => 9, 'teacher_id' => 9, 'room_id' => 3, 'weekday' => 'K', 'start_time' => '11:00', 'end_time' => '11:45', 'group' => '10A'],
            ['subject_id' => 10, 'teacher_id' => 10, 'room_id' => 4, 'weekday' => 'K', 'start_time' => '12:00', 'end_time' => '12:45', 'group' => '10A'],
            // Wednesday (Szerda)
            ['subject_id' => 11, 'teacher_id' => 11, 'room_id' => 4, 'weekday' => 'Sze', 'start_time' => '08:00', 'end_time' => '08:45', 'group' => '10A'],
            ['subject_id' => 12, 'teacher_id' => 12, 'room_id' => 1, 'weekday' => 'Sze', 'start_time' => '09:00', 'end_time' => '09:45', 'group' => '10A'],
            ['subject_id' => 14, 'teacher_id' => 14, 'room_id' => 3, 'weekday' => 'Sze', 'start_time' => '10:00', 'end_time' => '10:45', 'group' => '10A'],
            ['subject_id' => 15, 'teacher_id' => 15, 'room_id' => 2, 'weekday' => 'Sze', 'start_time' => '11:00', 'end_time' => '11:45', 'group' => '10A'],

            // === CLASS 10B SCHEDULE ===
            // Monday (Hétfő)
            ['subject_id' => 1, 'teacher_id' => 1, 'room_id' => 4, 'weekday' => 'H', 'start_time' => '13:00', 'end_time' => '13:45', 'group' => '10B'],
            ['subject_id' => 2, 'teacher_id' => 2, 'room_id' => 5, 'weekday' => 'H', 'start_time' => '14:00', 'end_time' => '14:45', 'group' => '10B'],
            ['subject_id' => 3, 'teacher_id' => 3, 'room_id' => 6, 'weekday' => 'H', 'start_time' => '15:00', 'end_time' => '15:45', 'group' => '10B'],
            ['subject_id' => 4, 'teacher_id' => 4, 'room_id' => 5, 'weekday' => 'H', 'start_time' => '16:00', 'end_time' => '16:45', 'group' => '10B'],
            // Tuesday (Kedd)
            ['subject_id' => 5, 'teacher_id' => 5, 'room_id' => 4, 'weekday' => 'K', 'start_time' => '13:00', 'end_time' => '13:45', 'group' => '10B'],
            ['subject_id' => 6, 'teacher_id' => 6, 'room_id' => 8, 'weekday' => 'K', 'start_time' => '14:00', 'end_time' => '14:45', 'group' => '10B'],
            ['subject_id' => 7, 'teacher_id' => 7, 'room_id' => 2, 'weekday' => 'K', 'start_time' => '15:00', 'end_time' => '15:45', 'group' => '10B'],
            ['subject_id' => 8, 'teacher_id' => 8, 'room_id' => 7, 'weekday' => 'K', 'start_time' => '16:00', 'end_time' => '16:45', 'group' => '10B'],
            // Wednesday (Szerda)
            ['subject_id' => 9, 'teacher_id' => 9, 'room_id' => 3, 'weekday' => 'Sze', 'start_time' => '13:00', 'end_time' => '13:45', 'group' => '10B'],
            ['subject_id' => 12, 'teacher_id' => 12, 'room_id' => 1, 'weekday' => 'Sze', 'start_time' => '14:00', 'end_time' => '14:45', 'group' => '10B'],
            ['subject_id' => 13, 'teacher_id' => 13, 'room_id' => 3, 'weekday' => 'Sze', 'start_time' => '15:00', 'end_time' => '15:45', 'group' => '10B'],
            ['subject_id' => 16, 'teacher_id' => 16, 'room_id' => 2, 'weekday' => 'Sze', 'start_time' => '16:00', 'end_time' => '16:45', 'group' => '10B'],

            // === CLASS 11A SCHEDULE ===
            // Monday (Hétfő)
            ['subject_id' => 1, 'teacher_id' => 1, 'room_id' => 1, 'weekday' => 'H', 'start_time' => '08:00', 'end_time' => '08:45', 'group' => '11A'],
            ['subject_id' => 2, 'teacher_id' => 2, 'room_id' => 5, 'weekday' => 'H', 'start_time' => '09:00', 'end_time' => '09:45', 'group' => '11A'],
            ['subject_id' => 3, 'teacher_id' => 3, 'room_id' => 6, 'weekday' => 'H', 'start_time' => '10:00', 'end_time' => '10:45', 'group' => '11A'],
            ['subject_id' => 4, 'teacher_id' => 4, 'room_id' => 5, 'weekday' => 'H', 'start_time' => '11:00', 'end_time' => '11:45', 'group' => '11A'],
            ['subject_id' => 5, 'teacher_id' => 5, 'room_id' => 2, 'weekday' => 'H', 'start_time' => '12:00', 'end_time' => '12:45', 'group' => '11A'],
            // Tuesday (Kedd)
            ['subject_id' => 6, 'teacher_id' => 6, 'room_id' => 8, 'weekday' => 'K', 'start_time' => '08:00', 'end_time' => '08:45', 'group' => '11A'],
            ['subject_id' => 7, 'teacher_id' => 7, 'room_id' => 3, 'weekday' => 'K', 'start_time' => '09:00', 'end_time' => '09:45', 'group' => '11A'],
            ['subject_id' => 12, 'teacher_id' => 12, 'room_id' => 1, 'weekday' => 'K', 'start_time' => '10:00', 'end_time' => '10:45', 'group' => '11A'],
            ['subject_id' => 13, 'teacher_id' => 13, 'room_id' => 3, 'weekday' => 'K', 'start_time' => '11:00', 'end_time' => '11:45', 'group' => '11A'],
            ['subject_id' => 14, 'teacher_id' => 14, 'room_id' => 3, 'weekday' => 'K', 'start_time' => '12:00', 'end_time' => '12:45', 'group' => '11A'],
            // Wednesday (Szerda)
            ['subject_id' => 15, 'teacher_id' => 15, 'room_id' => 2, 'weekday' => 'Sze', 'start_time' => '08:00', 'end_time' => '08:45', 'group' => '11A'],
            ['subject_id' => 16, 'teacher_id' => 16, 'room_id' => 2, 'weekday' => 'Sze', 'start_time' => '09:00', 'end_time' => '09:45', 'group' => '11A'],
            ['subject_id' => 8, 'teacher_id' => 8, 'room_id' => 7, 'weekday' => 'Sze', 'start_time' => '10:00', 'end_time' => '10:45', 'group' => '11A'],
            ['subject_id' => 9, 'teacher_id' => 9, 'room_id' => 4, 'weekday' => 'Sze', 'start_time' => '11:00', 'end_time' => '11:45', 'group' => '11A'],

            // === CLASS 12A SCHEDULE ===
            // Monday (Hétfő)
            ['subject_id' => 1, 'teacher_id' => 1, 'room_id' => 2, 'weekday' => 'H', 'start_time' => '08:00', 'end_time' => '08:45', 'group' => '12A'],
            ['subject_id' => 2, 'teacher_id' => 2, 'room_id' => 6, 'weekday' => 'H', 'start_time' => '09:00', 'end_time' => '09:45', 'group' => '12A'],
            ['subject_id' => 3, 'teacher_id' => 3, 'room_id' => 5, 'weekday' => 'H', 'start_time' => '10:00', 'end_time' => '10:45', 'group' => '12A'],
            ['subject_id' => 4, 'teacher_id' => 4, 'room_id' => 6, 'weekday' => 'H', 'start_time' => '11:00', 'end_time' => '11:45', 'group' => '12A'],
            ['subject_id' => 5, 'teacher_id' => 5, 'room_id' => 3, 'weekday' => 'H', 'start_time' => '12:00', 'end_time' => '12:45', 'group' => '12A'],
            // Tuesday (Kedd)
            ['subject_id' => 6, 'teacher_id' => 6, 'room_id' => 8, 'weekday' => 'K', 'start_time' => '08:00', 'end_time' => '08:45', 'group' => '12A'],
            ['subject_id' => 7, 'teacher_id' => 7, 'room_id' => 2, 'weekday' => 'K', 'start_time' => '09:00', 'end_time' => '09:45', 'group' => '12A'],
            ['subject_id' => 12, 'teacher_id' => 12, 'room_id' => 1, 'weekday' => 'K', 'start_time' => '10:00', 'end_time' => '10:45', 'group' => '12A'],
            ['subject_id' => 15, 'teacher_id' => 15, 'room_id' => 2, 'weekday' => 'K', 'start_time' => '11:00', 'end_time' => '11:45', 'group' => '12A'],
            ['subject_id' => 16, 'teacher_id' => 16, 'room_id' => 2, 'weekday' => 'K', 'start_time' => '12:00', 'end_time' => '12:45', 'group' => '12A'],
            // Wednesday (Szerda)
            ['subject_id' => 13, 'teacher_id' => 13, 'room_id' => 3, 'weekday' => 'Sze', 'start_time' => '08:00', 'end_time' => '08:45', 'group' => '12A'],
            ['subject_id' => 14, 'teacher_id' => 14, 'room_id' => 3, 'weekday' => 'Sze', 'start_time' => '09:00', 'end_time' => '09:45', 'group' => '12A'],
            ['subject_id' => 8, 'teacher_id' => 8, 'room_id' => 7, 'weekday' => 'Sze', 'start_time' => '10:00', 'end_time' => '10:45', 'group' => '12A'],
            ['subject_id' => 9, 'teacher_id' => 9, 'room_id' => 4, 'weekday' => 'Sze', 'start_time' => '11:00', 'end_time' => '11:45', 'group' => '12A'],
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
        $gradeValues = [5, 4, 4, 3, 5, 2, 4, 3, 5, 4, 3, 5, 2, 4, 3, 5, 4, 2, 5, 3];
        $gradeDescriptions = [
            'Excellent performance on test',
            'Good understanding of concepts',
            'Needs improvement in some areas',
            'Great participation in class',
            'Outstanding homework completion',
            'Struggled with advanced topics',
            'Solid grasp of fundamentals',
            'Creative approach to problems',
            'Consistent effort throughout term',
            'Exceptional analytical skills'
        ];

        $gradeIndex = 0;
        $subjectIds = Subject::pluck('id')->toArray();

        foreach ($students as $studentIndex => $student) {
            // Create grades for each student across multiple subjects
            $numSubjects = min(count($subjectIds), rand(6, 10)); // 6-10 subjects per student
            $studentSubjects = array_slice($subjectIds, 0, $numSubjects);

            foreach ($studentSubjects as $subjectId) {
                // Create 2-4 grades per subject per student
                $numGrades = rand(2, 4);
                for ($i = 0; $i < $numGrades; $i++) {
                    $teacherId = $subjectId <= 16 ? $subjectId : rand(1, 16); // Match teacher to subject where possible

                    Grade::create([
                        'student_id' => $student->id,
                        'subject_id' => $subjectId,
                        'teacher_id' => $teacherId,
                        'grade' => $gradeValues[$gradeIndex % count($gradeValues)],
                        'description' => $gradeDescriptions[$gradeIndex % count($gradeDescriptions)],
                        'graded_at' => now()->subDays(rand(1, 90)),
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
            'Literature discussion was very productive today.',
            'Students are improving their English conversation skills.',
            'Great energy during today\'s PE session.',
            'Geography mapping activity was a success.',
            'Creative artwork produced by students this week.',
            'Music theory concepts are being grasped well.',
            'Computer programming basics covered effectively.',
            'French pronunciation practice went smoothly.',
            'German vocabulary building session was productive.',
            'Philosophy debate sparked great student interest.',
            'Economics principles clearly explained and understood.',
            'Advanced mathematics concepts introduced successfully.',
            'Physics lab safety protocols reviewed.',
            'Chemistry compound identification exercise completed.',
            'Biology dissection lab conducted with enthusiasm.',
        ];

        // Create notes for multiple teachers and subjects
        $scheduleIds = Schedule::pluck('id')->toArray();
        $noteIndex = 0;

        foreach (range(1, min(16, count($scheduleIds))) as $i) {
            if ($noteIndex < count($noteTexts)) {
                Note::create([
                    'teacher_id' => $i,
                    'subject_id' => $i,
                    'schedule_id' => $scheduleIds[$i - 1] ?? 1,
                    'note_text' => $noteTexts[$noteIndex],
                    'is_active' => true,
                ]);
                $noteIndex++;
            }
        }

        // Add some additional random notes
        for ($i = 0; $i < 10; $i++) {
            Note::create([
                'teacher_id' => rand(1, 16),
                'subject_id' => rand(1, 16),
                'schedule_id' => $scheduleIds[rand(0, count($scheduleIds) - 1)],
                'note_text' => $noteTexts[rand(0, count($noteTexts) - 1)],
                'is_active' => true,
            ]);
        }

        $this->command->info('Database seeded successfully with comprehensive test data!');
        $this->command->info('');
        $this->command->info('📊 SEEDING SUMMARY:');
        $this->command->info('==================');
        $this->command->info('👥 Users Created: ' . User::count());
        $this->command->info('👨‍🎓 Students: ' . Student::count());
        $this->command->info('👨‍🏫 Teachers: ' . Teacher::count());
        $this->command->info('📚 Subjects: ' . Subject::count());
        $this->command->info('📝 Grades: ' . Grade::count());
        $this->command->info('🏫 Rooms: ' . Room::count());
        $this->command->info('📅 Schedules: ' . Schedule::count());
        $this->command->info('📋 Enrollments: ' . Enrollment::count());
        $this->command->info('📝 Notes: ' . Note::count());
        $this->command->info('');
        $this->command->info('🏫 CLASSES CREATED:');
        $this->command->info('=================');
        $this->command->info('9A: 15 students (Morning Schedule)');
        $this->command->info('9B: 14 students (Afternoon Schedule)');
        $this->command->info('10A: 16 students (Morning Schedule)');
        $this->command->info('10B: 15 students (Afternoon Schedule)');
        $this->command->info('11A: 13 students (Morning Schedule)');
        $this->command->info('12A: 12 students (Morning Schedule)');
        $this->command->info('');
        $this->command->info('� SCHEDULE COVERAGE:');
        $this->command->info('=====================');
        $this->command->info('✅ Monday (Hétfő): All classes scheduled');
        $this->command->info('✅ Tuesday (Kedd): All classes scheduled');
        $this->command->info('✅ Wednesday (Szerda): All classes scheduled');
        $this->command->info('📚 16 Subjects across all grade levels');
        $this->command->info('🏫 16 Rooms including specialized labs');
        $this->command->info('');
        $this->command->info('�🔑 LOGIN INFORMATION:');
        $this->command->info('====================');
        $this->command->info('All users have password: password');
        $this->command->info('');
        $this->command->info('👑 Owner: System Owner (owner@school.com)');
        $this->command->info('⚙️ Admin: Schedule Administrator (admin@school.com)');
        $this->command->info('👨‍🏫 Sample Teachers: Dr. Kovács János, Nagy Éva, Szabó Péter, etc.');
        $this->command->info('👨‍🎓 Sample Students: Balázs Péter, Farkas Eszter, Lakatos Dávid, etc.');
        $this->command->info('');
        $this->command->info('📧 Note: Email addresses are stored in the contacts table.');
        $this->command->info('🎯 Ready to explore class analytics with comprehensive data!');
        $this->command->info('📊 Complete schedule system with realistic timetables!');
    }
}

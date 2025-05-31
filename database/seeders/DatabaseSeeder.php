<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\AdminAddress;
use App\Models\AdminProfile;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Guardian;
use App\Models\GuardianUser;
use App\Models\Lesson;
use App\Models\Store;
use App\Models\StoreStudent;
use App\Models\Student;
use App\Models\StudentUser;
use App\Models\User;
use App\Models\UserAddress;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        $this->call(AdminProfileSeeder::class);
        $this->call(AdminAddressSeeder::class);
        $this->call(MembershipOptionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UserAddressSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(StudentUserSeeder::class);
        $this->call(GuardianSeeder::class);
        $this->call(GuardianUserSeeder::class);
        $this->call(OrganizationSeeder::class);
        $this->call(StoreSeeder::class);
        $this->call(StoreScheduleSeeder::class);
        $this->call(StoreStudentSeeder::class);
        $this->call(LessonSeeder::class);
        $this->call(CourseCategorySeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(QuestionnaireSeeder::class);

        // Factory
        Admin::factory(20)->create();
        AdminProfile::factory(20)->create();
        AdminAddress::factory(20)->create();
        User::factory(300)->create();
        UserAddress::factory(310)->create();
        Student::factory(320)->create();
        StudentUser::factory(320)->create();
        Guardian::factory(330)->create();
        GuardianUser::factory(330)->create();
        StoreStudent::factory(320)->create();
    }
}

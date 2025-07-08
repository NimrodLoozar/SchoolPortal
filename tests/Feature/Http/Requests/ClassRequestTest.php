<?php

namespace Tests\Feature\Http\Requests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Requests\ClassIndexRequest;
use App\Http\Requests\ClassShowRequest;
use App\Http\Requests\ClassStudentRequest;
use App\Models\User;
use App\Models\Student;

class ClassRequestTest extends TestCase
{
    use RefreshDatabase;

    protected User $owner;
    protected Student $student;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user with Owner role
        $this->owner = User::factory()->create(['role' => 'Owner']);

        // Create a student for testing
        $this->student = Student::factory()->create([
            'class' => 'Test Class',
            'is_active' => true
        ]);
    }

    /** @test */
    public function class_index_request_authorizes_owner()
    {
        $request = new ClassIndexRequest();

        $this->actingAs($this->owner);

        $this->assertTrue($request->authorize());
    }

    /** @test */
    public function class_index_request_validates_sort_parameters()
    {
        $request = new ClassIndexRequest();

        $rules = $request->rules();

        $this->assertArrayHasKey('sort_by', $rules);
        $this->assertArrayHasKey('sort_direction', $rules);
        $this->assertArrayHasKey('filter_performance', $rules);
    }

    /** @test */
    public function class_show_request_authorizes_owner()
    {
        $request = new ClassShowRequest();

        $this->actingAs($this->owner);

        $this->assertTrue($request->authorize());
    }

    /** @test */
    public function class_show_request_validates_class_parameter()
    {
        $request = new ClassShowRequest();

        $rules = $request->rules();

        $this->assertArrayHasKey('class', $rules);
        $this->assertStringContainsString('required', $rules['class']);
        $this->assertStringContainsString('exists:students,class', $rules['class']);
    }

    /** @test */
    public function class_student_request_authorizes_owner()
    {
        $request = new ClassStudentRequest();

        $this->actingAs($this->owner);

        $this->assertTrue($request->authorize());
    }

    /** @test */
    public function class_student_request_validates_parameters()
    {
        $request = new ClassStudentRequest();

        $rules = $request->rules();

        $this->assertArrayHasKey('class', $rules);
        $this->assertArrayHasKey('student', $rules);
        $this->assertStringContainsString('required', $rules['class']);
        $this->assertStringContainsString('exists:students,class', $rules['class']);
        $this->assertStringContainsString('required', $rules['student']);
        $this->assertStringContainsString('exists:students,id', $rules['student']);
    }

    /** @test */
    public function class_student_request_has_helper_methods()
    {
        $request = new ClassStudentRequest();

        $this->assertTrue(method_exists($request, 'getClassName'));
        $this->assertTrue(method_exists($request, 'getStudentId'));
    }
}

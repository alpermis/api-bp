<?php

namespace Tests\Feature;

use Tests\TestCase;

class StudentTest extends TestCase
{
    /**
     * Test getting student information.
     */
    public function test_get_student_success(): void
    {
        $response = $this->getJson('/v1/student', [
            'X-Authenticated-UserId' => '12345'
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test setting student information with new parameters.
     */
    public function test_set_student_success(): void
    {
        $response = $this->postJson('/v1/student/name', [
            'name' => 'John',
            'lastname' => 'Doe'
        ], [
            'X-Authenticated-UserId' => '12345'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'status' => 'OK',
                    'name' => 'John',
                    'lastname' => 'Doe'
                ]
            ]);
    }

    /**
     * Test validation failure for missing name.
     */
    public function test_set_student_validation_fails_missing_name(): void
    {
        $response = $this->postJson('/v1/student/name', [
            'lastname' => 'Doe'
        ], [
            'X-Authenticated-UserId' => '12345'
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
            ]);
    }

    /**
     * Test validation failure for missing lastname.
     */
    public function test_set_student_validation_fails_missing_lastname(): void
    {
        $response = $this->postJson('/v1/student/name', [
            'name' => 'John'
        ], [
            'X-Authenticated-UserId' => '12345'
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
            ]);
    }
}

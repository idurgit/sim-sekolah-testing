<?php

namespace App\Actions;

use App\Models\Enrollment;
use App\Models\Student;

class EnrollStudent
{
    /**
     * Handle the enrollment of a student into a classroom.
     *
     * @param Student $student The student to enroll
     * @param int $classroomId The classroom ID to enroll into
     * @return Enrollment The created enrollment
     */
    public function handle(Student $student, int $classroomId): Enrollment
    {
        // Create and return the enrollment
        return Enrollment::create([
            'student_id' => $student->id,
            'classroom_id' => $classroomId,
        ]);
    }

    /**
     * Check if a student is already enrolled in a classroom.
     *
     * @param int $studentId
     * @param int $classroomId
     * @return bool
     */
    public function isAlreadyEnrolled(int $studentId, int $classroomId): bool
    {
        return Enrollment::where('student_id', $studentId)
            ->where('classroom_id', $classroomId)
            ->exists();
    }
}

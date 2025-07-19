<?php
namespace App\Domain\Enrollment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domain\Course\Models\Course;
use App\Domain\Student\Models\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Database\Factories\EnrollmentFactory::new();
    }

    protected $table = 'enrollments';

    // Desactivamos timestamps automáticos porque usamos solo enrolled_at
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'course_id',
        'enrolled_at',
    ];

    protected $dates = [
        'enrolled_at',
    ];

    /**
     * Relación con Curso
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Relación con Estudiante
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}

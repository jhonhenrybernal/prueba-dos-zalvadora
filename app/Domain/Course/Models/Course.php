<?php
namespace App\Domain\Course\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory; 
    protected $table = 'courses';
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
    ];

    protected static function newFactory() 
    {
        return \Database\Factories\CourseFactory::new();
    }
    /**
     * Relación con estudiantes (many-to-many)
     */
    public function students()
    {
        return $this->belongsToMany(
            \App\Domain\Student\Models\Student::class,
            'enrollments'
        )->withPivot('enrolled_at');
    }

    /**
     * Scope para traer cursos con estudiantes cargados
     */
    public function scopeWithStudents(Builder $query): Builder
    {
        return $query->with('students');
    }
}


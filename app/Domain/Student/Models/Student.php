<?php
namespace App\Domain\Student\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
    ];


    // Si tu factory está en database/factories/StudentFactory.php
    protected static function newFactory()
    {
        return \Database\Factories\StudentFactory::new();
    }

    /**
     * Relación muchos a muchos con cursos
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(
            \App\Domain\Course\Models\Course::class,
            'enrollments'
        )->withPivot('enrolled_at');
    }

    /**
     * Scope para cargar cursos relacionados
     */
    public function scopeWithCourses($query)
    {
        return $query->with('courses');
    }
}

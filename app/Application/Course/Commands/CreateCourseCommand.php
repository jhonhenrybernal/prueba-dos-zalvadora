<?php

namespace App\Application\Course\Commands;

class CreateCourseCommand
{
    private string $title;
    private ?string $description;
    private string $startDate;
    private string $endDate;

    public function __construct(array $data)
    {
        $this->title = $data['title'];
        $this->description = $data['description'] ?? null;
        $this->startDate = $data['start_date'];
        $this->endDate = $data['end_date'];
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function startDate(): string
    {
        return $this->startDate;
    }

    public function endDate(): string
    {
        return $this->endDate;
    }
}

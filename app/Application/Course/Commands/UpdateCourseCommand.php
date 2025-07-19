<?php

namespace App\Application\Course\Commands;

class UpdateCourseCommand
{
    private int $id;
    private string $title;
    private ?string $description;
    private string $startDate;
    private string $endDate;

    public function __construct(int $id, array $data)
    {
        $this->id = $id;
        $this->title = $data['title'];
        $this->description = $data['description'] ?? null;
        $this->startDate = $data['start_date'];
        $this->endDate = $data['end_date'];
    }

    public function id(): int
    {
        return $this->id;
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
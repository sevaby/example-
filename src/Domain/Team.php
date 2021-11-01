<?php declare(strict_types=1);

namespace App\Domain;

class Team
{
    private string $id;
    private string $title;

    public function __construct(string $title)
    {
        $this->id = uniqid();
        $this->title = $title;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function isEqual(Team $team): bool
    {
        return $this->id === $team->id;
    }

    public function title(): string
    {
        return $this->title;
    }
}
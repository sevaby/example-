<?php declare(strict_types=1);

namespace App\Tests;

use App\Domain\Division\Division;
use App\Domain\Team;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\Assert;

class DivisionTest extends TestCase
{
    private Division $division;

    protected function setUp(): void
    {
        $teamA = new Team('FC Lida');
        $teamB = new Team('Barsa');
        $teamC = new Team('Real');
        $teamD = new Team('Zenit');

        $division = new Division('Division A');
        $division->addTeams($teamA, $teamB, $teamC, $teamD);
        $this->division = $division;
    }

    public function testScheduledGames(): void
    {
        $division = $this->division;

        $this->assertCount(6, $division->allGames());
        $this->assertCount(4, $division->teams());

        $this->assertCount(3, $division->teamGames($this->team(0)));
        $this->assertCount(3, $division->teamGames($this->team(1)));
        $this->assertCount(3, $division->teamGames($this->team(2)));
        $this->assertCount(3, $division->teamGames($this->team(3)));
    }


    public function testFindGameForTeams(): void
    {
        $game = $this->division->findGameForTeams($this->team(0), $this->team(1));
        $this->assertNotNull($game);

        $game = $this->division->findGameForTeams($this->team(0), $this->team(0));
        $this->assertNull($game);
    }



    private function team(int $index): Team {
        return $this->division->teams()[$index];
    }
}
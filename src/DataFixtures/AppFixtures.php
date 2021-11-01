<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Division;
use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    const TEAMS_DIV_A = [
        'Manchester United',
        'Liverpool',
        'Arsenal',
        'Chelsea',
        'Manchester City',
        'Tottenham Hotspur',
        'Aston Villa',
        'Everton'
        ];


    const TEAMS_DIV_B = [
        'Newcastle United',
        'Nottingham Forest',
        'Wolverhampton Wanderers',
        'Blackburn Rovers',
        'Sunderland',
        'Sheffield Wednesday',
        'Leeds United',
        'West Bromwich Albion'
    ];

    public function load(ObjectManager $manager)
    {
        $divisionA = new Division('Division A');
        $manager->persist($divisionA);

        foreach (self::TEAMS_DIV_A as $teamName) {
            $team = new Team($teamName, $divisionA);
            $manager->persist($team);
        }

        $manager->flush();



        $divisionB = new Division('Division B');
        $manager->persist($divisionB);

        foreach (self::TEAMS_DIV_B as $teamName) {
            $team = new Team($teamName, $divisionB);
            $manager->persist($team);
        }

        $manager->flush();
    }
}

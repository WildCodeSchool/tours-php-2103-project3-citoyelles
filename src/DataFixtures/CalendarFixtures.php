<?php

namespace App\DataFixtures;

use App\Entity\Calendar;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class CalendarFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $event = new Calendar();
        $event->setTitle('Inauguration officielle');
        $event->setDate(new DateTime('2022-09-09 18:00'));
        $event->setContent('18h00 - 19h30');
        $event->setType('festivelles');
        $manager->persist($event);

        $event = new Calendar();
        $event->setTitle('Soirée théatre : "Les monologues du vagin" ');
        $event->setDate(new DateTime('2022-09-09 21:00'));
        $event->setContent('21h');
        $event->setType('festivelles');
        $manager->persist($event);

        $event = new Calendar();
        $event->setTitle('Accueil et installation des autrices');
        $event->setDate(new DateTime('2022-09-10 08:00'));
        $event->setContent('8h00 - 9h30');
        $event->setType('festivelles');
        $manager->persist($event);

        $event = new Calendar();
        $event->setTitle('Ouverture au public');
        $event->setDate(new DateTime('2022-09-10 10:00'));
        $event->setContent('10h - 19h');
        $event->setType('festivelles');
        $manager->persist($event);

        $event = new Calendar();
        $event->setTitle('Soirée théatre : "Les monologues du vagin');
        $event->setDate(new DateTime('2022-09-10 21:00'));
        $event->setContent('21h');
        $event->setType('festivelles');
        $manager->persist($event);

        $event = new Calendar();
        $event->setTitle('Ouverture au public et clôture du Festiv\'Elles');
        $event->setDate(new DateTime('2022-09-11 10:00'));
        $event->setContent('10h - 18h');
        $event->setType('festivelles');
        $manager->persist($event);

        $event = new Calendar();
        $event->setTitle('Compagnie Cano Lopez, spectacle "Les Tour\'Ang\'Elles"');
        $event->setDate(new DateTime('2022-09-11 16:00'));
        $event->setContent('16h - 18h');
        $event->setType('festivelles');
        $manager->persist($event);

        $manager->flush();
    }
}

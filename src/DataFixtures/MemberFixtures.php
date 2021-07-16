<?php

namespace App\DataFixtures;

use App\Entity\Member;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MemberFixtures extends Fixture
{
    private const MEMBERS = [
        ["Dominique Nouet", "Direction Générale", null, "0659941990", "citoyelles@hotmail.fr"],
        ["Caroline Deforge", "Direction Générale", null, null, null],
        ["Michel Nemesien", "Direction Générale", null, null, null],
        ["Michel Nemesien", "Comptabilité", "Budget", null, null],
        ["Dominique Nouet", "Relation presse médias", null, "0659941990", "citoyelles@hotmail.fr"],
        ["Caroline Deforge", "Relation partenaires", null, null, null],
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::MEMBERS as $memberRow) {
            $member = new Member();
            $member->setName($memberRow[0]);
            $member->setTitle($memberRow[1]);
            $member->setMission($memberRow[2]);
            $member->setPhoneNumber($memberRow[3]);
            $member->setEmail($memberRow[4]);
            $manager->persist($member);
        }
        $manager->flush();
    }
}

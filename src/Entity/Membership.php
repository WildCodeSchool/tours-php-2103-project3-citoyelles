<?php

namespace App\Entity;

use App\Repository\MembershipRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=MembershipRepository::class)
 * @UniqueEntity("year")
 */
class Membership
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="date")
     */
    private \DateTimeInterface $year;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $pdfFilename;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?\DateTimeInterface
    {
        return $this->year;
    }

    public function setYear(\DateTimeInterface $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getPdfFilename(): ?string
    {
        return $this->pdfFilename;
    }

    public function setPdfFilename(string $pdfFilename): self
    {
        $this->pdfFilename = $pdfFilename;

        return $this;
    }
}

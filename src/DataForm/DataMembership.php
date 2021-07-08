<?php

namespace App\DataForm;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class DataMembership
{
    /**
     * @Assert\NotBlank
     * @Assert\File(
     * maxSize = "512k",
     * mimeTypes = {"application/pdf", "application/x-pdf"},
     * mimeTypesMessage = "Veuillez déposer un fichier PDF valide."
     * )
     */
    private UploadedFile $membershipFile;

    public function getMembershipFile(): ?UploadedFile
    {
        return $this->membershipFile;
    }

    public function setMembershipFile(UploadedFile $membershipFile): self
    {
        $this->membershipFile = $membershipFile;
        return $this;
    }
}

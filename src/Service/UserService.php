<?php

namespace App\Service;

class UserService
{
    private ?string $oldUsername;
    private ?string $newUsername;
    private ?string $oldPassword;
    private ?string $newPassword;

    /** getters **/
    public function getOldUsername(): ?string
    {
        return $this->oldUsername;
    }

    public function getNewUsername(): ?string
    {
        return $this->newUsername;
    }

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }


    /** Setters **/
    public function setOldUsername(?string $oldUsername): self
    {
        $this->oldUsername = $oldUsername;
        return $this;
    }

    public function setNewUsername(?string $newUsername): self
    {
        $this->newUsername = $newUsername;
        return $this;
    }

    public function setOldPassword(?string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;
        return $this;
    }

    public function setNewPassword(?string $newPassword): self
    {
        $this->newPassword = $newPassword;
        return $this;
    }
}

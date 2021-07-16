<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    private ?string $newUsername = null;
    private ?string $oldPassword = null;
    private ?string $newPassword = null;

    /** getters **/
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


    /**
     * Check if the actual and new username are conform and change the username if so
     * @return bool true if the changes succeed, false otherwise
     */
    public function validateNewUsername(User $user): bool
    {
        if (is_string($this->newUsername) && $this->newUsername !== $user->getUsername()) {
            $user->setUsername($this->newUsername);
            return true;
        }
        return false;
    }

    /**
     * Check if the actual and new password are conform and change the username if so
     * @return bool return true if the changes succeed, false otherwise
     */
    public function validateNewPassword(User $user, UserPasswordEncoderInterface $passwordEncoder): bool
    {
        if (
            is_string($this->getOldPassword())
            && $passwordEncoder->isPasswordValid($user, $this->getOldPassword())
            && is_string($this->getNewPassword())
        ) {
            $user->setPassword($passwordEncoder->encodePassword($user, $this->getNewPassword()));
            return true;
        }
        return false;
    }

    /**
     * Find if there are errors in username and password changes
     * @return array return array fill with errors found
     */
    public function findUserErrors(
        User $user,
        UserPasswordEncoderInterface $passwordEncoder,
        bool $isPasswordValid
    ): array {
        $errors = [];
        if (!$this->getNewUsername()) {
            $errors[] = "Nom d'utilisateur invalide";
        }

        if (!$isPasswordValid && is_string($this->getOldPassword())) {
            if (!$passwordEncoder->isPasswordValid($user, $this->getOldPassword())) {
                $errors[] = "Votre mot de passe est invalide";
            } elseif (!$this->getNewPassword()) {
                $errors[] = "Veuillez entré un nouveau mot de passe";
            }
        }
        return $errors;
    }
}

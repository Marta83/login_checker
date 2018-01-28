<?php

namespace Trovit\Bundle\UserBundle\Entity\Repository;

use Trovit\Bundle\UserBundle\Entity\User;

interface UserRepository
{
    public function loadUserByUsername(string $username): ?User;
    public function insert(User $user): void;
}

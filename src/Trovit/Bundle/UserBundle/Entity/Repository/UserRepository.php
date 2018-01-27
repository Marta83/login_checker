<?php

namespace Trovit\Bundle\UserBundle\Entity\Repository;

interface UserRepository
{
    public function loadUserByUsername($id);
}

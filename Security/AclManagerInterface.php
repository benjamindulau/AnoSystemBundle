<?php

/**
 * This file is part of the AnoSystemBundle
 *
 * (c) anonymation <contact@anonymation.com>
 *
 */

namespace Ano\Bundle\SystemBundle\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

/**
 * Abstraction of Symfony2's ACLs/ACEs common operations
 *
 * @author Benjamin Dulau <benjamin.dulau@anonymation.com>
 */
interface AclManagerInterface
{
    /**
     * @param UserInterface $user            The granted user
     * @param mixed         $object          The object on which add privileges
     * @param integer       $permissionMask  Mask representing the privileges
     * @return void
     */
    public function grantPrivilegesOnObject(UserInterface $user, $object, array $permissionMasks);

    /**
     * @param UserInterface $user            The granted user
     * @param string        $class           The full qualified namespace to the class
     * @param integer       $permissionMask  Mask representing the privileges
     * @return void
     */
    public function grantPrivilegesOnClass(UserInterface $user, $class, array $permissionMasks);
}
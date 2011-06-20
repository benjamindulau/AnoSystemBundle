<?php

/**
 * This file is part of the AnoSystemBundle
 *
 * (c) anonymation <contact@anonymation.com>
 *
 */

namespace Ano\Bundle\SystemBundle\Security;

use
    Symfony\Component\Security\Core\User\UserInterface,
    Symfony\Component\Security\Acl\Model\AclProviderInterface,
    Symfony\Component\Security\Acl\Permission\MaskBuilder,
    Symfony\Component\Security\Acl\Domain\UserSecurityIdentity,
    Symfony\Component\Security\Acl\Domain\ObjectIdentity,
    Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity
;

/**
 * Implementation of AclManagerInterface
 * an abstraction of common Symfony2's ACLs/ACEs related operations
 *
 * @author Benjamin Dulau <benjamin.dulau@anonymation.com>
 */
class AclManager implements AclManagerInterface
{
    /** @var AclProviderInterface */
    protected $aclProvider;

    public function __construct(AclProviderInterface $aclProvider)
    {
        $this->aclProvider = $aclProvider;
    }

    /**
     * {@inheritDoc}
     */
    public function grantPrivilegesOnObject(UserInterface $user, $object, array $privileges = array())
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException(sprintf('$object must be an instance of an object'));
        }

        $objectIdentity = ObjectIdentity::fromDomainObject($object);
        $acl = $this->aclProvider->createAcl($objectIdentity);
        $securityIdentity = UserSecurityIdentity::fromAccount($user);

        // grant
        $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
        $this->aclProvider->updateAcl($acl);
    }

    /**
     * {@inheritDoc}
     */
    public function grantPrivilegesOnClass(UserInterface $user, $class, array $privileges)
    {
        // TODO: Implement grantPrivilegesOnClass() method.
    }

    private function extractMasks(array $privileges)
    {
        
    }
}
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
    Symfony\Component\Security\Acl\Model\MutableAclProviderInterface,
    Symfony\Component\Security\Acl\Permission\MaskBuilder,
    Symfony\Component\Security\Acl\Domain\UserSecurityIdentity,
    Symfony\Component\Security\Acl\Domain\ObjectIdentity,
    Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity,
    Symfony\Component\Security\Acl\Exception\AclAlreadyExistsException,
    Doctrine\Common\Util\ClassUtils
;

/**
 * Implementation of AclManagerInterface
 * an abstraction of common Symfony2's ACLs/ACEs related operations
 *
 * @author Benjamin Dulau <benjamin.dulau@anonymation.com>
 */
class AclManager implements AclManagerInterface
{
    /** @var MutableAclProviderInterface */
    protected $aclProvider;

    public function __construct(MutableAclProviderInterface $aclProvider)
    {
        $this->aclProvider = $aclProvider;
    }

    /**
     * {@inheritDoc}
     */
    public function grantPrivilegesOnObject(UserInterface $user, $object, array $privileges)
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException(sprintf('$object must be an instance of an object'));
        }

        $objectIdentity = ObjectIdentity::fromDomainObject($object);
        try {
            $acl = $this->aclProvider->createAcl($objectIdentity);
        } catch(AclAlreadyExistsException $e) {
            // Get Acl if already exists
            $acl = $this->aclProvider->findAcl($objectIdentity);
        } catch(\Exception $e) {
            throw $e;
        }

        // TODO: Depdency to Doctrine here => To be removed as soon as a standard way is implemented in Symfony Security Component
        $className = ClassUtils::getClass($user);
        $securityIdentity = new UserSecurityIdentity($user->getUsername(), $className);

        // grant
        foreach ($privileges as $privilege) {
            $acl->insertObjectAce($securityIdentity, $privilege);
        }

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
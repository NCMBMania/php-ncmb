<?php

namespace Ncmb;

/**
 * Role - Representation of an access Role.
 */
class Role extends NCMBObject
{
    const NCMB_CLASS_NAME = 'role';
    const API_PATH = 'roles';

    /**
     * Create a Role object with a given name and ACL.
     *
     * @param string $name
     * @param \Ncmb\Acl|null $acl
     *
     * @return \Ncmb\Role
     */
    public static function createRole($name, $acl = null)
    {
        $role = new self(self::NCMB_CLASS_NAME);
        $role->setName($name);
        if ($acl) {
            $role->setAcl($acl);
        }

        return $role;
    }

    /**
     * Get path string
     * @return string path string
     */
    public function getApiPath()
    {
        return self::API_PATH;
    }

    /**
     * Returns the role name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->get('roleName');
    }

    /**
     * Sets the role name.
     *
     * @param string $name The role name
     * @throws \Ncmb\Exception
     */
    public function setName($name)
    {
        if ($this->getObjectId()) {
            throw new Exception(
                "A role's name can only be set before it has been saved.");
        }
        if (!is_string($name)) {
            throw new Exception("A role's name must be a string.");
        }
        return $this->set('roleName', $name);
    }

    /**
     * Get relation of blong usser of this role
     * @return \Ncmb\Relation
     */
    public function getUsers()
    {
        return $this->getRelation('belongUser');
    }

    /**
     * Get Relation of blong role of this role
     * @return \Ncmb\Relation
     */
    public function getRoles()
    {
        return $this->getRelation('belongRole');
    }

    /**
     * Get Query object to search roles
     * @return \Ncmb\Query
     */
    public static function getQuery()
    {
        $query = new Query(self::NCMB_CLASS_NAME);
        $query->setApiPath(self::API_PATH);
        return $query;
    }
}

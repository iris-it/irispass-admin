<?php

namespace App\Services\Filesystems;


use App\File;
use App\Group;
use App\Organization;
use App\User;
use BadMethodCallException;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;
use Ramsey\Uuid\Uuid;

class FileShareService
{

    private $file;

    /**
     * This function initializes the File share check
     * We can provide an UUID, a path, a virtual path or a instance of App\File
     *
     * @param $file
     */
    public function initialize($file)
    {
        // check by uuid
        if (is_string($file) && Uuid::isValid($file)) {
            $this->file = File::where('uuid', $file)->get()->first();
        }

        // check by path
        if (is_string($file)) {
            $this->file = File::where('full_path', $file)->orWhere('virtual_path', $file)->get()->first();
        }

        // check by model
        if ($file instanceof File) {
            $this->file = $file;
        }

    }

    /**
     * This methods test the ability of an user against a given file
     * the methods takes an instance of App\User or an user's uuid
     *
     *
     * 1 - only read and write are valid methods
     * 2 - if the file is public, anyone can read
     * 3 - if an UUID of an user is provided, we try to resolve it
     * 4 - if no user is resolved, no permissions
     * 5 - if the user is the owner, all permissions
     *
     * we retrieve the organization uuid of an user
     * all his groups uui and his sub
     * the check order is important because an organization
     * can have many groups and users and groups can contains users
     * so it will be quicker
     *
     * 6 - we try to find if the file has shares to organizations with the specified method
     * 7 - we try to find if the file has shares to groups with the specified method
     * 8 - we try to find if the file has shares to users with the specified method
     * the structure of a share is ['uuid_of_entity' => ['read' => false, 'write' => false], ...]
     *
     * if nothing is found, all permissions revoked
     *
     * @param $action
     * @param null $user
     * @return bool
     */
    public function can($action, $user = null)
    {
        if (!in_array($action, ['read', 'write'])) {
            throw new BadMethodCallException('can only accept "read" or "write" as action');
        }

        if ($action === 'read' && $this->file->is_public) {
            return true;
        }

        if ($user !== null && !$user instanceof User) {
            $user = User::where('sub', $user)->first();
        }

        if (!$user) {
            return false;
        }

        if ($this->file->owner_id === $user->sub) {
            return true;
        }

        $user_organization_uuid = $user->organization->uuid;
        $user_groups_uuid = $user->groups->pluck('uuid');
        $user_sub = $user->sub;


        foreach ($this->file->organizations as $uuid => $rights) {
            if ($user_organization_uuid === $uuid) {
                return $rights[$action];
            }
        }

        foreach ($this->file->groups as $uuid => $rights) {
            foreach ($user_groups_uuid as $groups_uuid) {
                if ($groups_uuid === $uuid) {
                    return $rights[$action];
                }
            }
        }

        foreach ($this->file->users as $sub => $rights) {
            if ($user_sub === $sub) {
                return $rights[$action];
            }
        }

        return false;

    }

    /**
     * Set Owner of a file
     *
     * @param User $user
     * @return $this
     */
    public function setOwner(User $user)
    {
        $this->file->owner_id = $user->id;

        $this->file->save();

        return $this;
    }

    /**
     * Add user to a file
     * the structure of a share is ['uuid_of_entity' => ['read' => false, 'write' => false], ...]
     *
     * @param User $user
     * @param bool $read
     * @param bool $write
     * @return $this
     */
    public function addUser(User $user, $read = false, $write = false)
    {

        array_push($this->file->users, [$user->sub => ['read' => $read, 'write' => $write]]);

        $this->file->save();

        return $this;
    }

    /**
     * Add group to a file
     * the structure of a share is ['uuid_of_entity' => ['read' => false, 'write' => false], ...]
     *
     * @param Group $group
     * @param bool $read
     * @param bool $write
     * @return $this
     */
    public function addGroup(Group $group, $read = false, $write = false)
    {
        array_push($this->file->groups, [$group->uuid => ['read' => $read, 'write' => $write]]);

        $this->file->save();

        return $this;
    }

    /**
     * Add user to a file
     * the structure of a share is ['uuid_of_entity' => ['read' => false, 'write' => false], ...]
     *
     * @param Organization $organization
     * @param bool $read
     * @param bool $write
     * @return $this
     */
    public function addOrganization(Organization $organization, $read = false, $write = false)
    {
        array_push($this->file->organizations, [$organization->uuid => ['read' => $read, 'write' => $write]]);

        $this->file->save();

        return $this;
    }

    /**
     * Remove the user share permissions from a file
     *
     * @param User $user
     * @return $this
     */
    public function removeUser(User $user)
    {
        foreach (array_keys($this->file->users) as $key) {
            unset($this->file->users[$key][$user->sub]);
        }

        $this->file->save();

        return $this;
    }

    /**
     * Remove the group share permissions from a file
     *
     * @param Group $group
     * @return $this
     */
    public function removeGroup(Group $group)
    {
        foreach (array_keys($this->file->groups) as $key) {
            unset($this->file->groups[$key][$group->uuid]);
        }


        $this->file->save();

        return $this;
    }

    /**
     * Remove the organization share permissions from a file
     *
     * @param Organization $organization
     * @return $this
     */
    public function removeOrganization(Organization $organization)
    {

        foreach (array_keys($this->file->organization) as $key) {
            unset($this->file->organization[$key][$organization->uuid]);
        }

        $this->file->save();

        return $this;
    }

    /**
     * Remove all the permissions for a given file
     *
     * @return $this
     */
    public function revokeAllPermissions()
    {
        unset($this->file->users);
        unset($this->file->groups);
        unset($this->file->organizations);

        $this->file->save();

        return $this;
    }

    /**
     * Set visibility of a file as public
     *
     * @return $this
     */
    public function setAsPublic()
    {
        $this->file->is_public = true;

        return $this;
    }

    /**
     * Set visibility of a file as private
     *
     * @return $this
     */
    public function setAsPrivate()
    {
        $this->file->is_public = false;

        return $this;
    }


}
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

    public function can($action, User $user)
    {
        if (!in_array($action, ['read', 'write'])) {
            throw new BadMethodCallException('can only accept "read" or "write" as action');
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

    public function setOwner(User $user)
    {
        $this->file->owner_id = $user->id;

        $this->file->save();

        return $this;
    }

    public function addUser(User $user, $read = false, $write = false)
    {

        array_push($this->file->users, [$user->sub => ['read' => $read, 'write' => $write]]);

        $this->file->save();

        return $this;
    }

    public function addGroup(Group $group, $read = false, $write = false)
    {
        array_push($this->file->groups, [$group->uuid => ['read' => $read, 'write' => $write]]);

        $this->file->save();

        return $this;
    }

    public function addOrganization(Organization $organization, $read = false, $write = false)
    {
        array_push($this->file->organizations, [$organization->uuid => ['read' => $read, 'write' => $write]]);

        $this->file->save();

        return $this;
    }

    public function removeUser(User $user)
    {
        foreach (array_keys($this->file->users) as $key) {
            unset($this->file->users[$key][$user->sub]);
        }

        $this->file->save();

        return $this;
    }

    public function removeGroup(Group $group)
    {
        foreach (array_keys($this->file->groups) as $key) {
            unset($this->file->groups[$key][$group->uuid]);
        }


        $this->file->save();

        return $this;
    }

    public function removeOrganization(Organization $organization)
    {

        foreach (array_keys($this->file->organization) as $key) {
            unset($this->file->organization[$key][$organization->uuid]);
        }

        $this->file->save();

        return $this;
    }

    public function revokeAllPermissions()
    {
        unset($this->file->users);
        unset($this->file->groups);
        unset($this->file->organizations);

        $this->file->save();

        return $this;
    }

    public function setAsPublic()
    {
        $this->file->is_public = true;

        return $this;
    }

    public function setAsPrivate()
    {
        $this->file->is_public = false;

        return $this;
    }


}
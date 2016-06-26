<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Irisit\IrispassShared\Model\UserGroup;
use Laracasts\Flash\Flash;

class UsersGroupsController extends Controller
{

    /**
     * Add an user to a specified group
     * @param $userId
     * @param $groupId
     * @return \Illuminate\Http\Response
     */
    public function addUserToGroup($groupId, $userId)
    {

        $group = UserGroup::find($groupId);
        $group->users()->attach($userId);

        Flash::success(Lang::get('users_groups.update-success'));

        return redirect(action('UsersManagementController@index').'#orgagroupsaccess');

    }

    /**
     * Remove user from a specified group
     *
     * @param $userId
     * @param $groupId
     * @return \Illuminate\Http\Response
     */
    public function removeUserFromGroup($groupId, $userId)
    {
        $group = UserGroup::find($groupId);
        $group->users()->detach($userId);

        Flash::success(Lang::get('users_groups.update-success'));

        return redirect(action('UsersManagementController@index').'#orgagroupsaccess');

    }


}

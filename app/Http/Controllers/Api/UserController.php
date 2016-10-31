<?php

namespace App\Http\Controllers\Api;

use App\Group;
use App\Services\OsjsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends ApiController
{

    public function getCurrentUser(Request $request, OsjsService $osjsService)
    {
        $user = auth('api')->user();
        $payload = auth('api')->payload();

        $osjsService->createDirectory('user', $payload->sub);

        $data = [
            'sub' => $payload->sub,
            'name' => $payload->name,
            'preferred_username' => $payload->preferred_username,
            'given_name' => $payload->given_name,
            'family_name' => $payload->family_name,
            'email' => $payload->email,
            'resource_access' => json_encode($payload->resource_access),
        ];

        $user->update($data);

        $user->provider()->update(['access_token' => $request->bearerToken()]);

        return response()->json($user->toArray());
    }

    public function updateSettings(Request $request)
    {
        $user = auth('api')->user();

        $user->settings = $request->get('settings');

        $user->save();

        return response()->json($user->settings);
    }

    public function getUserGroups()
    {
        $user = auth('api')->user();

        $groups = [];

        $pivot = DB::table('groups_users_pivot')->where('user_id', $user->id)->get();

        foreach ($pivot as $group) {
            $groups[] = Group::findOrFail($group->group_id)->toArray();
        }

        return response()->json($groups);

    }


}

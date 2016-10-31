<?php

namespace App\Services\Auth;

use App\User;
use Firebase\JWT\JWT;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class JWTGuard implements Guard
{

    /**
     * The currently authenticated user.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    protected $user;

    /**
     * The payload of the authenticated user.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    protected $payload;

    /**
     * The user provider implementation.
     *
     * @var \Illuminate\Contracts\Auth\UserProvider
     */
    protected $provider;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;


    /**
     * Create a new authentication guard.
     *
     * @param  \Illuminate\Contracts\Auth\UserProvider $provider
     * @param  \Illuminate\Http\Request $request
     */
    public function __construct(UserProvider $provider, Request $request)
    {
        $this->request = $request;
        $this->provider = $provider;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if (!is_null($this->user)) {
            return $this->user;
        }

        $user = null;

        $payload = $this->payload();

        if (!empty($payload)) {

            $user = User::where('sub', $payload->sub)->first();
        }

        return $this->user = $user;
    }

    /**
     * Get the payload of the authenticated user.
     *
     */
    public function payload()
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if (!is_null($this->payload)) {
            return $this->payload;
        }

        $payload = null;

        $token = $this->getTokenForRequest();

        if (!empty($token)) {

            JWT::$leeway = 1000;

            $payload = JWT::decode($token, config('jwt.keys.public'), array('RS256'));

        }

        return $this->payload = $payload;
    }

    /**
     * Get the token for the current request.
     *
     * @return string
     */
    public function getTokenForRequest()
    {
        return $this->request->bearerToken();
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {

        abort('validate in JWTGUARD TODO', 500);
        dd($credentials);

//        if (empty($credentials[$this->inputKey])) {
//            return false;
//        }
//
//        $credentials = [$this->storageKey => $credentials[$this->inputKey]];
//
//        if ($this->provider->retrieveByCredentials($credentials)) {
//            return true;
//        }

        return false;
    }

    /**
     * Set the current request instance.
     *
     * @param  \Illuminate\Http\Request $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function authenticate()
    {
        if (!is_null($user = $this->user())) {
            return $user;
        }

        throw new AuthenticationException;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return !is_null($this->user());
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return !$this->check();
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|null
     */
    public function id()
    {
        if ($this->user()) {
            return $this->user()->getAuthIdentifier();
        }
    }

    /**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @return $this
     */
    public function setUser(AuthenticatableContract $user)
    {
        $this->user = $user;

        return $this;
    }
}

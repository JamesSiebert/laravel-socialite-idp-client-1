<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // -- Redirect the user to the external auth servers page --
    public function redirectToExternalAuthServer(): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        return Socialite::driver('laravelpassport')->redirect();
    }

    // - Obtain the user information from provider --
    public function handleExternalAuthCallback(): RedirectResponse
    {
        $user = Socialite::driver('laravelpassport')->user();
        $authUser = $this->findOrCreateUser($user, 'laravelpassport');
        Auth::login($authUser, true);
        return redirect($this->redirectTo);
    }

    // -- If a user has registered before, return the user else, create a new user object --
    public function findOrCreateUser($user, $provider): User
    {
        // Return the user if it exists - provider ID is the IDP's user ID
        $authUser = User::where('provider_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }

        $passportUser = $user->user;

        // Create new local user from the details we received from the IDP
        return User::create([
            'name' => $passportUser['name'],
            'email' => $passportUser['email'],
            'provider' => $provider,
            'provider_id' => $user->id,
        ]);
    }
}

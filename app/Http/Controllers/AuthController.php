<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    protected UserService $user_service;

    /**
     * Constructor.
     *
     * @param UserService $user_service
     */
    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    /**
     * Log in the user.
     *
     * @param LoginRequest $login_request
     * @return RedirectResponse
     */
    public function login(LoginRequest $login_request): RedirectResponse
    {
        $credentials = $login_request->validated();
        if (Auth::attempt($credentials)) {
            $login_request->session()->regenerate();

            return redirect()->intended('/books');
        }

        return back()->withErrors([
            'email' => 'Email or Password is incorrect.',
        ])->withInput();
    }

    /**
     * Log out the user.
     *
     * @param Request $logout_request
     * @return RedirectResponse
     */
    public function logout(Request $logout_request): RedirectResponse
    {
        Auth::logout();
        $logout_request->session()->invalidate();
        $logout_request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Register a new user.
     *
     * @param RegisterRequest $register_request
     * @return RedirectResponse
     */
    public function register(RegisterRequest $register_request): RedirectResponse
    {
        try {
            $user_info = $register_request->validated();
            $this->user_service->create($user_info);

            return redirect('/login')->with('success', 'User registered successfully. Please log in again!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect('/login')->with('error', 'Failed to register new user. Please try again.');
        }
    }
}

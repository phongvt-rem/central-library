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
    protected UserService $userService;

    /**
     * Constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Log in the user.
     *
     * @param LoginRequest $loginRequest
     * @return RedirectResponse
     */
    public function login(LoginRequest $loginRequest): RedirectResponse
    {
        $credentials = $loginRequest->validated();
        if (Auth::attempt($credentials)) {
            $loginRequest->session()->regenerate();

            return redirect()->intended('/books');
        }

        return back()->withErrors([
            'email' => 'Email or Password is incorrect.',
        ])->withInput();
    }

    /**
     * Log out the user.
     *
     * @param Request $logoutRequest
     * @return RedirectResponse
     */
    public function logout(Request $logoutRequest): RedirectResponse
    {
        Auth::logout();
        $logoutRequest->session()->invalidate();
        $logoutRequest->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Register a new user.
     *
     * @param RegisterRequest $registerRequest
     * @return RedirectResponse
     */
    public function register(RegisterRequest $registerRequest): RedirectResponse
    {
        try {
            $userInfo = $registerRequest->validated();
            $this->userService->createUser($userInfo);

            return redirect('/login')->with('success', 'User registered successfully. Please log in again!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect('/login')->with('error', 'Failed to register new user. Please try again.');
        }
    }
}

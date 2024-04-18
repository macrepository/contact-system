<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;

class UserAuthController extends Controller
{
    /**
     * Display user login page
     *
     * @return View
     */
    public function createLogin(): View
    {
        return view('pages.auth.login');
    }

    /**
     * Display user registration page
     *
     * @return View
     */
    public function createRegister(): View
    {
        return view('pages.auth.register');
    }

    /**
     * Handle an incoming user registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     * @return RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'  => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        event(new Registered($user));
 
        Auth::login($user);

        return redirect(route('userRegistered', absolute: false));
    }

    /**
     * Handle an incoming user login request.
     *
     * @throws \Illuminate\Validation\ValidationException
     * @return RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email'     => 'required',
            'password'  => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()
                ->intended(
                    route('contacts', absolute: false)
                );
        }

        return back()->with('error', 'Sorry! The email or password is not valid.');
    }

    /**
     * Destroy user authentication
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();

        return redirect(route('login', absolute: false));
    }
}

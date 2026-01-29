<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'first_name' => ['required', 'string', 'max:255', 'regex:/^[\pL]+$/u'],
        'last_name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
        'password' => ['required', 'string', 'min:3'], 
    ], [
        'first_name.regex' => 'Vārds drīkst saturēt tikai burtus.',
        'last_name.regex' => 'Uzvārds drīkst saturēt tikai burtus.',
    ]);

    $firstName = mb_convert_case(mb_strtolower($request->first_name), MB_CASE_TITLE, "UTF-8");
    $lastName = mb_convert_case(mb_strtolower($request->last_name), MB_CASE_TITLE, "UTF-8");

    $lastUser = User::orderBy('created_at', 'desc')->first();
    $nextNumber = $lastUser ? ((int) str_replace('usr-', '', $lastUser->id)) + 1 : 1;

    $formattedId = 'usr-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    $username = 'user' . $nextNumber;
    $email = $username . '@RHL.lv';

    $user = User::create([
        'id' => $formattedId,
        'username' => $username,
        'full_name' => $firstName . ' ' . $lastName,
        'email' => $email,
        'password' => Hash::make($request->password),
        'role' => 'user',
        'active' => true,
    ]);

    event(new Registered($user));
    Auth::login($user);

    return redirect(route('dashboard'));
}
}
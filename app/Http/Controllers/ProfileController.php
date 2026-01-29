<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $nameParts = explode(' ', $user->full_name, 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        return view('profile.edit', compact('user', 'firstName', 'lastName'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'first_name' => ['required', 'string', 'max:100', 'regex:/^[\pL]+$/u'],
            'last_name' => ['required', 'string', 'max:100', 'regex:/^[\pL\s\-]+$/u'],
        ], [
            'first_name.regex' => 'Vārds drīkst saturēt tikai burtus.',
            'last_name.regex' => 'Uzvārds drīkst saturēt tikai burtus.',
        ]);

        $fName = mb_convert_case(mb_strtolower($request->first_name), MB_CASE_TITLE, "UTF-8");
        $lName = mb_convert_case(mb_strtolower($request->last_name), MB_CASE_TITLE, "UTF-8");

        $user->update([
            'full_name' => $fName . ' ' . $lName
        ]);

        return redirect()->back()->with('success', 'Profils veiksmīgi atjaunināts!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
   public function index() 
    {
        if(auth()->user()->role !== 'admin') abort(403);
        
        $stats = [
            'total' => \App\Models\User::count(),
            'new' => \App\Models\Kase::where('status', 'new')->count(),
            'urgent' => \App\Models\Kase::where('priority', 'high')->count(),
        ];

        return view('admin.users', [
            'users' => User::orderBy('created_at', 'desc')->get(),
            'stats' => $stats
        ]);
    }

    public function updateRole(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('status', 'Loma veiksmīgi mainīta uz: ' . $request->role);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $user = User::findOrFail($id);
        
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username'  => 'required|string|unique:users,username,' . $user->id,
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'role'      => 'required|string',
            'active'    => 'required|boolean'
        ]);

        $user->update([
            'full_name' => $request->full_name,
            'username'  => $request->username,
            'email'     => $request->email,
            'role'      => $request->role,
            'active'    => $request->active,
        ]);

        return redirect()->back()->with('status', 'Lietotāja dati atjaunoti.');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Šajā darbavietā (pirms aizejat no RHL)sevi dzēst nevar.. ');
        }

        $user->delete();
        return redirect()->back()->with('status', 'Lietotājs ir izdzēsts.');
    }
}
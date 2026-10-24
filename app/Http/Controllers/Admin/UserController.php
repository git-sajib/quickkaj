<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::orderByDesc('created_at')->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'role' => 'required|in:admin,editor,user',
        ]);

        // Prevent removing the last admin
        if ($user->isAdmin() && $validated['role'] !== 'admin') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                return back()->withErrors(['role' => 'Cannot remove the last administrator.']);
            }
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'ব্যবহারকারী আপডেট হয়েছে।');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'নিজেকে মুছতে পারবেন না।']);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'ব্যবহারকারী মুছে ফেলা হয়েছে।');
    }
}

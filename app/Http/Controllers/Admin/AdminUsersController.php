<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;


class AdminUsersController extends Controller
{
    public function index(Request $request) {
        $query = User::query();
    
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', "%{$request->search}%");
        }
    
        if ($request->filled('email')) {
            $query->where('email', 'LIKE', "%{$request->email}%");
        }
    
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
    
        $users = $query->orderBy('created_at', 'desc')->paginate(7);
    
        if ($request->ajax()) {
            return view('admin.users.table', compact('users'))->render();
        }
    
        return view('admin.users.index', compact('users'));
    }

    public function create() {
        
        return view('admin.users.create');

    }

    public function show($id) {
        $orders = Order::with('coupon')->where('user_id', $id)->get();
        return view('admin.users.show', compact('orders'));
    }

    public function store(Request $request) {

        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
            'role' => 'required|in:user,admin',    
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validatedData = $request->except('profile_picture', 'password_confirmation');
        
        if ($request->hasFile('profile_picture')) {
            $validatedData['profile_picture'] = $request->file('profile_picture')->store('profilePictures', 'public');
        }
        
        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData); // Save the order
        return redirect()->back()->with('success', 'User created successfully!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        if (request()->ajax()) {
            // Render the edit modal view with the order data
            $view = view('admin.users.edit', compact('user'))->render();
            return response()->json(['html' => $view]);
        }

        // Fallback: Return a full view if the request is not AJAX (optional)
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class . ',email,' . $id],
            'password' => ['nullable','confirmed', Rules\Password::defaults()],
            'role' => 'required|in:user,admin', 
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',   
        ]);

        $validatedData = $request->except('profile_picture', 'password_confirmation');

        $user = User::findOrFail($id);

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']); // Remove password if not provided
        }

        if ($request->hasFile('profile_picture')) {
            $validatedData['profile_picture'] = $request->file('profile_picture')->store('profilePictures', 'public');
        }


        $user->update($validatedData);
        return redirect()->back()->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // This sets the 'deleted_at' timestamp

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }
}
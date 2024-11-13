<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // تحقق من البيانات المدخلة
        $validated = $request->validate([
            'username' => 'required|unique:users,username|max:50',
            'password' => 'required|min:8',
            'name' => 'required|max:100',
            'email' => 'nullable|email|max:100',
            'phone_number' => 'nullable|regex:/^(77|78|73|71|70)\d{7}$/',
            'bio' => 'nullable|string',
            'profile_image' => 'nullable|image|max:1024',
        ]);

        // إنشاء المستخدم
        $user = User::create([
            'username' => $validated['username'],
            'password' => bcrypt($validated['password']),
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone_number' => $validated['phone_number'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'profile_image' => $request->file('profile_image') ? $request->file('profile_image')->store('profiles') : null,
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    public function login(Request $request)
    {
        // تحقق من البيانات المدخلة
        $validated = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // محاولة تسجيل الدخول
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // يحصل على المستخدم المصادق
            return response()->json(['message' => 'Login successful', 'user' => $user], 200);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user, 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        // استخدام Auth::id() للحصول على المعرف الحالي
        if (!$user || $user->id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized or User not found'], 403);
        }

        // تحقق من البيانات المدخلة
        $validated = $request->validate([
            'username' => 'sometimes|required|unique:users,username,' . $user->id . '|max:50',
            'password' => 'sometimes|required|min:8',
            'name' => 'sometimes|required|max:100',
            'email' => 'sometimes|nullable|email|max:100',
            'phone_number' => 'sometimes|nullable|regex:/^(77|78|73|71|70)\d{7}$/',
            'bio' => 'sometimes|nullable|string',
            'profile_image' => 'sometimes|nullable|image|max:1024',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $request->file('profile_image')->store('profiles');
        }

        // تحديث جميع البيانات
        $user->update($validated);

        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        // استخدام Auth::id() للحصول على المعرف الحالي
        if (!$user || $user->id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized or User not found'], 403);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}

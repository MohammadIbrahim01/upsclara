<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FrontendUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;



class AuthController extends Controller
{
    // ✅ Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:frontend_users',
            'email' => 'required|string|email|max:255|unique:frontend_users',
            'mobile' => 'required|string|max:15|unique:frontend_users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = FrontendUser::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    }

    // ✅ Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = FrontendUser::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        }

        // Token create
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);
    }


    public function checkStatus(Request $request)
    {
        if ($request->user()) {
            return response()->json([
                'status' => true,
                'message' => 'User is logged in',
                'user' => $request->user(),
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'User is not logged in',
        ], 401);
    }


     public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // ✅ yaha API broker select karo
        $status = Password::broker('frontend_users')->sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'status' => true,
                'message' => 'Password reset link has been sent to your email.'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => __($status)
        ], 400);
    }

    /**
     * Step 2: Reset password using token
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed|min:6',
        ]);

        // ✅ yaha bhi broker specify karo
        $status = Password::broker('frontend_users')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response()->json([
                'status' => true,
                'message' => 'Password reset successfully.'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => __($status)
        ], 400);
    }

    // ✅ Logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    // ✅ Profile
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }
}

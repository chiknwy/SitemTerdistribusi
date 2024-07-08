<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $token = Str::random(60);

        // Store the token in the password_resets table
        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            ['token' => Hash::make($token), 'created_at' => now()]
        );

        Log::info("Password reset token: $token");

        return response()->json(['message' => 'Password reset link sent to your email'], 200);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Retrieve the token from the password_resets table
        $passwordReset = DB::table('password_resets')->where('email', $user->email)->first();

        if (!$passwordReset || !Hash::check($request->input('token'), $passwordReset->token)) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        // Update the user's password
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // Optionally, delete the password reset token after successful password reset
        DB::table('password_resets')->where('email', $user->email)->delete();

        return response()->json(['message' => 'Password successfully reset'], 200);
    }


    public function showLoginUser()
    {
        try {
            $user = Auth::user();
            if ($user) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Success',
                    'user' => $user
                ], 200);
            } else {
                return response()->json([
                    'status' => 401,
                    'message' => 'No user login'
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function editUpdate(Request $request, User $user)
    {
        try {
            $validasi = Validator::make($request->all(), [
                'name' => 'string|max:255',
                'email' => 'string|email|max:255',
                'old_password' => 'string|min:8|nullable',
                'new_password' => 'string|min:8|nullable|confirmed',
            ]);

            if ($validasi->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validasi->messages()
                ], 422);
            }

            $updateData = [];

            if ($request->filled('name')) {
                $updateData['name'] = $request->name;
            }

            if ($request->filled('email')) {
                $updateData['email'] = $request->email;
            }

            if ($request->filled('old_password') && $request->filled('new_password')) {
                if (!Hash::check($request->old_password, $user->password)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Password lama salah'
                    ], 422);
                }

                $updateData['password'] = Hash::make($request->new_password);
            }

            $user->update($updateData);

            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully'
            ], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'status' => 'error',
                'message' => $th
            ], 500);
        }
    }

    public function deleteUser(User $user)
    {
        try {
            if (User::count() === 1) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Cannot delete the last remaining user'
                ], 422);
            }
            $user->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'status' => 'error',
                'message' => $th
            ], 500);
        }
    }

    public function registerUserApi(Request $request)
    {
        try {
            $validasi = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
            ]);
            if ($validasi->fails()) {
                return response()->json([
                    'status' => 403,
                    'message' => $validasi->messages()
                ], 403);
            }
            $createUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil register',
                'data' => $createUser
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function loginUserApi(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 403,
                'message' => $validasi->messages()
            ], 403);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'status' => 200,
                'message' => 'Login berhasil',
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Email atau password salah'
            ], 401);
        }
    }

    public function registerUserWeb(Request $request)
{
    $validasi = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8|confirmed',
    ]);

    if ($validasi->fails()) {
        return redirect()->back()->withErrors($validasi)->withInput();
    }

    $createUser = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    Auth::login($createUser);

    return redirect('/landing');
}

    public function loginUserWeb(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validasi->fails()) {
            return redirect()->back()->withErrors($validasi)->withInput();
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/landing');
        } else {
            return redirect()->back()->withErrors(['email' => 'Email atau password salah'])->withInput();
        }
    }

    public function forgotPassword(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 403,
                'message' => $validasi->messages()
            ], 403);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return response()->json([
                'status' => 200,
                'message' => 'Link reset password telah dikirim ke email'
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Gagal mengirim link reset password'
            ], 500);
        }
    }

    public function logoutUser(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil logout'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logoutUserWeb()
    {
        Auth::logout();
        return redirect('/login');
    }
}

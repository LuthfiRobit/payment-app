<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        // Check if the user is throttled
        $secondsUntilNextAttempt = $this->getThrottleTime();

        return view('auth.views.login', compact('secondsUntilNextAttempt'));
    }

    public function login(Request $request)
    {
        // Define the throttle key based on the request IP
        $throttleKey = strtolower($request->ip()); // Sesuaikan jika perlu

        // Specify the number of attempts and delay in seconds
        $maxAttempts = 5;
        $decaySeconds = 60; // Lock out for 1 minute

        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $secondsUntilNextAttempt = RateLimiter::availableIn($throttleKey);

            return response()->json([
                'message' => 'Too many login attempts. Please wait before retrying.',
                'retry_after' => $secondsUntilNextAttempt
            ], 429);
        }

        // Validate credentials and attempt login
        $request->validate(['email' => 'required|email', 'password' => 'required|string']);

        // Attempt to authenticate the user
        $user = User::where('email', $request->email)->first();

        if ($user && $user->status === 'aktif' && Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Clear the throttle counter if login is successful
            RateLimiter::clear($throttleKey);

            return response()->json(['message' => 'Login successful']);
        }

        // Increment the throttle count and set custom delay
        RateLimiter::hit($throttleKey, $decaySeconds);

        if ($user && $user->status !== 'aktif') {
            return response()->json(['message' => 'Your account is inactive. Please contact support.'], 403); // 403 Forbidden
        }

        // Invalid credentials
        return response()->json(['message' => 'Invalid credentials. Please try again.'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    protected function throttleKey(Request $request)
    {
        return strtolower($request->ip()); // Or use $request->input('email') if login attempts are tracked per user
    }

    protected function getThrottleTime()
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey(request()), 5)) {
            return RateLimiter::availableIn($this->throttleKey(request()));
        }
        return 0;
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerificationMail;
use App\Models\EmailVerificationOtp;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class OtpVerificationController extends Controller
{
    public function create(Request $request): Response
    {
        $email = $request->query('email');

        return Inertia::render('Auth/VerifyOtp', [
            'email' => $email,
            'status' => session('status'),
        ]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        $record = EmailVerificationOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (! $record) {
            return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
        }

        if ($record->isExpired()) {
            $record->delete();

            return back()->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $user->update(['email_verified_at' => now()]);

        EmailVerificationOtp::where('email', $request->email)->delete();

        Auth::login($user);

        return redirect('/');
    }

    public function resend(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'No account found with this email.']);
        }

        if ($user->email_verified_at) {
            return redirect()->route('login');
        }

        $lastOtp = EmailVerificationOtp::where('email', $request->email)
            ->latest()
            ->first();

        if ($lastOtp && $lastOtp->created_at->diffInSeconds(now()) < 60) {
            return back()->withErrors(['otp' => 'Please wait before requesting a new OTP.']);
        }

        EmailVerificationOtp::where('email', $request->email)->delete();

        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        EmailVerificationOtp::create([
            'email' => $request->email,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($request->email)->send(new OtpVerificationMail($user->name, $otp));

        return back()->with('status', 'A new OTP has been sent to your email.');
    }
}

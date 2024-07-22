<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\SuspendUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSuspend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $suspendUser = SuspendUser::where('email', $user->email)->first();
            
            if ($suspendUser) {
                Auth::logout();
                $note = $suspendUser->note;
                return redirect()->route('login')->with('error', "Akun Anda telah ditangguhkan. Catatan: $note. Silakan hubungi admin untuk informasi lebih lanjut.");
            }
        }

        return $next($request);
    }
}

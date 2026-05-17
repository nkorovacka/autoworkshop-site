<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as ValidationPassword;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Parāda pieteikšanās formu.
     */
    public function showLoginForm(Request $request): View
    {
        $redirect = $request->query('redirect');
        if ($redirect && str_starts_with($redirect, '/')) {
            $request->session()->put('url.intended', $redirect);
        }

        return view('auth.login');
    }

    /**
     * Parāda reģistrācijas formu.
     */
    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    /**
     * Parāda paroles atjaunošanas pieprasījuma formu.
     */
    public function showForgotPasswordForm(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Nosūta paroles atjaunošanas saiti uz e-pastu.
     */
    public function sendResetLink(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink([
            'email' => $data['email'],
        ]);

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    /**
     * Parāda paroles atjaunošanas formu ar tokenu.
     */
    public function showResetPasswordForm(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    /**
     * Atjauno paroli, ja tokens un e-pasts ir derīgi.
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'confirmed',
                ValidationPassword::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        $status = Password::reset(
            $data,
            function ($user) use ($data) {
                $user->forceFill([
                    'password' => Hash::make($data['password']),
                ])->save();

            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    /**
     * Reģistrē jaunu lietotāju, saglabā viņa datus un automātiski pieslēdz sistēmai.
     */
    public function register(Request $request): RedirectResponse
    {
        // Validē ievadītos datus, tai skaitā paroles sarežģītību un e-pasta unikalitāti.
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                ValidationPassword::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ], [
            'name.required' => 'Visiem laukiem jābūt aizpildītiem.',
            'email.required' => 'Visiem laukiem jābūt aizpildītiem.',
            'password.required' => 'Visiem laukiem jābūt aizpildītiem.',
            'password_confirmation.required' => 'Visiem laukiem jābūt aizpildītiem.',
            'email.email' => 'Nepareizs e-pasta formāts.',
            'email.unique' => 'Šāds e-pasts jau tiek izmantots.',
            'password.confirmed' => 'Paroles nesakrīt.',
            'password.min' => 'Parole neatbilst prasībām.',
            'password.letters' => 'Parole neatbilst prasībām.',
            'password.mixed' => 'Parole neatbilst prasībām.',
            'password.numbers' => 'Parole neatbilst prasībām.',
            'password.symbols' => 'Parole neatbilst prasībām.',
        ]);

        // Izveido jaunu lietotāju ar šifrētu paroli.
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Automātiski pieslēdz lietotāju pēc reģistrācijas.
        Auth::login($user);

        // Atjauno sesiju drošības nolūkiem (aizsardzība pret sesijas fiksāciju).
        $request->session()->regenerate();

        return redirect()->intended(route('home'))
            ->with('success', 'Reģistrācija veiksmīga.');
    }

    /**
     * Autentificē lietotāju un novirza uz atbilstošo sākumlapu.
     */
    public function login(Request $request): RedirectResponse
    {
        // Validē pieteikšanās datus.
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Nepareizs e-pasts vai parole.',
            ])->onlyInput('email');
        }

        if (Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            // Atjauno sesiju pēc veiksmīgas pieteikšanās.
            $request->session()->regenerate();

            // Ja lietotājs ir administrators, novirza uz admin paneli.
            $user = Auth::user();
            if ($user && method_exists($user, 'isAdmin') && $user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            // Parastiem lietotājiem atgriež uz sākumlapu.
            return redirect()->intended(route('home'));
        }

        // Neveiksmīgas pieteikšanās gadījumā atgriež kļūdas paziņojumu.
        return back()->withErrors([
            'email' => 'Nepareizs e-pasts vai parole.',
        ])->onlyInput('email');
    }

    /**
     * Atslēdz lietotāju un pilnībā iztīra sesiju.
     */
    public function logout(Request $request): RedirectResponse
    {
        // Izraksta lietotāju no web sarga.
        Auth::guard('web')->logout();

        // Pilnībā anulē sesiju un atjauno CSRF tokenu.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}

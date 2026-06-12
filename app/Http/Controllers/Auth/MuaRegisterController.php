<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Mua;
use App\Models\User;
use App\Notifications\NewMuaRegistration;
use App\Services\VectorBuilderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class MuaRegisterController extends Controller
{
    public function __construct(private VectorBuilderService $vectorBuilder) {}

    public function showRegister()
    {
        if (auth()->check()) {
            if (auth()->user()->isMua()) {
                return redirect()->route('mua.dashboard');
            }
            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
        }

        $districts = District::orderBy('name')->get();
        return view('auth.mua-register', compact('districts'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'               => ['required', 'string', 'max:255'],
            'email'              => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'           => ['required', 'string', 'min:8', 'confirmed'],
            'mua_name'           => ['required', 'string', 'max:255'],
            'district_id'        => ['required', 'exists:districts,id'],
            'whatsapp_number'    => ['required', 'string', 'regex:/^[0-9]+$/', 'min:9', 'max:15'],
            'instagram_username' => ['nullable', 'string', 'regex:/^[a-zA-Z0-9._]+$/', 'max:30'],
        ]);

        // 1. Create MUA profile
        $mua = Mua::create([
            'name'               => $request->mua_name,
            'district_id'        => $request->district_id,
            'whatsapp_number'    => $request->whatsapp_number,
            'instagram_username' => $request->instagram_username,
            'is_active'          => false, // Pending admin approval
        ]);

        // 2. Create User Account
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'mua',
            'is_active' => false, // Pending admin approval
            'mua_id'    => $mua->id,
        ]);

        // Link created_by back to MUA
        $mua->update(['created_by' => $user->id]);

        // 3. Initialize default MUA vector
        $this->vectorBuilder->saveForMua($mua);

        // 4. Notify admins about the new pending registration
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewMuaRegistration($mua));

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Akun Anda sedang ditinjau oleh Admin. Silakan hubungi admin untuk aktivasi.');
    }
}

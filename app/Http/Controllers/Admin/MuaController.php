<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\EventType;
use App\Models\MakeupLook;
use App\Models\Mua;
use App\Models\Theme;
use App\Models\ThemeType;
use App\Models\User;
use App\Services\VectorBuilderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MuaController extends Controller
{
    public function index(Request $request)
    {
        $query = Mua::with('district', 'user')
            ->when($request->search, fn ($q, $s) =>
                $q->where('name', 'like', "%{$s}%")->orWhere('address', 'like', "%{$s}%")
            )
            ->when($request->status === 'active',   fn ($q) => $q->where('is_active', true))
            ->when($request->status === 'inactive', fn ($q) => $q->where('is_active', false))
            ->latest();

        $muas = $query->paginate(15)->withQueryString();

        return view('admin.mua.index', compact('muas'));
    }

    public function create()
    {
        return view('admin.mua.form', $this->formData());
    }

    public function store(Request $request, VectorBuilderService $vbs)
    {
        $data = $this->validateMua($request);

        DB::transaction(function () use ($request, $data, $vbs) {
            $mua = Mua::create([
                'name'              => $data['name'],
                'slug'              => Str::slug($data['name']),
                'description'       => $data['description'] ?? null,
                'address'           => $data['address'] ?? null,
                'whatsapp_number'   => $data['whatsapp_number'] ?? null,
                'instagram_username'=> $data['instagram_username'] ?? null,
                'is_home_service'   => $request->boolean('is_home_service'),
                'service_radius_km' => $data['service_radius_km'] ?? null,
                'district_id'       => $data['district_id'],
                'is_active'         => $request->boolean('is_active', true),
                'created_by'        => auth()->id(),
            ]);

            $user = User::create([
                'name'     => $mua->name,
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
                'role'     => 'mua',
                'is_active'=> $mua->is_active,
                'mua_id'   => $mua->id,
            ]);

            $this->syncRelations($mua, $request);
            $vbs->saveForMua($mua->fresh());
        });

        return redirect()->route('admin.mua.index')->with('success', 'Akun MUA berhasil dibuat.');
    }

    public function edit(Mua $mua)
    {
        $mua->load('eventTypes', 'themes', 'themeTypes', 'makeupLooks', 'serviceDistricts', 'user');
        return view('admin.mua.form', array_merge($this->formData(), compact('mua')));
    }

    public function update(Request $request, Mua $mua, VectorBuilderService $vbs)
    {
        $data = $this->validateMua($request, $mua->id);

        DB::transaction(function () use ($request, $data, $mua, $vbs) {
            $mua->update([
                'name'              => $data['name'],
                'slug'              => Str::slug($data['name']),
                'description'       => $data['description'] ?? null,
                'address'           => $data['address'] ?? null,
                'whatsapp_number'   => $data['whatsapp_number'] ?? null,
                'instagram_username'=> $data['instagram_username'] ?? null,
                'is_home_service'   => $request->boolean('is_home_service'),
                'service_radius_km' => $data['service_radius_km'] ?? null,
                'district_id'       => $data['district_id'],
                'is_active'         => $request->boolean('is_active'),
            ]);

            if ($mua->user) {
                $userUpdate = ['email' => $data['email'], 'is_active' => $mua->is_active];
                if (! empty($data['password'])) {
                    $userUpdate['password'] = Hash::make($data['password']);
                }
                $mua->user->update($userUpdate);
            }

            $this->syncRelations($mua, $request);
            $vbs->saveForMua($mua->fresh());
        });

        return redirect()->route('admin.mua.index')->with('success', 'Data MUA berhasil diperbarui.');
    }

    public function destroy(Mua $mua)
    {
        DB::transaction(function () use ($mua) {
            $mua->user?->delete();
            $mua->delete();
        });

        return back()->with('success', 'MUA berhasil dihapus.');
    }

    public function toggleActive(Mua $mua)
    {
        $mua->update(['is_active' => ! $mua->is_active]);
        $mua->user?->update(['is_active' => $mua->is_active]);

        $status = $mua->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "MUA {$mua->name} berhasil {$status}.");
    }

    private function validateMua(Request $request, ?int $muaId = null): array
    {
        $emailUnique = 'required|email|unique:users,email';
        if ($muaId) {
            $user = Mua::find($muaId)?->user;
            $emailUnique = "required|email|unique:users,email,{$user?->id}";
        }

        return $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => $emailUnique,
            'password'          => $muaId ? 'nullable|string|min:6' : 'required|string|min:6',
            'description'       => 'nullable|string',
            'address'           => 'nullable|string|max:255',
            'whatsapp_number'   => 'nullable|string|max:20',
            'instagram_username'=> 'nullable|string|max:100',
            'is_home_service'   => 'boolean',
            'service_radius_km' => 'nullable|integer|min:0',
            'district_id'       => 'required|exists:districts,id',
            'is_active'         => 'boolean',
        ]);
    }

    private function syncRelations(Mua $mua, Request $request): void
    {
        $mua->eventTypes()->sync($request->input('event_type_ids', []));
        $mua->themes()->sync($request->input('theme_ids', []));
        $mua->themeTypes()->sync($request->input('theme_type_ids', []));
        $mua->makeupLooks()->sync($request->input('makeup_look_ids', []));
        $mua->serviceDistricts()->sync($request->input('service_district_ids', []));
    }

    private function formData(): array
    {
        return [
            'districts'   => District::orderBy('name')->get(),
            'eventTypes'  => EventType::orderBy('sort_order')->get(),
            'themes'      => Theme::with('themeTypes')->get(),
            'themeTypes'  => ThemeType::with('theme')->orderBy('id')->get(),
            'makeupLooks' => MakeupLook::orderBy('id')->get(),
        ];
    }
}

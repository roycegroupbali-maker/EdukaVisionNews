<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * Daftar jabatan beserta jumlah pengguna yang memakainya, supaya admin
     * tahu jabatan mana yang masih dipakai sebelum menghapusnya.
     */
    public function index(): View
    {
        $roles = Role::withCount('users')->orderByDesc('is_system')->orderBy('name')->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function create(): View
    {
        return view('admin.roles.form', [
            'role' => new Role(['permissions' => []]),
            'permissionCatalog' => Role::permissionCatalog(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['is_system'] = false;

        Role::create($data);

        return redirect()->route('admin.roles.index')->with('status', "Jabatan \"{$data['name']}\" berhasil dibuat.");
    }

    public function edit(Role $role): View
    {
        return view('admin.roles.form', [
            'role' => $role,
            'permissionCatalog' => Role::permissionCatalog(),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $data = $this->validated($request);

        // Super Admin selalu punya semua akses — tidak bisa dikunci/dibatasi
        // lewat form, supaya panel tidak pernah kehilangan akun berkuasa penuh.
        if ($role->slug === Role::SUPER_ADMIN) {
            $data['permissions'] = array_keys(Role::permissionCatalog());
        }

        // Nama & slug jabatan sistem sengaja tidak boleh diubah supaya kode
        // (mis. default jabatan Wartawan saat registrasi) tetap konsisten;
        // yang boleh diubah hanya deskripsi & hak aksesnya.
        if ($role->is_system) {
            unset($data['name']);
        } else {
            $data['name'] = $data['name'] ?? $role->name;
        }

        $role->update($data);

        return redirect()->route('admin.roles.index')->with('status', "Jabatan \"{$role->name}\" berhasil diperbarui.");
    }

    public function destroy(Role $role): RedirectResponse
    {
        if ($role->is_system) {
            return back()->withErrors(['role' => 'Jabatan bawaan sistem tidak bisa dihapus.']);
        }

        if ($role->users()->exists()) {
            return back()->withErrors(['role' => "Jabatan \"{$role->name}\" masih dipakai oleh pengguna lain. Pindahkan jabatan pengguna tersebut terlebih dahulu."]);
        }

        $role->delete();

        return back()->with('status', "Jabatan \"{$role->name}\" berhasil dihapus.");
    }

    private function validated(Request $request): array
    {
        $catalog = array_keys(Role::permissionCatalog());

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => [Rule::in($catalog)],
        ]);

        $data['permissions'] = array_values($data['permissions'] ?? []);

        return $data;
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (Role::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}

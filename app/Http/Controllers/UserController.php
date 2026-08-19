<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Position;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [

            new Middleware(
                'permission:users.view',
                only: ['index', 'show']
            ),

            new Middleware(
                'permission:users.create',
                only: ['create', 'store']
            ),

            new Middleware(
                'permission:users.edit',
                only: ['edit', 'update']
            ),

            new Middleware(
                'permission:users.delete',
                only: ['destroy']
            ),

        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('position')
            ->orderBy('full_name')
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $positions = Position::orderBy('name')->get();

        $roles = Role::orderBy('name')->get();

        return view('users.create', compact(
            'positions',
            'roles'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();

        try {

            $avatar = null;

            if ($request->hasFile('avatar')) {

                $avatar = $request
                    ->file('avatar')
                    ->store('avatars', 'public');

            }

            $user = User::create([

                'uuid'        => Str::uuid(),
                'position_id' => $request->position_id,
                'full_name'   => $request->full_name,
                'email'       => $request->email,
                'password'    => Hash::make($request->password),
                'phone'       => $request->phone,
                'avatar'      => $avatar,
                'is_active'   => $request->is_active,

            ]);

            $user->assignRole($request->role);

            DB::commit();

            return redirect()
                ->route('users.index')
                ->with('success', 'User berhasil ditambahkan.');

        } catch (\Throwable $e) {

            DB::rollBack();

            throw $e;

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $positions = Position::orderBy('name')->get();

        $roles = Role::orderBy('name')->get();

        return view('users.edit', compact(
            'user',
            'positions',
            'roles'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        DB::beginTransaction();

        try {

            $data = $request->validated();

            if ($request->hasFile('avatar')) {

                if ($user->avatar) {

                    Storage::disk('public')->delete($user->avatar);

                }

                $data['avatar'] = $request
                    ->file('avatar')
                    ->store('avatars', 'public');
            }

            if (! empty($data['password'])) {

                $data['password'] = Hash::make($data['password']);

            } else {

                unset($data['password']);

            }

            $user->update($data);

            $user->syncRoles([$request->role]);

            DB::commit();

            return redirect()
                ->route('users.index')
                ->with('success', 'User berhasil diperbarui.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {

            return back()->with(
                'error',
                'Anda tidak dapat menghapus akun yang sedang digunakan.'
            );

        }

        DB::beginTransaction();

        try {

            if ($user->avatar) {

                Storage::disk('public')->delete($user->avatar);

            }

            $user->syncRoles([]);

            $user->delete();

            DB::commit();

            return redirect()
                ->route('users.index')
                ->with('success', 'User berhasil dihapus.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->with('error', $e->getMessage());

        }
    }
}

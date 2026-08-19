<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PositionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [

            new Middleware(
                'permission:positions.view',
                only: ['index', 'show']
            ),

            new Middleware(
                'permission:positions.create',
                only: ['create', 'store']
            ),

            new Middleware(
                'permission:positions.edit',
                only: ['edit', 'update']
            ),

            new Middleware(
                'permission:positions.delete',
                only: ['destroy']
            ),

        ];
    }

    public function index()
    {
        $positions = Position::latest()->paginate(10);

        return view('positions.index', compact('positions'));
    }

    public function create()
    {
        return view('positions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|max:20|unique:positions,code',
            'name' => 'required|max:150|unique:positions,name',
        ]);

        Position::create($validated);

        return redirect()
            ->route('positions.index')
            ->with('success', 'Jabatan berhasil ditambahkan.');
    }
    

    public function show(Position $position)
    {
        //
    }

    public function edit(Position $position)
    {
        return view('positions.edit', compact('position'));
    }

    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'code' => 'required|max:20|unique:positions,code,' . $position->id,
            'name' => 'required|max:150|unique:positions,name,' . $position->id,
        ]);

        $position->update($validated);

        return redirect()
            ->route('positions.index')
            ->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy(Position $position)
    {
        $position->delete();

        return redirect()
            ->route('positions.index')
            ->with('success', 'Jabatan berhasil dihapus.');
    }
}
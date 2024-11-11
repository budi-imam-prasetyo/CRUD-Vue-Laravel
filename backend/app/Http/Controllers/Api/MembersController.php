<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Members;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Members::with(['class' => function ($query) {
            $query->withTrashed();
        }]);

        // Handle search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Handle filters
        if ($request->has('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->has('class')) {
            $query->where('class_id', $request->class);
        }

        // Handle column sorting
        if ($request->has('sort_column') && $request->has('sort_direction')) {
            $sortColumn = $request->sort_column;
            $sortDirection = $request->sort_direction;

            // Whitelist kolom yang diizinkan untuk sorting
            $allowedColumns = ['id', 'class_id', 'first_name', 'last_name', 'email', 'address', 'created_at'];

            if (in_array($sortColumn, $allowedColumns)) {
                $query->orderBy($sortColumn, $sortDirection);
            }
        } else if ($request->has('sort_by')) {
            // Fallback ke sorting default jika tidak ada column sorting
            $sort = $request->sort_by === 'latest' ? 'desc' : 'asc';
            $query->orderBy('created_at', $sort);
        }

        $members = $query->paginate(10);

        $members->through(function ($member) {
            return [
                'id' => $member->id,
                'class' => $member->class ? [
                    'id' => $member->class->id,
                    'name' => $member->class->name,
                    'description' => $member->class->description,
                    'created_at' => $member->class->created_at,
                    'updated_at' => $member->class->updated_at,
                    'deleted_at' => $member->class->deleted_at,
                ] : null,
                'first_name' => $member->first_name,
                'last_name' => $member->last_name,
                'email' => $member->email,
                'gender' => $member->gender,
                'address' => $member->address,
                'created_at' => $member->created_at,
                'updated_at' => $member->updated_at,
            ];
        });

        return response()->json($members);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genders = Members::select('gender')->distinct()->pluck('gender');
        return response()->json($genders);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'class_id' => 'required|exists:classes,id',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:members',
                'gender' => 'required|in:Male,Female',
                'address' => 'required|string'
            ]);

            // Buat member baru
            $member = Members::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Member created successfully',
                'data' => $member
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create member',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $member = Members::with('class')->findOrFail($id);

            return response()->json($member);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Member tidak ditemukan',
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $member = Members::findOrFail($id);

            $validated = $request->validate([
                'class_id' => 'required|exists:classes,id',
                'first_name' => 'required|string|min:2|max:255',
                'last_name' => 'required|string|min:2|max:255',
                'email' => 'required|email|unique:members,email,' . $id . ',id',
                'gender' => 'required|in:male,female',
                'address' => 'required|string|min:5'
            ]);

            $member->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Member berhasil diupdate',
                'data' => $member
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate member',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $member = Members::findOrFail($id);
            $member->delete();

            return response()->json([
                'success' => true,
                'message' => 'Member berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus member',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

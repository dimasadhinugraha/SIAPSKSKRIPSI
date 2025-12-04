<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Family;
use Illuminate\Http\Request;

class FamilySearchController extends Controller
{
    /**
     * Search family by name or KK number
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (!$query || strlen($query) < 3) {
            return response()->json([
                'success' => false,
                'message' => 'Masukkan minimal 3 karakter untuk pencarian',
                'data' => []
            ]);
        }

        $families = Family::where('family_name', 'LIKE', "%{$query}%")
            ->orWhere('kk_number', 'LIKE', "%{$query}%")
            ->orWhereHas('headOfFamily', function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->with(['headOfFamily:id,name'])
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $families->map(function($family) {
                return [
                    'id' => $family->id,
                    'family_name' => $family->family_name,
                    'kk_number' => $family->kk_number,
                    'address' => $family->address,
                    'rt' => $family->rt,
                    'rw' => $family->rw,
                    'rt_rw' => "RT {$family->rt}/RW {$family->rw}",
                    'head_of_family_name' => $family->headOfFamily ? $family->headOfFamily->name : 'Tidak ada',
                ];
            })
        ]);
    }

    /**
     * Get family details by ID
     */
    public function show($id)
    {
        $family = Family::with(['headOfFamily:id,name,email', 'users:id,name,email,is_head_of_family,family_id'])
            ->find($id);

        if (!$family) {
            return response()->json([
                'success' => false,
                'message' => 'Keluarga tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $family->id,
                'family_name' => $family->family_name,
                'kk_number' => $family->kk_number,
                'address' => $family->address,
                'rt' => $family->rt,
                'rw' => $family->rw,
                'rt_rw' => "RT {$family->rt}/RW {$family->rw}",
                'head_of_family' => $family->headOfFamily,
                'members' => $family->users->map(function($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'is_head_of_family' => $user->is_head_of_family,
                    ];
                }),
                'member_count' => $family->users->count(),
            ]
        ]);
    }
}

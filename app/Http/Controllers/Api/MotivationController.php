<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Motivation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MotivationController extends Controller
{
    public function store(Request $request)
    {
        $motivation = Motivation::create([
            'user_id' => Auth::user()->id,
            'description' => $request->description,
            'created_at' => Carbon::now()->format('d-m-Y'),
        ]);

        return response()->json([
            'message' => 'motivation has created',
            'data' => $motivation->id
        ]);
    }

    public function getByUserId(Request $request)
    {
        $user = User::find($request->id);

        $motivation = Motivation::where('user_id', $user->id)->get();

        if (!$motivation) {
            return response()->json([
                'message' => 'Data not found',
                'data' => []
            ]);
        }

        return response()->json([
            'message' => 'Data found',
            'data' => $motivation
        ]);
    }
}

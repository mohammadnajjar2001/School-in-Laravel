<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function studentLogin(Request $request)
    {
        if (Auth::guard('student')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $student = Auth::guard('student')->user();
            $token = $student->createToken('StudentToken')->plainTextToken;

            return response()->json([
                'message' => 'تم تسجيل دخول الطالب بنجاح',
                'user' => $student,
                'token' => $token
            ]);
        }

        return response()->json(['message' => 'بيانات الطالب غير صحيحة'], 401);
    }

    public function parentLogin(Request $request)
    {
        if (Auth::guard('parent')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $parent = Auth::guard('parent')->user();
            $token = $parent->createToken('ParentToken')->plainTextToken;

            return response()->json([
                'message' => 'تم تسجيل دخول ولي الأمر بنجاح',
                'user' => $parent,
                'token' => $token
            ]);
        }

        return response()->json(['message' => 'بيانات ولي الأمر غير صحيحة'], 401);
    }

    // تسجيل الخروج عبر API
    public function studentLogout(Request $request)
    {
        if (Auth::guard('student')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $parent = Auth::guard('student')->user();
            $token = $parent->createToken('StudentToken')->plainTextToken;

            return response()->json([
                'message' => 'تم تسجيل خروج الطالب بنجاح',
                'user' => $parent,
                'token' => $token
            ]);
        }
        // $user = $request->user(); // الطالب المسجل حاليًا

        // if ($user) {
        //     $user->currentAccessToken()->delete();
        // }

        // return response()->json([
        //     'message' => 'تم تسجيل خروج الطالب بنجاح'
        // ]);
    }

    public function parentLogout(Request $request)
    {
        $user = $request->user(); // ولي الأمر المسجل حاليًا

        if ($user) {
            $user->currentAccessToken()->delete();
        }

        return response()->json([
            'message' => 'تم تسجيل خروج ولي الأمر بنجاح'
        ]);
    }




    public function test()
    {
        return response()->json([
            'message' => 'شغال ال الكود'
        ], 200);
    }
}

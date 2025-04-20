<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function showProfile(Request $request)
    {
        // الحصول على بيانات الطالب المسجل
        $student = $request->user();

        // تحميل العلاقات المرتبطة
        $student->load('gender', 'grade', 'classroom', 'section', 'myparent'); // تحميل العلاقات المطلوبة

        // تنسيق البيانات لإرجاعها للمستخدم مع العلاقات الكاملة
        return response()->json([
            'name' => $student->name,
            'email' => $student->email,
            'gender' => $student->gender, // إرجاع كائن الـ gender كامل
            'date_of_birth' => $student->Date_Birth,
            'parent' => $student->myparent, // إرجاع كائن ولي الأمر كامل
            'grade' => $student->grade, // إرجاع كائن grade كامل
            'classroom' => $student->classroom, // إرجاع كائن classroom كامل
            'section' => $student->section, // إرجاع كائن section كامل
        ]);
    }
    public function updatePassword(Request $request)
    {
        // التحقق من وجود كلمة المرور الجديدة
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $student = $request->user();  // الـ `user()` تسترجع المستخدم المسجل حاليًا عبر الـ API

        // التحقق من كلمة المرور الحالية
        if (!Hash::check($request->current_password, $student->password)) {
            return response()->json(['message' => 'Current password is incorrect.'], 400);
        }

        // تحديث كلمة المرور
        $student->password = Hash::make($request->new_password);
        $student->save();

        return response()->json(['message' => 'Password updated successfully.']);
    }
}

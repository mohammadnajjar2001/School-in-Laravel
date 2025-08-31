<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;

class StudentController extends Controller
{
    public function getBalance()
    {
        $studentId = auth()->user()->id;

        // حساب الرصيد
        $balance = \App\Models\StudentAccount::where('student_id', $studentId)
            ->selectRaw('SUM(Debit) - SUM(Credit) as remaining')
            ->value('remaining');

        // إذا الرصيد null (يعني ما في سجلات للطالب)
        if (is_null($balance)) {
            $balance = 0;
        }

        // تجهيز الرسالة التوضيحية
        if ($balance > 0) {
            $status = "⚠️ يتوجب عليك دفع {$balance} $ للمدرسة";
        } elseif ($balance < 0) {
            $status = "✅ لقد سددت كامل القسط، ولديك رصيد زائد بقيمة " . abs($balance) . " $";
        } else {
            $status = "🟡 حسابك مسدد بالكامل";
        }

        return response()->json([
            'student_id' => $studentId,
            'balance' => $balance,
            'status' => $status
        ]);
    }
    public function index(Request $request)
    {
        // نفترض أنك تستخدم Laravel Sanctum و المستخدم هو طالب
        $student = auth()->user();
        // التحقق أن الطالب لديه classroom_id
        if (!$student || !$student->classroom->id) {
            return response()->json(['message' => 'الطالب غير مرتبط بأي صف'], 404);
        }

        // جلب المواد الخاصة بصف الطالب
        $subjects = Subject::where('classroom_id', $student->classroom->id)->get();

        return response()->json([
            'subjects' => $subjects
        ]);
    }
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

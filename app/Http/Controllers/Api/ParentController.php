<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Degree;
use App\Models\Fee_invoice;
use App\Models\My_Parent;
use App\Models\ReceiptStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;

class ParentController extends Controller
{
public function receiptStudent($id)
{
    try {
        $student = Student::findOrFail($id);

        if ($student== null) {
            return response()->json([
                'status' => false,
                'message' => ' هذا الطالب غير موجود.'
            ], 403);
        }
        // التحقق من أن الطالب يتبع لولي الأمر الحالي
        if ($student->parent_id !== Auth::id()) {
            return response()->json([
                'status' => false,
                'message' => 'لا تملك صلاحية الوصول إلى هذا الطالب.'
            ], 403);
        }

        // جلب المدفوعات
        $receipts = ReceiptStudent::where('student_id', $id)
            ->with(['student:id,name']) // لتضمين اسم الطالب
            ->get();

        if ($receipts->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'لا توجد مدفوعات لهذا الطالب.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'تم جلب المدفوعات بنجاح.',
            'data' => $receipts
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'حدث خطأ أثناء جلب المدفوعات.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function feeInvoices()
{
    try {
        // جلب معرفات الأبناء المرتبطين بولي الأمر الحالي
        $studentIds = Student::where('parent_id', Auth::id())->pluck('id');

        if ($studentIds->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'لا يوجد طلاب مرتبطون بحسابك.'
            ], 404);
        }

        // جلب الفواتير مع العلاقات
        $feeInvoices = Fee_invoice::whereIn('student_id', $studentIds)
            ->get();

        if ($feeInvoices->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'لا توجد فواتير متاحة حالياً.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'تم جلب الفواتير بنجاح.',
            'data' => $feeInvoices
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'حدث خطأ أثناء جلب الفواتير.',
            'error' => $e->getMessage()
        ], 500);
    }
}
public function attendanceSearch(Request $request)
{
    $request->validate([
        'from' => 'required|date|date_format:Y-m-d',
        'to' => 'required|date|date_format:Y-m-d|after_or_equal:from',
        'student_id' => 'nullable|integer|exists:students,id',
    ], [
        'to.after_or_equal' => 'تاريخ النهاية يجب أن يكون بعد أو يساوي تاريخ البداية.',
        'from.date_format' => 'صيغة التاريخ يجب أن تكون yyyy-mm-dd.',
        'to.date_format' => 'صيغة التاريخ يجب أن تكون yyyy-mm-dd.',
    ]);

    try {
        // جلب جميع أبناء ولي الأمر الحالي
        $studentIds = Student::where('parent_id', Auth::id())->pluck('id');

        if ($studentIds->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'لا يوجد طلاب مرتبطون بولي الأمر الحالي.'
            ], 404);
        }

        // قاعدة البحث
        $query = Attendance::whereBetween('attendence_date', [$request->from, $request->to])
                           ->whereIn('student_id', $studentIds)
                           ->with(['students:id,name']);

        // إذا تم تحديد طالب محدد
        if ($request->filled('student_id') && $studentIds->contains($request->student_id)) {
            $query->where('student_id', $request->student_id);
        }

        $attendanceRecords = $query->get();

        if ($attendanceRecords->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'لا توجد سجلات حضور خلال هذه الفترة.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'تم جلب سجلات الحضور بنجاح.',
            'data' => $attendanceRecords
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'حدث خطأ أثناء جلب بيانات الحضور.',
            'error' => $e->getMessage()
        ], 500);
    }
}
public function results($id)
{
    try {
        $student = Student::findOrFail($id);

        // التحقق من أن الطالب يخص ولي الأمر الحالي
        if ($student->parent_id !== Auth::id()) {
            return response()->json([
                'status' => false,
                'message' => 'هذا الطالب لا ينتمي إلى حسابك.'
            ], 403);
        }

        // جلب الدرجات
        $degrees = Degree::where('student_id', $id)
            ->get();

        if ($degrees->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'لا توجد نتائج لهذا الطالب.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'تم جلب النتائج بنجاح.',
            'data' => $degrees
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'حدث خطأ أثناء جلب النتائج.',
            'error' => $e->getMessage()
        ], 500);
    }
}
    public function index()
    {
        try {
            $parentId = Auth::id();

            // جلب الطلاب المرتبطين بولي الأمر الحالي
               $students = Student::where('parent_id', $parentId)
->with(['grade', 'classroom', 'section'])
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Students retrieved successfully.',
                'data' => $students
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong while fetching students.',
            ], 500);
        }
    }
    public function showProfile(Request $request)
    {
        try {
            // التأكد من تسجيل الدخول
            $userId = Auth::id();
            if (!$userId) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized: Please log in first.',
                ], 401);
            }

            // محاولة العثور على بيانات ولي الأمر
            $parent = My_Parent::select(
                'id',
                'email',
                'Name_Father',
                'National_ID_Father',
                'Passport_ID_Father',
                'Phone_Father',
                'Job_Father',
                'Nationality_Father_id',
                'Blood_Type_Father_id',
                'Religion_Father_id',
                'Address_Father',
                'Name_Mother',
                'National_ID_Mother',
                'Passport_ID_Mother',
                'Phone_Mother',
                'Job_Mother',
                'Nationality_Mother_id',
                'Blood_Type_Mother_id',
                'Religion_Mother_id',
                'Address_Mother'
            )->find($userId);

            // في حال لم يتم العثور على البيانات
            if (!$parent) {
                return response()->json([
                    'status' => false,
                    'message' => 'Parent profile not found.',
                ], 404);
            }

            // النجاح
            return response()->json([
                'status' => true,
                'message' => 'Parent profile retrieved successfully.',
                'data' => $parent,
            ], 200);
        } catch (\Exception $e) {
            // تسجيل الخطأ
            Log::error('Error fetching parent profile: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong. Please try again later.',
            ], 500);
        }
    }


    public function updateProfile(Request $request)
    {
        try {
            // التحقق من المستخدم المسجّل
            $userId = Auth::id();
            if (!$userId) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized.',
                ], 401);
            }

            // التحقق من صحة البيانات المدخلة
            $validator = Validator::make($request->all(), [
                'Name_Father' => 'sometimes|array',
                'Name_Father.ar' => 'nullable|string',
                'Name_Father.en' => 'nullable|string',
                'Phone_Father' => 'sometimes|nullable|string|max:20',
                'Job_Father' => 'sometimes|array',
                'Address_Father' => 'sometimes|nullable|string',

                'Name_Mother' => 'sometimes|array',
                'Name_Mother.ar' => 'nullable|string',
                'Name_Mother.en' => 'nullable|string',
                'Phone_Mother' => 'sometimes|nullable|string|max:20',
                'Job_Mother' => 'sometimes|array',
                'Address_Mother' => 'sometimes|nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // جلب بيانات ولي الأمر
            $parent = My_Parent::find($userId);
            if (!$parent) {
                return response()->json([
                    'status' => false,
                    'message' => 'Parent profile not found.',
                ], 404);
            }

            // تحديث الحقول المطلوبة فقط
            $parent->fill($request->only([
                'Name_Father',
                'Phone_Father',
                'Job_Father',
                'Address_Father',
                'Name_Mother',
                'Phone_Mother',
                'Job_Mother',
                'Address_Mother'
            ]));

            $parent->save();

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully.',
                'data' => $parent
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating parent profile: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
            ], 500);
        }
    }




    public function changePassword(Request $request)
    {
        try {
            $userId = Auth::id();
            if (!$userId) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized.',
                ], 401);
            }

            $validator = Validator::make($request->all(), [
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $parent = My_Parent::find($userId);
            if (!$parent) {
                return response()->json([
                    'status' => false,
                    'message' => 'Parent not found.',
                ], 404);
            }

            // تحقق من كلمة المرور القديمة
            if (!Hash::check($request->current_password, $parent->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Current password is incorrect.',
                ], 403);
            }

            // تحديث كلمة المرور
            $parent->password = Hash::make($request->new_password);
            $parent->save();

            return response()->json([
                'status' => true,
                'message' => 'Password updated successfully.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error changing parent password: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
            ], 500);
        }
    }
}

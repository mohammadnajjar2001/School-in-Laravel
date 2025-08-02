<?php


namespace App\Repository;


use App\Models\Grade;
use App\Models\Subject;
use App\Models\Teacher;

class SubjectRepository implements SubjectRepositoryInterface
{

    public function index()
    {
        $subjects = Subject::get();
        return view('pages.Subjects.index',compact('subjects'));
    }

    public function create()
    {
        $grades = Grade::get();
        $teachers = Teacher::get();
        return view('pages.Subjects.create',compact('grades','teachers'));
    }


    public function store($request)
    {
        // ✅ التحقق مع رسائل مخصصة
        $validated = $request->validate([
            'Name_en' => 'required|string|max:255',
            'Name_ar' => 'required|string|max:255',
            'Grade_id' => 'required|exists:grades,id',
            'Class_id' => 'required|exists:classrooms,id',
            'teacher_id' => 'required|exists:teachers,id',
        ], [
            'Name_en.required' => 'الاسم باللغة الإنجليزية مطلوب.',
            'Name_en.string' => 'الاسم باللغة الإنجليزية يجب أن يكون نصًا.',
            'Name_en.max' => 'الاسم باللغة الإنجليزية يجب ألا يزيد عن 255 حرفًا.',

            'Name_ar.required' => 'الاسم باللغة العربية مطلوب.',
            'Name_ar.string' => 'الاسم باللغة العربية يجب أن يكون نصًا.',
            'Name_ar.max' => 'الاسم باللغة العربية يجب ألا يزيد عن 255 حرفًا.',

            'Grade_id.required' => 'المرحلة الدراسية مطلوبة.',
            'Grade_id.exists' => 'المرحلة الدراسية غير موجودة.',

            'Class_id.required' => 'الصف الدراسي مطلوب.',
            'Class_id.exists' => 'الصف الدراسي غير موجود.',

            'teacher_id.required' => 'اسم المعلم مطلوب.',
            'teacher_id.exists' => 'المعلم المحدد غير موجود.',
        ]);

        try {
            $subjects = new Subject();
            $subjects->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $subjects->grade_id = $request->Grade_id;
            $subjects->classroom_id = $request->Class_id;
            $subjects->teacher_id = $request->teacher_id;
            $subjects->save();

            toastr()->success(trans('messages.success'));
            return redirect()->route('subjects.create');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }



    public function edit($id){

        $subject =Subject::findorfail($id);
        $grades = Grade::get();
        $teachers = Teacher::get();
        return view('pages.Subjects.edit',compact('subject','grades','teachers'));

    }

    public function update($request)
    {
        try {
            $subjects =  Subject::findorfail($request->id);
            $subjects->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $subjects->grade_id = $request->Grade_id;
            $subjects->classroom_id = $request->Class_id;
            $subjects->teacher_id = $request->teacher_id;
            $subjects->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('subjects.create');
        }
        catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            Subject::destroy($request->id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}

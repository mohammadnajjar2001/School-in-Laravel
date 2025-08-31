<?php

namespace App\Repository;

use App\Models\Grade;
use App\Models\Quizze;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;


class QuizzRepository implements QuizzRepositoryInterface
{

    public function index()
    {
        $quizzes = Quizze::get();
        return view('pages.Quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $data['grades'] = Grade::all();
        $data['subjects'] = Subject::all();
        $data['teachers'] = Teacher::all();
        return view('pages.Quizzes.create', $data);
    }

    public function store(Request $request)
    {
        $messages = [
            'Name_en.required'    => 'اسم الاختبار بالإنجليزية مطلوب.',
            'Name_ar.required'    => 'اسم الاختبار بالعربية مطلوب.',
            'subject_id.required' => 'المادة الدراسية مطلوبة.',
            'subject_id.exists'   => 'المادة الدراسية غير موجودة.',
            'Grade_id.required'   => 'المرحلة الدراسية مطلوبة.',
            'Grade_id.exists'     => 'المرحلة الدراسية غير موجودة.',
            'Classroom_id.required' => 'الصف الدراسي مطلوب.',
            'Classroom_id.exists'   => 'الصف الدراسي غير موجود.',
            'section_id.required' => 'الشعبة مطلوب.',
            'section_id.exists'   => 'الشعبة غير موجود.',
            'teacher_id.required' => 'المعلم مطلوب.',
            'teacher_id.exists'   => 'المعلم غير موجود.',
        ];

        $validated = $request->validate([
            'Name_en'      => 'required|string|max:255',
            'Name_ar'      => 'required|string|max:255',
            'subject_id'   => 'required|exists:subjects,id',
            'Grade_id'     => 'required|exists:grades,id',
            'Classroom_id' => 'required|exists:classrooms,id',
            'section_id'   => 'required|exists:sections,id',
            'teacher_id'   => 'required|exists:teachers,id',
        ], $messages);

        try {
            $quizzes = new Quizze();
            $quizzes->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $quizzes->subject_id = $request->subject_id;
            $quizzes->grade_id = $request->Grade_id;
            $quizzes->classroom_id = $request->Classroom_id;
            $quizzes->section_id = $request->section_id;
            $quizzes->teacher_id = $request->teacher_id;
            $quizzes->save();

            toastr()->success(trans('messages.success'));
            return redirect()->route('Quizzes.create');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function edit($id)
    {
        $quizz = Quizze::findorFail($id);
        $data['grades'] = Grade::all();
        $data['subjects'] = Subject::all();
        $data['teachers'] = Teacher::all();
        return view('pages.Quizzes.edit', $data, compact('quizz'));
    }

    public function update($request)
    {
        try {
            $quizz = Quizze::findorFail($request->id);
            $quizz->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $quizz->subject_id = $request->subject_id;
            $quizz->grade_id = $request->Grade_id;
            $quizz->classroom_id = $request->Classroom_id;
            $quizz->section_id = $request->section_id;
            $quizz->teacher_id = $request->teacher_id;
            $quizz->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Quizzes.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            Quizze::destroy($request->id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}

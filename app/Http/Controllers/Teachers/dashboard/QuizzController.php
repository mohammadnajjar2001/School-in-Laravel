<?php

namespace App\Http\Controllers\Teachers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Degree;
use App\Models\Grade;
use App\Models\Question;
use App\Models\Quizze;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;

class QuizzController extends Controller
{


    public function index()
    {
        $quizzes = Quizze::where('teacher_id',auth()->user()->id)->get();
        return view('pages.Teachers.dashboard.Quizzes.index', compact('quizzes'));
    }


    public function create()
    {
        $data['grades'] = Grade::all();
        $data['subjects'] = Subject::where('teacher_id',auth()->user()->id)->get();
        return view('pages.Teachers.dashboard.Quizzes.create', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Name_en'      => 'required|string|max:255',
            'Name_ar'      => 'required|string|max:255',
            'subject_id'   => 'required|exists:subjects,id',
            'Grade_id'     => 'required|exists:grades,id',
            'Classroom_id' => 'required|exists:classrooms,id',
            'section_id'   => 'required|exists:sections,id',
        ], [
            'Name_en.required' => 'اسم الاختبار بالإنجليزية مطلوب.',
            'Name_en.string'   => 'اسم الاختبار بالإنجليزية يجب أن يكون نصًا.',
            'Name_en.max'      => 'اسم الاختبار بالإنجليزية يجب ألا يزيد عن 255 حرفًا.',

            'Name_ar.required' => 'اسم الاختبار بالعربية مطلوب.',
            'Name_ar.string'   => 'اسم الاختبار بالعربية يجب أن يكون نصًا.',
            'Name_ar.max'      => 'اسم الاختبار بالعربية يجب ألا يزيد عن 255 حرفًا.',

            'subject_id.required' => 'المادة مطلوبة.',
            'subject_id.exists'   => 'المادة المختارة غير موجودة.',

            'Grade_id.required' => 'المرحلة الدراسية مطلوبة.',
            'Grade_id.exists'   => 'المرحلة الدراسية غير موجودة.',

            'Classroom_id.required' => 'الصف الدراسي مطلوب.',
            'Classroom_id.exists'   => 'الصف الدراسي غير موجود.',

            'section_id.required' => 'الشعبة مطلوب.',
            'section_id.exists'   => 'الشعبة غير موجود.',
        ]);

        try {
            $quizzes = new Quizze();
            $quizzes->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $quizzes->subject_id = $request->subject_id;
            $quizzes->grade_id = $request->Grade_id;
            $quizzes->classroom_id = $request->Classroom_id;
            $quizzes->section_id = $request->section_id;
            $quizzes->teacher_id = auth()->user()->id;
            $quizzes->save();

            toastr()->success(trans('messages.success'));
            return redirect()->route('quizzes.create');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }



    public function edit($id)
    {
        $quizz = Quizze::findorFail($id);
        $data['grades'] = Grade::all();
        $data['subjects'] = Subject::where('teacher_id',auth()->user()->id)->get();
        return view('pages.Teachers.dashboard.Quizzes.edit', $data, compact('quizz'));
    }

    public function show($id)
    {
        $questions = Question::where('quizze_id',$id)->get();
        $quizz = Quizze::findorFail($id);
        return view('pages.Teachers.dashboard.Questions.index',compact('questions','quizz'));
    }


    public function update(Request $request)
    {
        try {
            $quizz = Quizze::findorFail($request->id);
            $quizz->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $quizz->subject_id = $request->subject_id;
            $quizz->grade_id = $request->Grade_id;
            $quizz->classroom_id = $request->Classroom_id;
            $quizz->section_id = $request->section_id;
            $quizz->teacher_id = auth()->user()->id;
            $quizz->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('quizzes.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function destroy($id)
    {
        try {
            Quizze::destroy($id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function student_quizze($quizze_id)
    {
        $degrees = Degree::where('quizze_id', $quizze_id)->get();
        return view('pages.Teachers.dashboard.Quizzes.student_quizze', compact('degrees'));
    }

    public function repeat_quizze(Request $request)
    {
        Degree::where('student_id', $request->student_id)->where('quizze_id', $request->quizze_id)->delete();
        toastr()->success('تم فتح الاختبار مرة اخرى للطالب');
        return redirect()->back();
    }

}

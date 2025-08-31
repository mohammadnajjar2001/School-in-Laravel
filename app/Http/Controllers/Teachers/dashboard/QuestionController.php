<?php

namespace App\Http\Controllers\Teachers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quizze;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::get();
        $quizz = Quizze::get();
//        return $questions;
        return view('pages.Teachers.dashboard.Questions.index', compact('questions','quizz'));
    }
    public function create(Request $request)
    {
        $quizze_id = $request->quizze_id;
        return view('pages.Teachers.dashboard.Questions.create', compact('quizze_id'));
    }

    // public function store(Request $request)
    // {
    //     try {
    //         $question = new Question();
    //         $question->title = $request->title;
    //         $question->answers = $request->answers;
    //         $question->right_answer = $request->right_answer;
    //         $question->score = $request->score;
    //         $question->quizze_id = $request->quizz_id;
    //         $question->save();
    //         toastr()->success(trans('messages.success'));
    //         return redirect()->back();
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with(['error' => $e->getMessage()]);
    //     }
    // }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'answers' => 'required|array|min:4|max:4',
            'answers.*' => 'required|string|max:255',
            'right_answer' => 'required|in:1,2,3,4',
            'score' => 'required|integer|min:1',
            'quizze_id' => 'required|exists:quizzes,id',
        ], [
            'title.required' => 'حقل اسم السؤال مطلوب',
            'answers.required' => 'جميع حقول الاجابات مطلوبة',
            'right_answer.required' => 'يجب اختيار الاجابة الصحيحة',
            'score.required' => 'حقل الدرجة مطلوب',
            'quizze_id.required' => 'حقل اسم الاختبار مطلوب',
            'quizze_id.exists' => 'الاختبار المختار غير موجود',
        ]);

        try {
            $question = new Question();
            $question->title = $request->title;
            // نخزن الخيارات مفصولة بفاصل أو كـ JSON
            $question->answers = implode('-', $request->answers);
            // نخزن قيمة الخيار الصحيح (النص نفسه)
            $question->right_answer = $request->answers[$request->right_answer - 1];
            $question->score = $request->score;
            $question->quizze_id = $request->quizze_id;
            $question->save();

            toastr()->success(trans('messages.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function show($id)
    {
        $quizz_id = $id;
        return view('pages.Teachers.dashboard.Questions.create', compact('quizz_id'));
    }


    public function edit($id)
    {
        $question = Question::findorFail($id);
        return view('pages.Teachers.dashboard.Questions.edit', compact('question'));
    }


    public function update(Request $request, $id)
    {
        try {
            $question = Question::findorfail($id);
            $question->title = $request->title;
            $question->answers = $request->answers;
            $question->right_answer = $request->right_answer;
            $question->score = $request->score;
            $question->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function destroy($id)
    {
        try {
            Question::destroy($id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}

<?php

namespace App\Repository;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Quizze;


class QuestionRepository implements QuestionRepositoryInterface
{

    public function index()
    {
        $questions = Question::get();
        return view('pages.Questions.index', compact('questions'));
    }

    public function create(Request $request)
    {
        $quizze_id = $request->quizze_id;
        $quizzes = Quizze::all(); // في حال لم يُرسل quizze_id

        return view('pages.Questions.create', compact('quizze_id', 'quizzes'));
    }

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
            return redirect()->route('Questions.create');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function edit($id)
    {
        $question = Question::findorfail($id);
        $quizzes = Quizze::get();
        return view('pages.Questions.edit',compact('question','quizzes'));
    }

    public function update($request)
    {
        try {
            $question = Question::findorfail($request->id);
            $question->title = $request->title;
            $question->answers = $request->answers;
            $question->right_answer = $request->right_answer;
            $question->score = $request->score;
            $question->quizze_id = $request->quizze_id;
            $question->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Questions.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            Question::destroy($request->id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}

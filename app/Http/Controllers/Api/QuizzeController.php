<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Degree;
use App\Models\Question;
use App\Models\Quizze;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizzeController extends Controller
{
    public function index(Request $request)
    {
        $quizzes = Quizze::where('grade_id', $request->user()->Grade_id)
            ->where('classroom_id', $request->user()->Classroom_id)
            ->where('section_id', $request->user()->section_id)
            ->orderBy('id', 'DESC')
            ->with('subject', 'teacher', 'classroom', 'grade', 'section')
            ->get();

        return response()->json($quizzes);
    }
    public function getQuestions($id)
    {
        $data = [];
        $data['questions'] = Question::where('quizze_id', $id)->get();
        $data['count'] = Question::where('quizze_id', $id)->count();
        return response()->json($data);
    }
    public function answerQuestions(Request $request ,$id)
    {
        $data = $request->data;
        $score = 0 ;
        $degree = new Degree();
        $degree->student_id = Auth::id();
        $degree->quizze_id = $id;
        foreach($data as $answer){
            $q = Question::findOrFail($answer['q_id']);
            $a = $answer['answer'];
            $degree->question_id = $q->id;
            if (strcmp(trim($a), trim($q->right_answer)) === 0) {
                $score += $q->score;
            } else {
                $score += 0;
            }

        }
        $degree->date = date('Y-m-d');
        $degree->score = $score;
        $degree->save();
        return response()->json($score);
    }
}

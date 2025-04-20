<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quizze;
use Illuminate\Http\Request;

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
}

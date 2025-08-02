<?php

namespace App\Repository;

use App\Http\Traits\AttachFilesTrait;
use App\Models\Grade;
use Illuminate\Http\Request;

use App\Models\Library;

class LibraryRepository implements LibraryRepositoryInterface
{

    use AttachFilesTrait;

    public function index()
    {
        $books = Library::all();
        return view('pages.library.index',compact('books'));
    }

    public function create()
    {
        $grades = Grade::all();
        return view('pages.library.create',compact('grades'));
    }


    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file_name' => 'required|mimes:pdf,doc,docx,zip,rar|max:10240', // max 10MB
            'Grade_id' => 'required|exists:grades,id',
            'Classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
        ], [
            'title.required' => 'عنوان الكتاب مطلوب',
            'file_name.required' => 'ملف الكتاب مطلوب',
            'file_name.mimes' => 'يجب أن يكون الملف من نوع: pdf, doc, docx, zip, rar',
            'file_name.max' => 'حجم الملف يجب ألا يتجاوز 10 ميجابايت',
            'Grade_id.required' => 'المرحلة الدراسية مطلوبة',
            'Grade_id.exists' => 'المرحلة غير موجودة',
            'Classroom_id.required' => 'الصف الدراسي مطلوب',
            'Classroom_id.exists' => 'الصف غير موجود',
            'section_id.required' => 'القسم مطلوب',
            'section_id.exists' => 'القسم غير موجود',
        ]);

        try {
            $books = new Library();
            $books->title = $request->title;
            $books->file_name = $request->file('file_name')->getClientOriginalName();
            $books->Grade_id = $request->Grade_id;
            $books->classroom_id = $request->Classroom_id;
            $books->section_id = $request->section_id;
            $books->teacher_id = 1; // يمكن تغييره إلى auth()->user()->id إذا كنت تستخدم التوثيق
            $books->save();

            // رفع الملف
            $this->uploadFile($request, 'file_name');

            toastr()->success(trans('messages.success'));
            return redirect()->route('library.create');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function edit($id)
    {
        $grades = Grade::all();
        $book = library::findorFail($id);
        return view('pages.library.edit',compact('book','grades'));
    }

    public function update($request)
    {
        try {

            $book = library::findorFail($request->id);
            $book->title = $request->title;

            if($request->hasfile('file_name')){

                $this->deleteFile($book->file_name);

                $this->uploadFile($request,'file_name');

                $file_name_new = $request->file('file_name')->getClientOriginalName();
                $book->file_name = $book->file_name !== $file_name_new ? $file_name_new : $book->file_name;
            }

            $book->Grade_id = $request->Grade_id;
            $book->classroom_id = $request->Classroom_id;
            $book->section_id = $request->section_id;
            $book->teacher_id = 1;
            $book->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('library.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        $this->deleteFile($request->file_name);
        library::destroy($request->id);
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('library.index');
    }

    public function download($filename)
    {
        return response()->download(public_path('attachments/library/'.$filename));
    }
}

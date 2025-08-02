<div class="modal fade" id="delete_exam{{$question->id}}" tabindex="-1"
     role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('questions.destroy', 'test') }}" method="post">
            @method('delete')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;"
                        class="modal-title" id="exampleModalLabel">{{ __('questions.delete_question') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('questions.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ __('questions.delete_warning') }} <span class="text-danger">{{ $question->title ?? $question->name }}</span></p>
                    <input type="hidden" name="id" value="{{ $question->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('questions.close') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('questions.submit') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

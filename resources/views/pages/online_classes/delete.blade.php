<!-- Deleted inFormation Student -->
<div class="modal fade" id="Delete_receipt{{$online_classe->meeting_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">{{ __('online_classes.delete_class') }}: {{$online_classe->topic}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('online_classes.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('online_classes.destroy','test')}}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" value="{{$online_classe->id}}">
                    <input type="hidden" name="meeting_id" value="{{$online_classe->meeting_id}}">
                    <h5 style="font-family: 'Cairo', sans-serif;">{{ __('online_classes.delete_confirmation') }}</h5>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('online_classes.close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('online_classes.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Fee Modal -->
<div class="modal fade" id="Delete_Fee{{$fee->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('Fees.delete_fee') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('Fees.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Fees.destroy', 'test') }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" value="{{ $fee->id }}">
                    <h5>{{ trans('Fees.confirm_delete') }}</h5>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('Fees.close') }}</button>
                        <button class="btn btn-danger">{{ trans('Fees.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

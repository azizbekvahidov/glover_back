@if ( $model->multiple ?? false )
    <span class="px-2 py-1 text-sm font-medium text-center text-white bg-green-500 rounded-xl">{{__('Yes')}}</span>
@else
    <span class="px-2 py-1 text-sm font-medium text-center text-white bg-red-500 rounded-xl">{{__('No')}}</span>
@endif

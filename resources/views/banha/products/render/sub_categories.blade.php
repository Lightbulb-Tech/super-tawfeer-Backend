<option value="">{{__("banha.choose")}}</option>
@forelse( $sub_categories as $sub_category)
    <option value="{{$sub_category->id}}">{{$sub_category->title}}</option>
@empty
    <option value="" disabled>{{__("banha.no_sub_category_for_this_main_category")}}</option>
@endforelse

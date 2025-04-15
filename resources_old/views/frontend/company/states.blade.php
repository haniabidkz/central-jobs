
@if(count($states) > 0)
@foreach($states as $key=>$val)
<option value="{{$val['id']}}">{{$val['name']}}</option>
@endforeach
@endif

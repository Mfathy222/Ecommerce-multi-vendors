<input type="{{$type}}" name="{{$name}}" class=" form-control" value="{{old($name,$value)}}"/>
@error('name')
<div class="text-danger">
{{$message}}
</div>
@enderror

@if ($errors->any())
<div class="alert alert-danger">
<h3>Errors</h3>
<ul>
    @foreach ($errors->all as $error )

    <li>
{{$error}}
    </li>
    @endforeach
</ul>
</div>

@endif
<div class=" form-group">
    <label for="">Category Name</label>
 <x-form.input name="name" value="{{$category->name}}" type="text"/>
</div>
<div class=" form-group">
    <label for="">Category Parent</label>
    {{-- <select name="parent_id" class=" form-control form-select">
        <option value="">Primary Category</option>
        @foreach ($parents as $parent)
        <option value="{{$parent->id ?? ''}}" @selected(old('parent_id ', $category->parent_id)==$parent->id ?? '')>{{ $parent->name }}</option>
        @endforeach
    </select> --}}
</div>
<div class=" form-group">
    <label for="">Description</label>
    <textarea type="text" name="description" class=" form-control">{{old('description', $category->description)}}</textarea>
</div>
<div class=" form-group">
    <label for="">image</label>
    <input type="file" name="image" class=" form-control">
    @if ($category->image)
    <td><img src="{{ asset('storage/' . $category->image) }}" alt="" height="50"></td>
    @endif
</div>
<div class="form-group">
    <label for="">Status</label>
</div>
<x-form.radio  name="status" :checked="$category->status" :options="['active'=>'active','archived'=>'archived']" />


<div class=" form-group">
    <button type="submit" class="btn btn-primary">{{$button_lable ?? 'save'}}</button>
</div>

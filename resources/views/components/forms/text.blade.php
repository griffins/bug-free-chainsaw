<div class="mb-3">
    @if(isset($label))
        <label class="form-label">{{ $label }}</label>
    @else
        <label class="form-label">{{ ucwords($field) }}</label>
    @endif
    <input class="form-control{{ $errors->has($field) ? ' is-invalid' : '' }}" name="{{$field}}" type="text"
           placeholder="" value="{{ isset($value) ? $value : old($field) }}"
           @if((isset($required) && $required) || !isset($required) ) required @endif/>
    @if ($errors->has($field))
        <div class="invalid-feedback">{{$errors->first($field)}}</div>
    @endif
</div>
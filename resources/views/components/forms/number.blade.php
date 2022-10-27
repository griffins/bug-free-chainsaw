<div class="d-block mb-3">
    @if(isset($label))
        <label class="form-label">{{ $label }}</label>
    @else
        <label class="form-label">{{ ucwords($field) }}</label>
    @endif
    <div class="form-group{{ $errors->has($field) ? ' has-danger' : '' }}">
        <input class="form-control{{ $errors->has($field) ? ' is-invalid' : '' }}" name="{{$field}}" type="number"
               placeholder="" value="{{ isset($value) ? $value : old($field) }}" required/>
        @if ($errors->has($field))
            <span id="{{$field}}-error" class="error text-danger"
                  for="input-{{$field}}">{{ $errors->first($field) }}</span>
        @endif
    </div>
</div>
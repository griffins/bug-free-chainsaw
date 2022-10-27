<div class="mb-3">
    @if(isset($label))
        <label class="form-label">{{ $label }}</label>
    @else
        <label class="form-label">{{ ucwords($field) }}</label>
    @endif
    <div>
        @foreach($options as $name => $option)
            <label class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="{{ $field }}" id="{{ $field }}-{{ $name }}-radio"
                       value="{{ $option }}"
                       @if( (isset($value) ? $value : old($field)) == $option)
                           checked
                @endif
                @if(is_int($name))
                    <label class="form-check-label" for="{{ $field }}-{{ $name }}-radio"> {{ ucwords($option) }}</label>
                @else
                    <label class="form-check-label" for="{{ $field }}-{{ $name }}-radio"> {{ $name }}</label>
                @endif            </label>
        @endforeach
        @if ($errors->has($field))
            <div class="invalid-feedback">{{$errors->first($field)}}</div>
        @endif
    </div>
</div>
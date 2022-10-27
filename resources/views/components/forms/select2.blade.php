<div class="mb-3">
    @if(isset($label))
        <label class="form-label">{{ $label }}</label>
    @else
        <label class="form-label">{{ ucwords($field) }}</label>
    @endif
    <select class="js-select2 form-control" name="{{ $field }}" id="{{ $field }}-select2" data-placeholder="Choose one..">
        <option></option>
        @foreach($options as $name => $option)
            <option value="{{ $option }}"
                    @if( (isset($value) ? $value : old($field)) == $option)
                        selected
                    @endif
            >@if(is_int($name))
                    {{ ucwords($option) }}
                @else
                    {{ $name }}
                @endif</option>
        @endforeach
    </select>
    @if ($errors->has($field))
        <div class="invalid-feedback">{{$errors->first($field)}}</div>
    @endif
</div>
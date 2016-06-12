<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    <label for="{{ $name }}" class="col-md-4 control-label">{{ $label }}</label>

    <div class="col-md-6">
        <textarea id="{{ $name }}" class="form-control" name="{{$name}}" style="resize: none;">{!! old($name) !!}</textarea>

        @if ($errors->has($name))
            <span class="help-block">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>
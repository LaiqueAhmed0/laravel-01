<div class="form-group">
    <label>{{$label}}</label>
    <input type="{{$type}}" name="{{$name}}" class="form-control form-control-lg form-control-solid" autocomplete="off" value="{{$value ?? ''}}" min="{{!empty($min) ? $min : 0 }}">
    @if (!empty($description))
        <span class="form-text text-muted">{{$description}}</span>
    @endif
</div>

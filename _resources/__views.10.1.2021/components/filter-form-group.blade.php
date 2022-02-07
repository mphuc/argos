<div class="col-xs-12">
    <div class="form-group" {{$attributes}}>        
        <label class="control-label">
            @if (is_array($label))
                @foreach ($label as $word)
                    {{__($word)}}
                @endforeach
            @else    
                {{__($label)}}
            @endif
        </label>

        {{$slot}}
    </div>
</div>
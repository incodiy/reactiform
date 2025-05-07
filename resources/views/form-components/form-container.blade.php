<!-- <div id="form-container">
    <form>
        @foreach($elements as $element)
            @if($element['type'] === 'select')
                <x-select-component :config="$element" />
            @endif
        @endforeach
    </form>
</div> -->

@if(!empty($formConfig))
<form method="{{ $formConfig['method'] }}" 
      action="{{ $formConfig['action'] }}" 
      enctype="{{ $formConfig['enctype'] }}"
      {!! $attributes !!}>
@else
<form>
@endif

    @foreach($elements as $element)
        @switch($element['type'])
            @case('select')
                <x-select-component :config="$element" />
                @break
            @case('text')
                <x-text-component :config="$element" />
                @break
            <!-- tambahkan case lain -->
        @endswitch
    @endforeach

    @if(!empty($buttons))
    <div class="form-actions">
        @foreach($buttons as $button)
            <x-button-component :config="$button" />
        @endforeach
    </div>
    @endif

</form>
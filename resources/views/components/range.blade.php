@once
@push('scripts')
<script type="module">
    import RangeInput from '/js/vendor/reactiform/Components/Form/RangeSlider.jsx';
    window.RangeSliderComponent = (props) => <RangeInput {...props} />;
</script>
@endpush
@endonce

<div data-react-component="RangeSlider" data-props="{{ json_encode($config) }}"></div>
@once
@push('scripts')
<script type="module">
    import MaskedInput from '/js/vendor/reactiform/Components/Form/InputMask.jsx';
    window.InputMaskComponent = (props) => <MaskedInput {...props} />;
</script>
@endpush
@endonce

<div data-react-component="InputMask" data-props="{{ json_encode($config) }}"></div>
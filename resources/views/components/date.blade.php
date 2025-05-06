@once
@push('scripts')
<script type="module">
    import DateInput from '/js/vendor/reactiform/Components/Form/DatePicker.jsx';
    window.DatePickerComponent = (props) => <DateInput {...props} />;
</script>
@endpush
@endonce

<div data-react-component="DatePicker" data-props="{{ json_encode($config) }}"></div>
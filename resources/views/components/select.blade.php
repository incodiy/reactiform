@once
    @push('scripts')
        <script type="module">
            import Select from '/js/vendor/reactiform/Components/Form/Select.jsx';
            window.SelectComponent = (props) => <Select {...props} />;
        </script>
    @endpush
@endonce

<div data-react-component="Select" data-props="{{ json_encode($config) }}"></div>
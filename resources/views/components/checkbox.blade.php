@once
    @push('scripts')
        <script type="module">
            import CheckboxGroup from '/js/vendor/reactiform/Components/Form/CheckboxGroup.jsx';
            window.CheckboxGroupComponent = (props) => <CheckboxGroup {...props} />;
        </script>
    @endpush
@endonce

<div data-react-component="CheckboxGroup" data-props="{{ json_encode($config) }}"></div>
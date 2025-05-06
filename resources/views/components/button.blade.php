@once
    @push('scripts')
        <script type="module">
            import Button from '/js/vendor/reactiform/Components/Form/Button.jsx';
            window.ButtonComponent = (props) => <Button {...props} />;
        </script>
    @endpush
@endonce

<div data-react-component="Button" data-props="{{ json_encode($config) }}"></div>
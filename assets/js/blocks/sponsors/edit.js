const { RadioControl, ServerSideRender, PanelBody, TextControl, SelectControl } = wp.components;
const { __ } = wp.i18n;
const { Fragment, Component } = wp.element;
const { InspectorControls } = wp.editor;
const apiFetch = wp.apiFetch;


export default class Edit extends Component {
    constructor( props ) {
        super( ...props );
        this.props = props;
        this.state = {
            displayOption: props.attributes.content !== 'all' && props.attributes.content !== 'current' ? 'other' : this.props.attributes.content,
            content: [],
            type: props.attributes.type && props.attributes.all !== '1' ? props.attributes.type : '',
            loading: false,
            categories: []
        }

        this.get_categories = this.get_categories.bind(this);
    }

    componentDidMount() {
        this.get_categories();
    }

    get_categories() {
        var self = this;
        fetch( wp_sponsors_blocks.ajax, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
            },
            body: 'action=wp_sponsors_get_categories&nonce=' + wp_sponsors_blocks.nonce,
            credentials: 'same-origin'
        }).then(function (res) {
            return res.json();
        }).then(function (res) {
            if ( res.success ) {
                self.setState({ categories: res.data })
            }
        });
    } 

    render() {
        let categories = [{ label: __( 'Select a Package' ), value: 0 }]
        let image_sizes = [];
        const { type, loading } = this.state;
        const { attributes, setAttributes } = this.props;
        
        if ( wp_sponsors_blocks.image_sizes && wp_sponsors_blocks.image_sizes.length ) {
            for( var i = 0; i < wp_sponsors_blocks.image_sizes.length; i++ ) {
                image_sizes.push({
                    label: wp_sponsors_blocks.image_sizes[i],
                    value: wp_sponsors_blocks.image_sizes[i]
                })
            }
        }

        if ( this.state.categories.length ) {
            categories = categories.concat(this.state.categories.map(( cat ) => {
                    return { label: cat.name, value: cat.slug }
                }));
        } else {
            categories = [];
        }

        return (
            <Fragment>
                <InspectorControls>
                    <PanelBody
                        title={ __( 'Display Options' ) }
                        initialOpen={ true } >
                        <RadioControl
                            label={ __( 'Show Logo' ) }
                            options={
                                [
                                    { label: __( 'No' ), value: '0' },
                                    { label: __( 'Yes' ), value: '1' }
                                ]
                            }
                            selected={ attributes.images }
                            onChange={ ( value ) => {

                                setAttributes({ images: value });

                            }}
                            />
                        <RadioControl
                            label={ __( 'Logo size' ) }
                            options={ image_sizes }
                            selected={ attributes.image_size }
                            onChange={ ( value ) => {

                                setAttributes({ image_size: value });

                            }}
                            />
                        <RadioControl
                            label={ __( 'Show Title' ) }
                            options={
                                [
                                    { label: __( 'No' ), value: '0' },
                                    { label: __( 'Yes' ), value: '1' }
                                ]
                            }
                            selected={ attributes.title }
                            onChange={ ( value ) => {

                                setAttributes({ title: value });

                            }}
                            />
                        <RadioControl
                            label={ __( 'Show Description' ) }
                            options={
                                [
                                    { label: __( 'No' ), value: '0' },
                                    { label: __( 'Yes' ), value: '1' }
                                ]
                            }
                            selected={ attributes.description }
                            onChange={ ( value ) => {

                                setAttributes({ description: value });

                            }}
                        />
                        <RadioControl
                            label={ __( 'Layout' ) }
                            options={
                                [
                                    { label: __( 'List' ), value: 'list' },
                                    { label: __( 'Grid' ), value: 'grid' }
                                ]
                            }
                            selected={ attributes.style }
                            onChange={ ( value ) => {

                                setAttributes({ style: value });

                            }}
                        />
                        <TextControl
                            label={ __( 'Max Number' ) }
                            value={ attributes.max }
                            onChange={ ( value ) => {

                                setAttributes({ max: value });

                            }}
                        />
                    </PanelBody>
                    <PanelBody
                        title={ __( 'Categories' ) }
                        initialOpen={ false }>
                        <SelectControl
                            label={ __( 'Show Sponsors under a Category' ) }
                            value={ attributes.category }
                            options={ categories }
                            onChange={ ( value ) => {

                                setAttributes({ category: value });

                            }}
                        />
                        <RadioControl
                            label={ __( 'Show with Categories' ) }
                            options={
                                [
                                    { label: __( 'No' ), value: '0' },
                                    { label: __( 'Yes' ), value: '1' }
                                ]
                            }
                            selected={ attributes.with_categories }
                            onChange={ ( value ) => {

                                setAttributes({ with_categories: value });

                            }}
                        />
                    </PanelBody>
            </InspectorControls>

            <ServerSideRender
                block="wp-sponsors/sponsors"
                attributes={ attributes }
            />
        </Fragment>);
    }
}
const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;
import SponsorsEdit from './edit';

registerBlockType( 'wp-sponsors/sponsors', {
    title:  __( 'Sponsors' ),
    description: __( 'Display Sponsors' ),
    icon: 'format-image',
    category: 'wp-sponsors',
    attributes: {
        category_title: {
            type: 'string',
            default: 'h3'
        },
        size: {
            type: 'string',
            default: 'default'
        },
        image_size: {
            type: 'string',
            default: 'medium'
        },
        images: {
            type: 'string',
            default: '1'
        },
        style: {
            type: 'string',
            default: 'list'
        },
        with_categories: {
            type: 'string',
            default: '0'
        },
        category: {
            type: 'string',
            default: ''
        },
        description: {
            type: 'string',
            default: '0'
        },
        title: {
            type: 'string',
            default: '0'
        },
        max: {
            type: 'string',
            default: '-1'
        },
        adaptiveheight: {
            type: 'string',
            default: '1'
        },
        autoplay: {
            type: 'string',
            default: '1'
        },
        autoplayspeed: {
            type: 'string',
            default: '3000'
        },
        arrows: {
            type: 'string',
            default: '1'
        },
        centermode: {
            type: 'string',
            default: '0'
        },
        dots: {
            type: 'string',
            default: '0'
        },
        infinite: {
            type: 'string',
            default: '1'
        },
        slidestoshow: {
            type: 'string',
            default: '1'
        },
        slidestoscroll: {
            type: 'string',
            default: '1'
        },
        verticalcenter: {
            type: 'string',
            default: '1'
        }
    },
    edit: SponsorsEdit,
    save() {
        return null;
    }
});
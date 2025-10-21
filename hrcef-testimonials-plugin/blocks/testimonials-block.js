(function(blocks, element, blockEditor, components) {
    var el = element.createElement;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody = components.PanelBody;
    var RangeControl = components.RangeControl;
    var ServerSideRender = wp.serverSideRender;

    blocks.registerBlockType('hrcef/testimonials', {
        title: 'HRCEF Testimonials',
        icon: 'format-quote',
        category: 'widgets',
        attributes: {
            count: {
                type: 'number',
                default: 3
            }
        },
        
        edit: function(props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            
            return [
                el(InspectorControls, {},
                    el(PanelBody, { title: 'Testimonials Settings', initialOpen: true },
                        el(RangeControl, {
                            label: 'Number of Testimonials',
                            value: attributes.count,
                            onChange: function(value) {
                                setAttributes({ count: value });
                            },
                            min: 1,
                            max: 6
                        })
                    )
                ),
                el('div', { className: 'hrcef-testimonials-editor' },
                    el(ServerSideRender, {
                        block: 'hrcef/testimonials',
                        attributes: attributes
                    })
                )
            ];
        },
        
        save: function() {
            // Server-side rendering
            return null;
        }
    });
})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.components
);

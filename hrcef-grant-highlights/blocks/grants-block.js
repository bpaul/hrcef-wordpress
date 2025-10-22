(function(blocks, element, blockEditor, components, serverSideRender) {
    var el = element.createElement;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody = components.PanelBody;
    var RangeControl = components.RangeControl;
    var ServerSideRender = serverSideRender;
    
    blocks.registerBlockType('hrcef/grant-highlights', {
        title: 'Grant Highlights',
        icon: 'awards',
        category: 'widgets',
        supports: {
            align: ['wide', 'full'],
            alignWide: true
        },
        attributes: {
            cardCount: {
                type: 'number',
                default: 3
            },
            align: {
                type: 'string',
                default: 'full'
            }
        },
        getEditWrapperProps: function(attributes) {
            return { 'data-align': attributes.align };
        },
        
        edit: function(props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            
            return el(
                'div',
                {},
                el(
                    InspectorControls,
                    {},
                    el(
                        PanelBody,
                        { title: 'Grant Highlights Settings', initialOpen: true },
                        el(RangeControl, {
                            label: 'Number of Cards',
                            value: attributes.cardCount,
                            onChange: function(value) {
                                setAttributes({ cardCount: value });
                            },
                            min: 1,
                            max: 6
                        })
                    )
                ),
                el('div', { className: 'hrcef-grants-editor' },
                    el(ServerSideRender, {
                        block: 'hrcef/grant-highlights',
                        attributes: {
                            cardCount: attributes.cardCount
                        }
                    })
                )
            );
        },
        
        save: function() {
            return null; // Rendered via PHP
        }
    });
})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.components,
    window.wp.serverSideRender
);

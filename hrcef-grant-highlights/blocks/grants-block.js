(function(blocks, element, blockEditor, components, serverSideRender, data) {
    var el = element.createElement;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody = components.PanelBody;
    var RangeControl = components.RangeControl;
    var CheckboxControl = components.CheckboxControl;
    var ServerSideRender = serverSideRender;
    var useSelect = data.useSelect;
    
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
            },
            selectedTags: {
                type: 'array',
                default: []
            }
        },
        getEditWrapperProps: function(attributes) {
            return { 'data-align': attributes.align };
        },
        
        edit: function(props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            
            // Get all grant tags
            var tags = useSelect(function(select) {
                return select('core').getEntityRecords('taxonomy', 'hrcef_grant_tag', { per_page: -1 });
            }, []);
            
            // Handle tag toggle
            function toggleTag(tagId) {
                var selectedTags = attributes.selectedTags || [];
                var index = selectedTags.indexOf(tagId);
                var newTags;
                
                if (index > -1) {
                    newTags = selectedTags.filter(function(id) { return id !== tagId; });
                } else {
                    newTags = selectedTags.concat([tagId]);
                }
                
                setAttributes({ selectedTags: newTags });
            }
            
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
                    ),
                    el(PanelBody, { title: 'Filter by Tags', initialOpen: false },
                        el('p', { style: { marginBottom: '12px', color: '#666' } },
                            'Select tags to filter grants. Leave empty to show all.'
                        ),
                        tags && tags.length > 0 ? tags.map(function(tag) {
                            return el(CheckboxControl, {
                                key: tag.id,
                                label: tag.name,
                                checked: (attributes.selectedTags || []).indexOf(tag.id) > -1,
                                onChange: function() {
                                    toggleTag(tag.id);
                                }
                            });
                        }) : el('p', {}, 'No tags available. Create tags in the Grant Highlights menu.')
                    )
                ),
                el('div', { className: 'hrcef-grants-editor' },
                    el(ServerSideRender, {
                        block: 'hrcef/grant-highlights',
                        attributes: {
                            cardCount: attributes.cardCount,
                            selectedTags: attributes.selectedTags
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
    window.wp.serverSideRender,
    window.wp.data
);

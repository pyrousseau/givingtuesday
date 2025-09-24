(function (blocks, element) {
    let el = element.createElement;

    blocks.registerBlockType('grs-block/grs-gallery', {
        title: 'Limb Gallery',
        icon: el(
            'img',
            {
                src: grsBlockMiniIcon
            }
        ),
        category: 'common',
        attributes: {
            id: {
                default: 0
                // type: 'number'
            },
            timestamp: {
                default: 0
                // type: 'number'
            }
        },
        edit: function (props) {

            if (typeof window.grsShortcodes === 'undefined') {
                window.grsShortcodes = {}
            }

            if (typeof window.grsShortcodes[props.clientId] === 'undefined') {
                window.grsShortcodes[props.clientId] = props.setAttributes;
                // Open iframe while inserting grs block first time
                if (props.attributes.id === 0 && props.attributes.timestamp === 0) {
                    // Set tmp attr value in order to mark this as not selected gallery
                    props.attributes.id = -1;

                    // Start hide some sections
                    hideCoupleWpSections();

                    return el('div', {}, [
                        el('div', {
                                class: 'grs-block-iframe-wrapper',
                                'data-block-id': props.clientId,
                                id: 'grs-block-iframe-shortcode-popup-' + props.clientId
                            }, [
                                el('div', {
                                        class: 'grs-block-iframe-container'
                                    }, [
                                        el('div', {
                                                class: 'grs-block-iframe-shortcode-popup-close-container'
                                            }, [
                                                el(
                                                    'button',
                                                    {},
                                                    [
                                                        el(
                                                            'span',
                                                            {}
                                                        )
                                                    ]
                                                )
                                            ]
                                        ),
                                        el(
                                            'iframe',
                                            {
                                                id: 'grs-block-iframe-shortcode-popup-' + props.clientId,
                                                src: window.grsAdminShortCode + '&grs_block_id=' + props.clientId + '&gutenberg=1&data=' + JSON.stringify(props.attributes),
                                                class: 'grs-block-iframe'
                                            }
                                        )
                                    ]
                                )
                            ]
                        ),
                        el(
                            'img',
                            {
                                src: grsBlockIcon,
                                class: 'grs-block-image',
                                onClick: function (e) {
                                    grsOpenPopup(props)
                                }
                            }
                        )
                    ]);
                } else {
                    if (props.attributes.id === -1) {
                        return el(
                            'p',
                            {
                                class: 'grs-block-paragraph',
                                onClick: function (e) {
                                    grsOpenPopup(props)
                                }
                            },
                            'Nothing selected' //TODO add this line to localizations
                        );
                    }
                }
            }

            if (props.attributes.id !== -1) {
                return el(
                    'img',
                    {
                        src: grsBlockIcon,
                        class: 'grs-block-image',
                        onClick: function (e) {
                            grsOpenPopup(props)
                        }
                    }
                );
            } else {
                return el(
                    'p',
                    {
                        class: 'grs-block-paragraph',
                        onClick: function (e) {
                            grsOpenPopup(props)
                        }
                    },
                    'Nothing selected' //TODO add this line to localizations
                );
            }
        },
        save: function (props) {
            return null;
        }
    });

    function grsOpenPopup(props) {
        // Start hide some sections
        hideCoupleWpSections();
        let task = props.attributes.id !== 0 ? 'update' : '';
        let blockElement = jQuery("[data-block=" + props.clientId + "]");
        // Load iframe with proper styles
        let iframeUrl = window.grsAdminShortCode + '&grs_block_id=' + props.clientId + '&gutenberg=1&task=' + task + '&data=' + JSON.stringify(props.attributes);
        let iframe = '<div ' +
            'id="grs-block-iframe-shortcode-popup-' + props.clientId + '" ' +
            'data-block-id="' + props.clientId + '" ' +
            'class="grs-block-iframe-wrapper" >' +
            '<div class="grs-block-iframe-container">' +
            '<div class="grs-block-iframe-shortcode-popup-close-container">' +
            '<button>' +
            '<span></span>' +
            '</button>' +
            '</div>' +
            '<iframe class="grs-block-iframe" src="' + encodeURI(iframeUrl) + '"></iframe>' +
            '</div>' +
            '</div>';
        blockElement.append(iframe);
    }

    function hideCoupleWpSections() {
        jQuery('#adminmenuback').css('z-index', '0');
        jQuery('#adminmenuwrap').css('z-index', '0');
        jQuery('.edit-post-header').css('z-index', '0');
    }

    function showCoupleWpSections() {
        jQuery('#adminmenuback').css('z-index', '');
        jQuery('#adminmenuwrap').css('z-index', '');
        jQuery('.edit-post-header').css('z-index', '');
    }

    window.grsCloseShortCodePopup = function (bl) {
        // Show previously hidden wp sections
        showCoupleWpSections();
        jQuery('#grs-block-iframe-shortcode-popup-' + bl).remove();
    };

    // Close iframe block popup by clicking on x
    jQuery('body').on('click', '.grs-block-iframe-shortcode-popup-close-container > button', function (e) {
        grsCloseShortCodePopup(jQuery(this).parent().parent().parent().attr('data-block-id'));
    })

}(
    window.wp.blocks,
    window.wp.element
));


/*   */
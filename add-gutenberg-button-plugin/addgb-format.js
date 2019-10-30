(function ( wp ) {
    var lqdNotesButton = function( props ) {
        return wp.element.createElement(
            wp.blockEditor.RichTextToolbarButton, {
                icon: 'editor-code',
                title: 'Blank It',
                onClick: function () {
                    props.onChange( wp.richText.toggleFormat(
                        props.value,
                        { type: 'lqdnotes/blankit' }
                    ));
                },
            }
        );
    };

    wp.richText.registerFormatType(
        'lqdnotes/blankit', {
            title: 'Blank It',
            tagName: 'span',
            className: 'lqdnotes-blank-it',
            edit: lqdNotesButton,
        }
        );
} )( window.wp );
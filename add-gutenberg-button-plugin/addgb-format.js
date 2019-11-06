// TODO: Written in ES5 to avoid build process, change to ES6
(function ( wp ) {
    // Create our button.
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

    // What the button does
    wp.richText.registerFormatType(
        'lqdnotes/blankit', {
            title: 'Blank It',
            tagName: 'input',
            className: 'lqdnotes-blank-it',
            id: lqdNotesButton,
            edit: lqdNotesButton,
        }
    );
} )( window.wp );
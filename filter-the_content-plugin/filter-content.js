document.addEventListener( 'DOMContentLoaded', function () {
    // Get the elements to be replaced
    let blankElements = Array.from(document.getElementsByClassName("lqdnotes-blank-it"));

    // Iterate through instances of the element to be replaced
    blankElements.forEach( blankElement => {
        // Get the text we'll use as ID for new element
        let blankID = blankElement.innerHTML;
        // Create variable to hold input text box code
        let inputText = '<input type="text" id="' + blankID + '" class="lqdnotes-blank-input">';
        // Set the outerHTML to our input text box.
        blankElement.outerHTML = inputText;
    });
} );

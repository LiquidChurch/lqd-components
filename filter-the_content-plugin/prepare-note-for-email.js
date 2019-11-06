// When someone has clicked the submit button we need to convert their input back into regular text.
function prepareNotes() {
    // Get the input boxes we'll be replacing
    let filledElements = Array.from(document.getElementsByClassName( "lqdnotes-blank-input") );

    // Iterate through instances of input box
    filledElements.forEach( filledElement => {
        // Get input text we'll convert to regular text.
        let inputText = filledElement.value;

        // Create variable to hold span code
        let spanText = '<span class="lqdnotes-filled">' + inputText + '</span>';

        // Set the outerHTML to our span.
        filledElement.outerHTML = spanText;
    });

}

function passNotes() {
    let notesToPass = document.getElementsByClassName("type-post").innerHTML;
    let emailContent = "";
    notesToPass.forEach(note => {
        let printNote = note.outerHTML;
        emailContent += printNote;
    })
};

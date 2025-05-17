/**
 * Scratchpad.js - client-side scratchpad functionality.
 * 
 */

function setEventHandlers() {
    let element = document.getElementById("new-scratchpad");
    if (element) {
        element.addEventListener("click", function() {
            const currentPage = new URL(window.location.href);
            currentPage.searchParams.set("action", "new");
            currentPage.searchParams.delete("id");
            window.location.href = currentPage.toString();
        });
    }
}

function loadScratchpadDraft(scratchpadId) {
    const currentPage = new URL(window.location.href);
    currentPage.searchParams.set("action", "edit");
    currentPage.searchParams.set("id", scratchpadId);
    window.location.href = currentPage.toString();
}

setEventHandlers();


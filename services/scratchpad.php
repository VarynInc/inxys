<?php /** Helper functions for the scratchpad.
 * Scratchpad requires a logged in user.
 */

/**
 * Render a list of the users draft scratchpads.
 */
function listScratchpads() {
    global $enginesis;
    $scratchpadList = $enginesis->userScratchpadList();
    if (is_null($scratchpadList)) {
        $lastError = $enginesis->getLastError();
        echo("<p>Error getting your drafts: $lastError->message $lastError->extended_info.</p>");
    } elseif (count($scratchpadList) == 0) {
        echo("<p>No drafts have been saved.</p>");
    } else {
        echo('<h3>Drafts</h3><ul>');
        forEach($scratchpadList as $draft) {
            $date = $draft->date_updated == null ? $draft->date_created : $draft->date_updated;
            echo('<li class="clickable" onclick="loadScratchpadDraft(' . $draft->user_scratchpad_id . ')">' . MySQLDateToHumanDate($date) . ': ' . $draft->label . ' (' . $draft->scratchpad_text_length . ' chars)</li>');
        }
        echo('</ul>');
    }
}

/**
 * Render an information or error message only if the message is not empty.
 */
function showInformationMessage($message, $class) {
    if ( ! empty($message)) {
        echo("<p class=\"$class\">$message</p>");
    }
}

/**
 * Get the requested scratchpad.
 */
function getScratchpad($scratchpadId, & $title, & $tags, & $content, & $sortOrder) {
    global $enginesis;
    $errorCode = EnginesisErrors::NO_ERROR;
    $serverResponse = $enginesis->userScratchpadGet($scratchpadId);
    if (is_array($serverResponse) && count($serverResponse) > 0) {
        $draft = $serverResponse[0];
        $title = $draft->label;
        $tags = $draft->tags;
        $content = $draft->scratchpad_text;
        $sortOrder = $draft->sort_order;
    } else {
        // var_dump($serverResponse);
        $errorCode = $enginesis->getLastError();
        // var_dump($errorCode);
    }
    return $errorCode;
}

/**
 * Create a new scratchpad draft and return the new scratchpad id.
 */
function createScratchpad($title, $tags, $content, & $scratchpadId) {
    global $enginesis;
    $errorCode = EnginesisErrors::NO_ERROR;
    $shardId = 'A';
    // verify all inputs are valid and safe:
        // title: markdown
        // sharedId:string
        // tags: string => array, break on / and ;
        // content: string, markdown
    // call API, report results
    $serverResponse = $enginesis->userScratchpadCreate($title, $shardId, $tags, 0, $content);
    $error = $enginesis->getLastError();
    if ($error['success'] == 1) {
        // var_dump(['createScratchpad', $serverResponse]);
        $scratchpadId = $serverResponse[0]->user_scratchpad_id;
        $sortOrder = $serverResponse[0]->sort_order;
    } else {
        // var_dump($error);
        $errorCode = $error['message'];
        $scratchpadId = 0;
    }
    return $errorCode;
}

/**
 * Update an existing scratchpad.
 */
function updateScratchpad($scratchpadId, $title, $tags, $sortOrder, $content) {
    global $enginesis;
    $errorCode = EnginesisErrors::NO_ERROR;
    $shardId = 'A';
    // verify all inputs are valid and safe:
        // title: markdown
        // sharedId:string
        // tags: string => array, break on / and ;
        // content: string, markdown
    // call API, report results
    $serverResponse = $enginesis->userScratchpadUpdate($scratchpadId, $title, $shardId, $tags, $sortOrder, $content);
    // var_dump(['updateScratchpad', $scratchpadId, $serverResponse]);
    $errorCode = $enginesis->getLastError();
    // var_dump($errorCode);
    $errorCode = EnginesisErrors::CANNOT_COMMENT_YOURSELF;
    return $errorCode;
}

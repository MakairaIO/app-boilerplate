let PAGE_DATA = null
let COMPONENTS_DATA = null

/**
 * Send a "request" to the makaira backend with the
 * <a href="https://developer.mozilla.org/en-US/docs/Web/API/Window/postMessage">postMessage function</a>
 * to get the JWT-Token of the current user.
 */
function requestUserFromMakairaBackend() {
    const message = {
        // ## Attention ##
        // In difference to "normal" apps you have to provide here
        // the source "makaira-content-widget-{YOU_APP_SLUG}" instead
        // of "makaira-app-{YOU_APP_SLUG}".
        "source": "makaira-content-widget-example-app", // replace with makaira-content-widget-{YOU_APP_SLUG}
        "action": "requestUser", "hmac": HMAC, "nonce": NONCE, "makairaHmac": MAKAIRA_HMAC
    }

    window.parent.postMessage(message, document.referrer)
}

/**
 * Handler for the message listener.
 *
 * @param event{MessageEvent}
 */
function handleOnMessage(event) {
    const {source, action, data, message} = event.data

    // Check that the message came from the makaira backend
    // ## Attention ##
    // In difference to "normal" apps you have to check here for
    // the source "makaira-content-widget-bridge" instead
    // of "makaira-app-bridge".
    if (source !== "makaira-content-widget-bridge") {
        return
    }
    // Check that the response came from a makaira domain. https://*.makaira.io
    // if (event.origin.match("https:\\/\\/([a-zA-Z])+\\.makaira\\.io")?.index !== 0) return

    if (action === "responseUserRequest") {
        console.log('Received JWT token')

        const parsedToken = parseJWT(data.token)

        document.getElementById("makaira-user").innerText = parsedToken.email
        document.getElementById("makaira-role").innerText = parsedToken["https://makaira.io/roles"]

        return
    }

    if (action === 'receivePageInformation') {
        console.log('Received updated page data')
        console.log({data})

        PAGE_DATA = data.page
        COMPONENTS_DATA = data.components
    }
}

/**
 *
 * @param key {('config' | 'metadata' | 'seoUrls' | 'active' | 'internalTitle', | 'searchable')}
 *        Part of the page that you want to update.
 * @param updatedData {object} Updated data of this part. Remember to send all data (of the part you want to update)
 *        back that you received from Makaira.
 */
function sendUpdatedDataToMakaira(updatedData, key) {
    const message = {
        "source": "makaira-content-widget-example-app", // replace with makaira-content-widget-{YOU_APP_SLUG}
        "action": "updatePageInformation", "data": {
            "key": key, // see: https://stackoverflow.com/questions/42376464/uncaught-domexception-failed-to-execute-postmessage-on-window-an-object-co
            "value": JSON.parse(JSON.stringify(updatedData))
        }
    }

    window.parent.postMessage(message, document.referrer)
}

function sendExampleDataToPageEditor() {
    // If you haven't received any data from the Page-Editor you should not send any data back.
    // Otherwise, you could risk broken page data in the Page-Editor.
    if (!PAGE_DATA) {
        console.error('No data has been received from Makaira.')
        return
    }

    const metaData = {...PAGE_DATA.metadata}

    if (metaData.de)
        metaData.de.description = 'Dies ist eine zufällige Beschreibung, welche von einem Content-Widget geschickt wurde.'
    if (metaData.en)
        metaData.en.description = 'This is a random description that was sent from a content widget.'

    sendUpdatedDataToMakaira(metaData, 'metadata')
}

/**
 * Decodes a JWT token into an object.
 * @param token{string} JWT-token
 * @returns {object} Decoded token.
 */
function parseJWT(token) {
    const base64Url = token.split('.')[1];
    const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    const jsonPayload = decodeURIComponent(window.atob(base64).split('').map(function (c) {
        return '%' +
            (
                '00' + c.charCodeAt(0).toString(16)
            ).slice(-2);
    }).join(''));

    return JSON.parse(jsonPayload);
}

document.addEventListener("DOMContentLoaded", () => {
    window.addEventListener("message", handleOnMessage)

    requestUserFromMakairaBackend()

    document.getElementById('example-button')
        .addEventListener('click', sendExampleDataToPageEditor)
})

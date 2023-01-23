let PAGE_DATA = null
let COMPONENTS_DATA = null

/**
 * Handler for the message listener.
 *
 * @param event{MessageEvent}
 */
function handleOnMessage(event) {
    const {source, action, data, message} = event.data

    // Check that the message came from the makaira backend
    if (source !== "makaira-content-widget-bridge") return
    // Check that the response came from a makaira domain. https://*.makaira.io
    // if (event.origin.match("https:\\/\\/([a-zA-Z])+\\.makaira\\.io")?.index !== 0) return

    if (action === 'sendPageInformation') {
        console.log('Received updated page data')
        console.log({data})

        PAGE_DATA = data.page
        COMPONENTS_DATA = data.components
    }
}

/**
 *
 * @param key {('config' | 'metadata' | 'seoUrls' | 'active' | 'internalTitle')}
 *        Part of the page that you want to update.
 * @param updatedData {object} Updated data of this part. Remember to send all data (of the part you want to update)
 *        back that you received from Makaira.
 */
function sendUpdatedDataToMakaira(updatedData, key) {
    console.log(updatedData, key)

    const message = {
        "source": "makaira-content-widget-example-app", // replace with makaira-content-widget-{YOU_APP_SLUG}
        "action": "updatePageInformation",
        "data": {
            "key": key,
            // see: https://stackoverflow.com/questions/42376464/uncaught-domexception-failed-to-execute-postmessage-on-window-an-object-co
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

    const metaData = { ...PAGE_DATA.metadata }

    metaData.de.description = 'Dies ist eine zufällige Beschreibung, welche von einem Content-Widget geschickt wurde.'
    metaData.en.description = 'This is a random description that was sent from a content widget.'

    sendUpdatedDataToMakaira(metaData, 'metadata')
}

document.addEventListener("DOMContentLoaded", () => {
    window.addEventListener("message", handleOnMessage)

    document.getElementById('example-button')
        .addEventListener('click', sendExampleDataToPageEditor)
})

function requestUserFromMakairaBackend() {
    window.parent.postMessage({ "source": "makaira-boilerplate-app", "action": "requestUser" }, document.referrer)

    window.addEventListener("message", handleOnMessage)
}

function handleOnMessage(event) {
    const { source, action, data } = event.data

    console.log(event)

    if (source !== "makaira-app-bridge") return
    if (!event.origin.includes("http://localhost")) return

    if (action === "responseUserRequest") {
        const parsedToken = parseJWT(data.token)

        document.getElementById("user-mail").innerText = parsedToken.email
    }
}

function parseJWT(token) {
    const base64Url = token.split('.')[1];
    const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    const jsonPayload = decodeURIComponent(window.atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));

    return JSON.parse(jsonPayload);
}

requestUserFromMakairaBackend()
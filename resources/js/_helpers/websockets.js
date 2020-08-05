export const ws = {
    connect(protocol, hostname, port) {
        const url = protocol + "://" + hostname + ":" + port;
        const timeout = 7000;

        try {
            const socket = new WebSocket(url);

            const timer = setTimeout(function() {
                done();
                socket.close();
            }, timeout);

            function done() {
                clearTimeout(timer);
                socket.removeEventListener('error', error);
            }

            function error(e) {
                done();
            }

            socket.addEventListener('open', function() {
                done();
            });

            socket.addEventListener('error', error);

            return socket;

        } catch (exception) {

            console.error(exception);
        }
    },
    bindEvents({dispatch, commit}, actions, ws){
        ws.onerror = error => actions.errorHandler({dispatch, commit}, error);
        ws.onopen = data => actions.openHandler({dispatch, commit}, data);
        ws.onclose = data => actions.closeHandler({dispatch, commit}, data);
        ws.onmessage = message => actions.messageHandler({dispatch, commit}, message.data);
    },
    getExceptionMessage(code)
    {
        let message = "";

        if (code == 1000)
            message = "Successful operation / regular socket shutdown";
        else if(code == 1001)
            message = "An endpoint is \"going away\", such as a server going down or a browser having navigated away from a page.";
        else if(code == 1002)
            message = "An endpoint is terminating the connection due to a protocol error";
        else if(code == 1003)
            message = "An endpoint is terminating the connection because it has received a type of data it cannot accept (e.g., an endpoint that understands only text data MAY send this if it receives a binary message).";
        else if(code == 1004)
            message = "Reserved. The specific meaning might be defined in the future.";
        else if(code == 1005)
            message = "No status code was actually present.";
        else if(code == 1006)
            message = "No close code frame has been receieved";
        else if(code == 1007)
            message = "An endpoint is terminating the connection because it has received data within a message that was not consistent with the type of the message (e.g., non-UTF-8 [http://tools.ietf.org/html/rfc3629] data within a text message).";
        else if(code == 1008)
            message = "An endpoint is terminating the connection because it has received a message that \"violates its policy\". This message is given either if there is no other sutible message, or if there is a need to hide specific details about the policy.";
        else if(code == 1009)
            message = "An endpoint is terminating the connection because it has received a message that is too big for it to process.";
        else if(code == 1010)
            message = "An endpoint (client) is terminating the connection because it has expected the server to negotiate one or more extension, but the server didn't return them in the response message of the WebSocket handshake.";
        else if(code == 1011)
            message = "A server is terminating the connection because it encountered an unexpected condition that prevented it from fulfilling the request.";
        else if(code == 1015)
            message = "The connection was closed due to a failure to perform a TLS handshake (e.g., the server certificate can't be verified).";
        else
            message = "Unknown message";

        return message;
    }
}


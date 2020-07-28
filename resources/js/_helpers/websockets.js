export const ws = {
    connect(protocol, hostname, port) {
        const webSocketURL = protocol + "://" + hostname + ":" + port;
        // console.log("openWSConnection::Connecting to: " + webSocketURL);

        try {
            return new WebSocket(webSocketURL);

            // return this.ws;
            // this.ws.webSocket.onopen = function(openEvent) {
            //     console.log("WebSocket OPEN: " + JSON.stringify(openEvent, null, 4));
            // };
            // this.ws.webSocket.onclose = function (closeEvent) {
            //     console.log("WebSocket CLOSE: " + JSON.stringify(closeEvent, null, 4));
            // };
            // this.ws.webSocket.onerror = function (errorEvent) {
            //     console.log("WebSocket ERROR: " + JSON.stringify(errorEvent, null, 4));
            // };
            // this.ws.webSocket.onmessage = function (messageEvent) {
            //     return messageEvent.data;
            // };
        } catch (exception) {
            console.error(exception);
        }
    },
    bindEvents({dispatch, commit}, actions, ws){
        ws.onerror = error => actions.errorHandler({dispatch, commit}, error);
        ws.onopen = data => actions.openHandler({dispatch, commit}, data);
        ws.onclose = data => actions.closeHandler({dispatch, commit}, data);
        ws.onmessage = message => actions.messageHandler({dispatch, commit}, message);
    },
    openEvent(){

        console.log(this);
        this.onopen = function(openEvent) {
            // console.log("WebSocket OPEN: " + JSON.stringify(openEvent, null, 4));
        };
    },
    closeEvent(ws){
        ws.onclose = function (closeEvent) {
            // console.log("WebSocket CLOSE: " + JSON.stringify(closeEvent, null, 4));
        };
    },
    errorEvent(ws){
        ws.onerror = function (errorEvent) {
            // console.log("WebSocket ERROR: " + JSON.stringify(errorEvent, null, 4));
            return errorEvent;
        };
    },
    messageEvent(ws){
        ws.onmessage = function (messageEvent) {
            return messageEvent.data;
        };
    },
    socketMessage(message) {

        let msg = message != null ? message : this.ws.message;

        this.ws.webSocket.send(msg);
    },
}


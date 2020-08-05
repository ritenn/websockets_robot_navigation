import { ws } from '../_helpers/websockets';

const state = {
    ws: {},
    protocol: "ws",
    hostname: "",
    port: 80,
    message: "",
    connected: false,
    connecting: false,
}

const actions = {
    setConnection({dispatch, commit}, data) {
        commit('connectionData', data);
    },
    wsConnect({ dispatch, commit }) {
        commit('loader/switchState', true, {root: true});
        commit('connecting', true);
        commit('stateWebsockets', ws.connect(state.protocol, state.hostname, state.port));

        ws.bindEvents({dispatch, commit}, actions, state.ws);
    },
    messageHandler({dispatch, commit}, message) {
        commit('setMessage', message);
    },
    resetMessage({dispatch, commit}) {
        commit('setMessage', "");
    },
    errorHandler({dispatch, commit}, error) {
        commit('setMessage', "Connection error.");
    },
    openHandler({dispatch, commit}, data) {
        commit('connecting', false);
        commit('loader/switchState', false, {root: true});

        if (data.type === 'open')
        {
            commit('connectionState', true);
        }
    },
    closeHandler({dispatch, commit}, data) {
        commit('connecting', false);
        commit('connectionState', false);
        commit('setMessage', ws.getExceptionMessage(data.code));
    },
    sendMessage({dispatch, commit}, message) {
        state.ws.send(message);
    },
    closeConnection({dispatch, commit}) {
        state.ws.close();
        commit('connecting', false);
        commit('connectionState', false);
    }
};

const mutations = {
    connecting(state, status) {
        state.connecting = status;
    },
    connectionData(state, data) {
        state.hostname = data.hostname;
        state.port = data.port;
    },
    stateWebsockets(state, connection)
    {
        state.ws = connection;
    },
    connectionState(state, isConnected)
    {
        state.connected = isConnected;
    },
    setMessage(state, message)
    {
        state.message = message;
    }
};

export const websockets = {
    namespaced: true,
    state,
    actions,
    mutations
};

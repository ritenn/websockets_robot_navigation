import { ws } from '../_helpers/websockets';

const state = {
    ws: {},
    protocol: "ws",
    hostname: "",
    port: 80,
    message: ""
}

const actions = {
    setConnection({dispatch, commit}, data) {
        commit('stateConnection', data);
        // console.log(state);
    },
    wsConnect({ dispatch, commit }) {

        commit('stateWebsockets', ws.connect(state.protocol, state.hostname, state.port));

        ws.bindEvents({dispatch, commit}, actions, state.ws);
    },
    messageHandler({dispatch, commit}, message) {
        console.log(message);
    },
    errorHandler({dispatch, commit}, error) {
        console.log(error);
    },
    openHandler({dispatch, commit}, data) {
        console.log(data);
    },
    closeHandler({dispatch, commit}, data) {
        console.log(data);
    }
};

const mutations = {
    stateConnection(state, data) {
        state.hostname = data.hostname;
        state.port = data.port;
    },
    stateWebsockets(state, connection)
    {
        state.ws = connection;
    }
};

export const websockets = {
    namespaced: true,
    state,
    actions,
    mutations
};

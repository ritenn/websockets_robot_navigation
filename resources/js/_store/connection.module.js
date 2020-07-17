const state = {
    openManager: false,
    configurationList: []
}

const actions = {
    manageConnections({ dispatch, commit }, status) {
        commit('openManager', status);
    },
    updateOrCreate({ dispatch, commit }, configurations) {
        commit('updateOrCreateRequest', configurations);
    },
    remove({ dispatch, commit }, status) {
        commit('openManager', status);
    },

};

const mutations = {
    openManager(state, status)
    {
        state.openManager = status;
    },
    updateOrCreateRequest(state, configurations)
    {
        state.configurationList = configurations;
    }

};

export const connections = {
    namespaced: true,
    state,
    actions,
    mutations
};

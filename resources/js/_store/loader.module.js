const state = {
    display: false
}

const actions = {
    display({ dispatch, commit }) {
        commit('switchState', true);
    },
    hide({ dispatch, commit }) {
        commit('switchState', false);
    }
};

const mutations = {
    switchState(state, display)
    {
        state.display = display;
    },
};

export const loader = {
    namespaced: true,
    state,
    actions,
    mutations
};

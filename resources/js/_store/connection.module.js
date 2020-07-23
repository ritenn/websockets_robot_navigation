import { connectionService } from '../_services/connection.service';

const state = {
    openManager: false,
    configurationList: [],
    configurationsErrors: []
}

const actions = {
    manageConnections({ dispatch, commit }, status) {
        commit('openManager', status);
    },
    getList({ dispatch, commit }) {
        connectionService.getList().then(

            data => {
                commit('listRequestSuccess', data.data);
            },
            error => {
                // commit('updateOrCreateRequestFailed', error.errors);
            }
        );
    },
    updateOrCreate({ dispatch, commit }, configurations) {

        connectionService.updateOrCreate(configurations).then(
            data => {
                commit('updateOrCreateRequest', data.data);
            },
            error => {
                commit('updateOrCreateRequestFailed', error.errors);

            }
        );
    },
    remove({ dispatch, commit }, id) {
        commit('openManager', status);

        connectionService.remove(id).then(
            data => {
                commit('removeRequestSuccess', data.data);
            },
            error => {
                // commit('updateOrCreateRequestFailed', error.errors);

            }
        );
    },
    resetErrors({ dispatch, commit }) {
        commit('updateOrCreateRequestFailed', []);
    }

};

const mutations = {
    openManager(state, status)
    {
        state.openManager = status;
    },
    listRequestSuccess(state, configurations)
    {
        state.configurationList = configurations;
    },
    updateOrCreateRequest(state, configurations)
    {
        state.configurationList = configurations;
    },
    updateOrCreateRequestFailed(state, errors)
    {
        state.configurationsErrors = errors;
    },
    removeRequestSuccess(state, configuration)
    {
        console.log(configuration);
    }


};

export const connections = {
    namespaced: true,
    state,
    actions,
    mutations
};

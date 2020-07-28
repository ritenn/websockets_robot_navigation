import { connectionService } from '../_services/connection.service';
import {handleResponse} from "../_helpers/handleResponse";

const state = {
    openManager: false,
    configurationList: [],
    configurationsErrors: []
}

const actions = {
    manageConnections({ dispatch, commit }, status) {
        commit('openManager', status);
    },
    getList({ dispatch, commit }, updateStatus) {

        commit('loader/switchState', true, {root: true});
        connectionService.getList(updateStatus).then(
            data => {
                commit('listRequestSuccess', data.data);
            },
            error => {
                Vue.toasted.show(error.message, {type: 'error', icon : 'warning'});
            }
        ).then(() => commit('loader/switchState', false, {root: true}));
    },
    updateOrCreate({ dispatch, commit }, configurations) {

        connectionService.updateOrCreate(configurations).then(
            data => {
                Vue.toasted.show(data.message);
                commit('updateOrCreateRequest', data.data);
            },
            error => {
                Vue.toasted.show(error.message, {type: 'error', icon : 'warning'});
                commit('updateOrCreateRequestFailed', error.errors);

            }
        );
    },
    remove({ dispatch, commit }, {index, uuid}) {

        if (uuid === "")
        {
            commit('removeRequestSuccess', index);

        } else {

            connectionService.remove(uuid).then(
                data => {
                    Vue.toasted.show(data.message);
                    commit('removeRequestSuccess', index);
                },
                error => {
                    Vue.toasted.show(error.message, {type: 'error', icon : 'warning'});
                }
            );
        }


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
        state.configurationsErrors = [];
    },
    updateOrCreateRequestFailed(state, errors)
    {
        state.configurationsErrors = errors;
    },
    removeRequestSuccess(state, index)
    {
        state.configurationList.splice(index, 1);
    }


};

export const connections = {
    namespaced: true,
    state,
    actions,
    mutations
};

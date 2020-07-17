import Vue from 'vue';
import Vuex from 'vuex';

import { connections } from './connection.module';

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        connections,
    }
});

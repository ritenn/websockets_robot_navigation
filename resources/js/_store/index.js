import Vue from 'vue';
import Vuex from 'vuex';

import { loader } from './loader.module';
import { connections } from './connection.module';
import { websockets } from './websockets.module';

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        connections,
        websockets,
        loader
    }
});

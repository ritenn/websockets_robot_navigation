<template>
<div class="row justify-content-center">
    <div class="col-lg-4 col-md-12 pb-2">
        <div class="card bg-dark">
            <div class="card-header">
                <h5 class="card-title"><i class="fa fa-wifi" aria-hidden="true"></i> Connect</h5>
            </div>
            <div class="card-body bg-dark-light">
                <div v-if="configurationList.length == 0" class="row">
                    <div class="col-12 d-flex flex-column justify-content-center">
                        <h5><strong>Sorry there are no configured connections.</strong></h5>
                        <small>Click "manage connections" and add some new configuration for your robot</small>
                    </div>
                </div>
                <div v-else class="connections-row row bg-light p-2 mb-2 m-1" v-for="config in configurationList" :class="{'primary': config.primary}">
                    <div class="col-lg-4 d-flex flex-column justify-content-center">
                        <strong>{{config.name.value}}</strong>
                    </div>
                    <div class="col-lg-4 mt-4 mt-lg-0 d-flex flex-column justify-content-center">
                        {{config.hostname.value}}:{{config.port.value}}
                    </div>
                    <div class="col-lg-4 text-right mt-4 mt-lg-0">
                        <button class="btn btn-success btn-block">
                            Connect <i class="fa fa-space-shuttle" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="row pt-5">
                    <div v-if="configurationList.length" class="col-lg-12">
                        <div class="form-group">
                            <input id="connect-automatically" type="checkbox" value="1" class="form-control-checkbox" />
                            <label for="connect-automatically">Connect to primary automatically</label>
                        </div>
                    </div>
                    <div class="col-lg-12 text-left mb-1">
                        <button @click="switchTabs" class="btn-block btn btn-primary p-3">
                            Manage configurations <i class="fa fa-plus align-middle" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    import { mapState, mapActions } from 'vuex'

    export default {
        computed: {
            ...mapState('connections', ['openManager', 'configurationList'])
        },
        mounted() {

        },
        data() {
            return {
                configurationManager: false
            }
        },
        methods: {
            ...mapActions('connections', ['manageConnections']),
            switchTabs()
            {
                this.manageConnections(!this.openManager);
            }
        }
    }
</script>

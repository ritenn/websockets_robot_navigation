<template>
<div class="row justify-content-center">
    <div class="col-lg-4 col-md-12 pb-2">
        <div class="card bg-dark">
            <div class="card-header">
                <h5 class="card-title text-white"><i class="fa fa-wifi" aria-hidden="true"></i>
                    Connect
                    <small v-show="configurationList.length" class="float-right text-whtie">refresh status in <strong>{{refreshTimerSeconds}}</strong></small>
                </h5>
            </div>
            <div class="card-body bg-dark-light">
                <div v-if="configurationList.length === 0" class="row">
                    <div class="col-12 d-flex flex-column justify-content-center">
                        <h5><strong>Sorry there are no configured connections.</strong></h5>
                        <small>Click "manage connections" and add some new configuration for your robot</small>
                    </div>
                </div>
                <div v-else class="connections-row row bg-light p-2 mb-2 m-1" v-for="config in configurationList" :class="{'primary': config.primary}">
                    <div class="col-lg-12 d-flex flex-column justify-content-center pt-2">
                        <h3>
                            <strong><i class="text-white fa fa-database pr-2" aria-hidden="true"></i> {{config.name}}</strong>
                        </h3>
                    </div>
                    <div class="col-lg-12 mt-2 d-flex flex-column justify-content-center text-primary">
                        <div class="mb-2">
                            <span class="p-3 badge badge-dark">{{config.hostname}}:{{config.port}}</span>
                            <template v-show="!config.online">
                                <span v-if="!config.online" class="p-3 badge badge-danger">Offline</span>
                                <span v-else class="p-3 badge badge-success">Online</span>
                            </template>
                        </div>
                    </div>
                    <div class="col-lg-12 text-right mt-2">
                        <button :disabled="!config.online" @click="connect(config.uuid)" class="btn btn-success btn-block d-flex justify-content-between">
                            <strong>Connect</strong> <i class="mt-auto mb-auto fa fa-space-shuttle" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="row pt-5">
                    <div v-if="configurationList.length" class="col-lg-12">
                        <div class="form-group">
                            <input id="connect-automatically" type="checkbox" value="1" class="form-control-checkbox" />
                            <label class="text-success" for="connect-automatically">Connect to primary automatically</label>
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
            ...mapState('connections', ['openManager', 'configurationList']),
            ...mapState('websockets', ['ws', 'message']),
        },
        created() {
            this.getList(true);
            this.refreshList();

        },
        data() {
            return {
                refreshInitial: 30,
                refreshTimerSeconds: this.refreshInitial,
            }
        },
        watch: {
            ws: function(val) {
              // console.log(val);
            },
            message: function(val) {
                // console.log(val);
            }
        },
        methods: {
            ...mapActions('connections', ['manageConnections', 'getList']),
            ...mapActions('websockets', ['setConnection', 'wsConnect']),
            refreshList()
            {
                setInterval(() => {

                    this.refreshTimerSeconds = this.refreshTimerSeconds > 0 && this.configurationList.length > 0 ? this.refreshTimerSeconds - 1 : this.refreshInitial;

                    if (this.refreshTimerSeconds === 0 && this.openManager === false)
                    {
                        this.getList(true);
                    }
                }, 1000);

            },
            switchTabs()
            {
                this.manageConnections(!this.openManager);
            },
            connect(uuid)
            {
                const selectedConnection = this.configurationList.find(x => x.uuid == uuid);

                this.setConnection(selectedConnection);
                this.wsConnect();
                // console.log();
                // window.location.href = '/navigation/manual/' + uuid
            }

        }
    }
</script>

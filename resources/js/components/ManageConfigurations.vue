<template>
    <div class="row justify-content-center">
        <div class="col-lg-12 pb-5 text-right">
            <button @click="returnToConnections" class="p-3 btn btn-primary btn-block">
                Return to connections <i class="fa fa-wifi"></i>
            </button>
        </div>
        <div class="col-lg-6 pb-2">
            <div class="card bg-dark">
                <div class="card-header">
                    <b-button v-b-toggle.configuration variant="secondary" class="float-right ml-2 d-md-none">
                        <i class="opened fa fa-minus"></i>
                        <i class="closed fa fa-plus"></i>
                    </b-button>
                    <h5 class="card-title text-white">
                        <i class="fa fa-cog pr-2" aria-hidden="true"></i> Create new robot configuration
                    </h5>
                </div>
                <b-collapse visible id="configuration" class="card-body bg-dark-light">
                <form>
                    <div class="form-group">
                        <label for="name">Configuration name</label>
                        <input type="text" v-model="configurationTemplate.name" v-validation="[validationRules(configurationTemplate).name, null]" class="form-control" id="name" aria-describedby="name" placeholder="e.g. Arduino Robot V1" required />
                    </div>
                    <div class="form-group">
                        <label for="hostname">Hostname / IP</label>
                        <input type="text" v-model="configurationTemplate.hostname" class="form-control" v-validation="[validationRules(configurationTemplate).hostname, '']"  id="hostname" aria-describedby="hostname" placeholder="192.168.x.x" required />
                        <small class="form-text text-muted">IP of ESP8266 server module.</small>
                    </div>
                    <div class="form-group">
                        <label for="port">Port</label>
                        <input type="numeric" v-model="configurationTemplate.port" class="form-control" v-validation="[validationRules(configurationTemplate).port, '']"  id="port" placeholder="80" required />
                    </div>
                    <hr class="mt-5" />
                    <div class="form-group">
                        <label for="rotation_speed">Initial rotation speed: <strong>{{configurationTemplate.rotation_speed}}</strong></label>
                        <input type="range" v-model="configurationTemplate.rotation_speed" min="110" max="200" class="form-control-range" id="rotation_speed" required />
                    </div>
                    <div class="form-group">
                        <label for="left_engine_speed">Initial left engine speed: <strong>{{configurationTemplate.left_engine_speed}}</strong></label>
                        <input type="range" v-model="configurationTemplate.left_engine_speed" min="0" max="255" class="form-control-range" id="left_engine_speed" required />
                    </div>
                    <div class="form-group">
                        <label for="right_engine_speed">Initial right engine speed: <strong>{{configurationTemplate.right_engine_speed}}</strong></label>
                        <input type="range" v-model="configurationTemplate.right_engine_speed" min="0" max="255" class="form-control-range" id="right_engine_speed" required />
                    </div>
                </form>
                <button @click="add" class="btn btn-primary mt-5 pull-right">
                    Add configuration <i class="fa fa-plus align-middle" aria-hidden="true"></i>
                </button>
                </b-collapse>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card bg-dark">
                <div class="card-header">
                    <b-button v-b-toggle.list variant="secondary" class="float-right ml-2 d-md-none">
                        <i class="opened fa fa-minus"></i>
                        <i class="closed fa fa-plus"></i>
                    </b-button>
                    <h5 class="card-title text-white">
                        <i class="fa fa-database pr-2" aria-hidden="true"></i> Available configuration list
                    </h5>
                </div>
                <b-collapse visible id="list" class="card-body bg-dark-light">
                    <div class="text-center pt-5 pb-5" v-if="configurations.length === 0">
                        <h4><i class="display-4 fa fa-exclamation-triangle" aria-hidden="true"></i> No results</h4>
                        <small>Add some configuration first</small>
                    </div>
                    <transition-group :name="'fade'" mode="slide-out">
                    <div class="card bg-dark mt-2" v-for="(config, index) in configurations" :key="index+1">
                        <div class="card-header">
                            <button @click="alertDelete(index)" class="btn btn-danger ml-2 float-right">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                            <b-button v-b-toggle="'list-' + index" variant="secondary" class="float-right ml-2">
                                <i class="opened fa fa-minus"></i>
                                <i class="closed fa fa-plus"></i>
                            </b-button>

                            <h5 class="card-title">{{index + 1}}. {{config.name}} <small class="text-success" v-if="config.primary">- primary</small></h5>
                        </div>
                        <b-collapse :visible="index == 0" :id="'list-' + index" class="card-body bg-light">
                            <div class="form-group">
                                <input type="text" v-model="config.name" class="form-control" v-validation="[validationRules(config).name, serverValidation(index, 'name')]" aria-describedby="name" placeholder="Configuration label name" required />
                            </div>
                            <div class="form-group">
                                <input type="text" v-model="config.hostname" class="form-control" v-validation="[validationRules(config).hostname, serverValidation(index, 'hostname')]" aria-describedby="hostname" placeholder="192.168.x.x" required />
                            </div>
                            <div class="form-group">
                                <input type="numeric" v-model="config.port" class="form-control" v-validation="[validationRules(config).port, serverValidation(index, 'port')]" placeholder="80" required />
                            </div>

                            <div class="form-group">
                                <label>Initial rotation speed: <strong>{{config.rotation_speed}}</strong></label>
                                <input type="range" v-model="config.rotation_speed" min="110" max="200" class="form-control-range" required />
                            </div>
                            <div class="form-group">
                                <label>Initial left engine speed: <strong>{{config.left_engine_speed}}</strong></label>
                                <input type="range" v-model="config.left_engine_speed" min="0" max="255" class="form-control-range" required />
                            </div>
                            <div class="form-group">
                                <label>Initial right engine speed: <strong>{{config.right_engine_speed}}</strong></label>
                                <input type="range" v-model="config.right_engine_speed" min="0" max="255" class="form-control-range" required />
                            </div>
                            <div class="form-group mt-4">
                                <input @click="primarySetting(index, $event)" :id="'primary-' + index" type="checkbox" value="1" v-model="config.primary" class="form-control-checkbox" />
                                <label :for="'primary-' + index">Primary configuration</label>
                            </div>
                        </b-collapse>
                    </div>
                    </transition-group>
                    <button v-if="configurations.length !== 0" @click="save" class="btn btn-primary mt-5 pull-right">
                        Save changes <i class="fa fa-save" aria-hidden="true"></i>
                    </button>
                </b-collapse>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState, mapActions } from 'vuex'

    export default {
        computed: {
            ...mapState('connections', ['openManager', 'configurationList', 'configurationsErrors'])
        },
        data() {
            return {
                configurationTemplate: this.initialConfig(),
                configurations: [],
                isUnsaved: false,
            }
        },
        created() {
            this.getList();
        },
        watch: {
            configurationList: function (val) {
                this.configurations = val;
            }
        },
        methods: {
            ...mapActions('connections', ['manageConnections', 'updateOrCreate', 'getList', 'remove', 'resetErrors']),
            returnToConnections()
            {
                if (this.isUnsaved)
                {
                    this.alertUnsaved();

                } else {

                    this.manageConnections(false);
                }

            },
            save()
            {
                // if (this.isValid())
                // {
                    this.isUnsaved = false;
                    const {configurations} = this;

                    this.updateOrCreate(configurations);
                // }
            },
            add()
            {
                if (this.isValid())
                {
                    this.isUnsaved = true;
                    this.configurations.push(JSON.parse(JSON.stringify(this.configurationTemplate)));
                    this.configurationTemplate = this.initialConfig();
                }
            },
            primarySetting(index, event)
            {
                if (event.target.checked) {
                    const tempObj = this.configurations[index];
                    this.configurations.splice(index, 1);
                    this.configurations.splice(0, 0, tempObj);

                    for (let key in this.configurations) {
                        this.configurations[key].primary = key == 0 ? 1 : 0;
                        document.getElementById("primary-" + key).checked = key == 0 ? true : false;
                    }
                }

            },
            alertUnsaved() {
                const _this = this;

                this.$swal({
                    title: 'You have some unsaved changes!',
                    text: 'Are you sure?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel',
                    showCloseButton: true,
                    showLoaderOnConfirm: true
                }).then((result) => {
                    if(result.value) {
                        _this.manageConnections(false);
                    } else {
                        this.$swal('Cancelled', 'Be careful next time', 'info')
                    }
                })
            },
            alertDelete(index) {
                const _this = this;

                this.$swal({
                    title: 'Are you sure?',
                    text: 'You are trying to remove: ' + _this.configurations[index].name.value,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes Delete it!',
                    cancelButtonText: 'No, Keep it!',
                    showCloseButton: true,
                    showLoaderOnConfirm: true
                }).then((result) => {
                    if(result.value) {

                        _this.remove({index: index, uuid: _this.configurations[index].uuid});

                        this.$swal('Deleted', 'You successfully deleted this row', 'success');

                    } else {
                        this.$swal('Cancelled', 'Be careful next time', 'info')
                    }
                })
            },
            /**
             * Initial values for new configuration
             *
             * @returns {{hostname: string, port: number, name: string, speed: {left: number, rotation: number, right: number}}}
             */
            initialConfig()
            {
                return {
                    uuid: "",
                    primary: 0,
                    name: "test",
                    hostname: "182.168.12.123",
                    port: 80,
                    rotation_speed: 140,
                    left_engine_speed: 90,
                    right_engine_speed: 90
                }
            },
            /**
             * Validates configuration fields
             *
             * @param model
             * @returns {boolean}
             */
            isValid(model)
            {
                return document.querySelectorAll('.is-invalid').length === 0 ? true : false;
            },
            validationRules(model)
            {
                return {
                    name: {
                        rule: model.name.length === 0 || model.name.length > 50 ? false : true,
                        message: "That field cannot be empty or longer then 50 letters."
                    },
                    hostname: {
                        rule: model.hostname.length === 0 || model.hostname.length > 15 || !((/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/).test(model.hostname)) ? false : true,
                        message: "That field cannot be empty or longer then 12 digits."
                    },
                    port: {
                        rule: model.port.length === 0 || !(/^\d+$/.test(model.port)) ? false : true,
                        message: "That field cannot be empty and must be numeric."
                    }
                }

            },
            serverValidation(index, name)
            {
                return this.configurationsErrors[index + '.' + name] ?? null;
            }

        },
    }
</script>

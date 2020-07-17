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
                    <h5 class="card-title">Create new robot configuration</h5>
                </div>
                <b-collapse visible id="configuration" class="card-body bg-dark-light">
                <form>
                    <div class="form-group">
                        <label for="name">Configuration label name</label>
                        <input type="text" v-model="configurationTemplate.name.value" class="form-control" :class="{'is-invalid': !configurationTemplate.name.valid}" id="name" aria-describedby="name" placeholder="e.g. Arduino Robot V1" required />
                        <div class="invalid-feedback">That field cannot be empty or longer then 50 letters.</div>
                    </div>
                    <div class="form-group">
                        <label for="hostname">Hostname / IP</label>
                        <input type="text" v-model="configurationTemplate.hostname.value" class="form-control" :class="{'is-invalid': !configurationTemplate.hostname.valid}"  id="hostname" aria-describedby="hostname" placeholder="192.168.x.x" required />
                        <small class="form-text text-muted">IP of ESP8266 server module.</small>
                        <div class="invalid-feedback">That field cannot be empty or longer then 12 digits.</div>
                    </div>
                    <div class="form-group">
                        <label for="port">Port</label>
                        <input type="numeric" v-model="configurationTemplate.port.value" class="form-control" :class="{'is-invalid': !configurationTemplate.port.valid}"  id="port" placeholder="80" required>
                        <div class="invalid-feedback">That field cannot be empty and must be numeric.</div>
                    </div>
                    <hr class="mt-5" />
                    <div class="form-group">
                        <label for="rotation_speed">Initial rotation speed: <strong>{{configurationTemplate.speed.rotation}}</strong></label>
                        <input type="range" v-model="configurationTemplate.speed.rotation" min="110" max="200" class="form-control-range" id="rotation_speed" required />
                    </div>
                    <div class="form-group">
                        <label for="left_engine_speed">Initial left engine speed: <strong>{{configurationTemplate.speed.left}}</strong></label>
                        <input type="range" v-model="configurationTemplate.speed.left" min="0" max="255" class="form-control-range" id="left_engine_speed" required />
                    </div>
                    <div class="form-group">
                        <label for="right_engine_speed">Initial right engine speed: <strong>{{configurationTemplate.speed.right}}</strong></label>
                        <input type="range" v-model="configurationTemplate.speed.right" min="0" max="255" class="form-control-range" id="right_engine_speed" required />
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
                    <h5 class="card-title">Available configuration list</h5>
                </div>
                <b-collapse visible id="list" class="card-body bg-dark-light">
                    <div class="text-center pt-5 pb-5" v-if="configurations.length === 0">
                        <h4><i class="display-4 fa fa-exclamation-triangle" aria-hidden="true"></i> No results</h4>
                        <small>Add some configuration first</small>
                    </div>
                    <transition-group :name="'fade'" mode="slide-out">
                    <div class="card bg-dark mt-2" v-for="(config, index) in configurations" :key="index+1">
                        <div class="card-header">
<!--                            remove(index)-->
                            <button @click="alertDelete(index)" class="btn btn-danger ml-2 float-right">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                            <b-button v-b-toggle="'list-' + index" variant="secondary" class="float-right ml-2">
                                <i class="opened fa fa-minus"></i>
                                <i class="closed fa fa-plus"></i>
                            </b-button>

                            <h5 class="card-title">{{index + 1}}. {{config.name.value}} <small class="text-success" v-if="config.primary">- primary</small></h5>
                        </div>
                        <b-collapse :visible="index == 0" :id="'list-' + index" class="card-body bg-light">
                            <div class="form-group">
                                <input type="text" v-model="config.name.value" class="form-control" :class="{'is-invalid': !config.name.valid}" aria-describedby="name" placeholder="Configuration label name" required />
                                <div class="invalid-feedback">That field cannot be empty or longer then 50 letters.</div>
                            </div>
                            <div class="form-group">
                                <input type="text" v-model="config.hostname.value" class="form-control" :class="{'is-invalid': !config.hostname.valid}" aria-describedby="hostname" placeholder="192.168.x.x" required />
                                <div class="invalid-feedback">That field cannot be empty or longer then 12 digits.</div>
                            </div>
                            <div class="form-group">
                                <input type="numeric" v-model="config.port.value" class="form-control" :class="{'is-invalid': !config.port.valid}" placeholder="80" required />
                                <div class="invalid-feedback">That field cannot be empty and must be numeric.</div>
                            </div>

                            <div class="form-group">
                                <label>Initial rotation speed: <strong>{{config.speed.rotation}}</strong></label>
                                <input type="range" v-model="config.speed.rotation" min="110" max="200" class="form-control-range" required />
                            </div>
                            <div class="form-group">
                                <label>Initial left engine speed: <strong>{{config.speed.left}}</strong></label>
                                <input type="range" v-model="config.speed.left" min="0" max="255" class="form-control-range" required />
                            </div>
                            <div class="form-group">
                                <label>Initial right engine speed: <strong>{{config.speed.right}}</strong></label>
                                <input type="range" v-model="config.speed.right" min="0" max="255" class="form-control-range" required />
                            </div>
                            <div class="form-group mt-4">
                                <input @click="primarySetting(index, $event)" :id="'primary-' + index" type="checkbox" value="1" v-model="config.primary" class="form-control-checkbox" />
                                <label>Primary configuration</label>
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
            ...mapState('connections', ['openManager', 'configurationList'])
        },
        data() {
            return {
                configurationTemplate: this.initialConfig(),
                configurations: [],
                isUnsaved: false
            }
        },
        created() {
            this.configurations = this.configurationList;
        },
        methods: {
            ...mapActions('connections', ['manageConnections', 'updateOrCreate']),
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
               if(this.validateAllConfigurationsData())
               {
                   this.isUnsaved = false;
                   const {configurations} = this;
                   this.updateOrCreate(configurations);
               }
            },
            validateAllConfigurationsData()
            {
                let isValid = true;
                for (const obj of this.configurations) {
                    if (!this.isValid(obj))
                    {
                        isValid = false;
                    }
                }

                return isValid;
            },
            add()
            {
                if (this.isValid(this.configurationTemplate))
                {
                    this.isUnsaved = true;
                    this.configurations.push(JSON.parse(JSON.stringify(this.configurationTemplate)));
                    this.configurationTemplate = this.initialConfig();
                }
            },
            remove(el)
            {
                if (this.configurations.splice(el, 1))
                {
                    return true
                }

                return false
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
                        if (_this.remove(index))
                        {
                            this.$swal('Deleted', 'You successfully deleted this row', 'success')
                        } else {
                            this.$swal('Failed', 'Failed to deleted this row', 'error')
                        }
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
                    primary: 0,
                    name: {
                        value: "",
                        valid: true
                    },
                    hostname: {
                        value: "",
                        valid: true
                    },
                    port: {
                        value: "",
                        valid: true
                    },
                    speed: {
                        rotation: 140,
                        left: 90,
                        right: 90
                    }
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
                const name = model.name.value;
                const hostname = model.hostname.value;
                const port = model.port.value;

                model.name.valid = name.length === 0 || name.length > 50 ? false : true;
                model.hostname.valid = hostname.length === 0 || hostname.length > 15 || !((/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/).test(hostname)) ? false : true;
                model.port.valid = port.length === 0 || !(/^\d+$/.test(port)) ? false : true;

                return model.name.valid && model.hostname.valid && model.port.valid ? true : false;
            },
        },
    }
</script>

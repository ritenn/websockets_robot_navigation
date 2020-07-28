<template>
    <div id="main-console" :class="{'full_width': openConsole}">
        <button @click="openConsole = !openConsole" class="btn-terminal">
            <i class="fa fa-terminal" aria-hidden="true"></i>
        </button>
        <div v-show="openConsole" class="console">
            <div class="container-fluid pt-5">
                <div class="row">

                    <div class="col-lg-12 d-inline-flex justify-content-between">
                        <div class="console-user m-auto"><strong><span class="text-white">{{dateTime()}}</span>{{baseUser}}</strong></div>
                        <div class="console-input">
                            <input type="text" id="command-line" class="console-input pl-2 text-white"
                                   v-model="commandLine"
                                   @focus="carcetActive = true"
                                   @blur="carcetActive = false"
                                   @keyup.enter="sendCommand"
                            />
                            <i :style="{'left': carcetPos + 'px'}" class="blink-caret" :class="{'caret-active': carcetActive}"></i>
                        </div>
                    </div>
                    <span class="invisible" id="calc_pos"></span>
                    <div class="col-lg-12 d-inline-flex justify-content-between" v-for="com of serverCommunicationHistory">
                        <div class="console-user m-auto"><strong><span class="text-white">{{com.time}}</span> {{baseUser}}</strong></div>
                        <div class="console-input h-auto">
                            <div class="console-input h-auto pl-2 text-white">{{com.command}}</div>
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
        props: ['config'],
        computed: {
            ...mapState('connections', ['openManager'])
        },
        created() {
            this.baseUser = this.config.hostname + ":~$";

        },
        watch: {
            commandLine (value) {
                this.calculateCarcetPosition(value);
            }
        },
        data() {
            return {
                baseUser: "",
                commandLine: "",
                openConsole: false,
                carcetPos: 7,
                carcetActive: false,
                serverCommunicationHistory: [],
            }
        },
        methods: {
            sendCommand()
            {
                this.serverCommunicationHistory.push({
                    time: this.dateTime(),
                    command: this.commandLine,
                });
                this.serverCommunicationHistory.reverse();
                this.commandLine = "";
            },
            calculateCarcetPosition(value)
            {
                const input = document.getElementById("calc_pos");
                input.innerText = value;

                this.carcetPos = input.clientWidth + 7;
            },
            dateTime()
            {
                let date = new Date();

                let h = date.getHours();
                h = ("0" + h).slice(-2);
                let m = date.getMinutes();
                m = ("0" + m).slice(-2);
                let s = date.getSeconds();
                s = ("0" + s).slice(-2);

                return "[ " + h + ":" + m + ":" + s + " ] ";
            }
        }
    }
</script>

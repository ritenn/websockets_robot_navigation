<template>
    <div id="main-console" :class="{'full_width': openConsole}">
        <button @click="openConsole = !openConsole" class="btn-terminal" :class="{'terminal-open': openConsole}">
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
                                   @keyup.enter="sendCommand(commandLine)"
                            />
                            <i :style="{'left': carcetPos + 'px'}" class="blink-caret" :class="{'caret-active': carcetActive}"></i>
                        </div>
                    </div>
                    <span class="invisible" id="calc_pos"></span>
                    <div class="col-lg-12 d-inline-flex justify-content-between" v-for="com of serverCommunicationHistory">
                        <div class="console-user m-auto">
                            <template v-if="!com.server">
                                <strong><span class="text-white">{{com.time}}</span> {{baseUser}}</strong>
                            </template>
                            <template v-else>
                                <strong><span class="text-white">{{com.time}}</span> &gt;</strong>
                            </template>
                        </div>
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
            ...mapState('connections', ['openManager']),
            ...mapState('websockets', ['connecting', 'connected', 'message']),
        },
        created() {
            this.baseUser = this.config.hostname + ":~$";
            this.reconnect();
        },
        watch: {
            commandLine(value) {
                this.calculateCarcetPosition(value);
            },
            connected(status) {

                if (!status)
                    this.reconnect();
            },
            message(data) {

                if (data !== '')
                {
                    this.serverCommunicationHistory.push({
                        server: true,
                        time: this.dateTime(),
                        command: data,
                    });

                    this.sortHistoryByTimeDesc();
                }

                this.resetMessage();
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
                reconnectTimeout: 5000,
                heartBeatTimeout: 10000,
                latestActivityTimeout: 0,
            }
        },
        methods: {
            ...mapActions('websockets', ['setConnection', 'wsConnect', 'sendMessage', 'resetMessage', 'closeConnection']),
            heartbeat() {
                let pingSent = false;
                let responseDuration = 0;

                let heartbeatInterval = setInterval(() => {

                    if (this.latestActivityTimeout == this.heartBeatTimeout && !pingSent)
                    {
                        this.sendCommand("PING");

                        this.latestActivityTimeout = 0;
                        pingSent = true;
                    }

                    if (pingSent)
                    {
                        let ping = this.serverCommunicationHistory.find(x => x.command == "PING").time;
                        let lastServerResponse = this.serverCommunicationHistory.find(x => x.server == true);

                        if (lastServerResponse != undefined)
                        {
                            if (lastServerResponse.time >= ping )
                            {
                                pingSent = false;
                            }
                        }

                        if (responseDuration > 1000)
                        {
                            this.closeConnection();
                            clearInterval(heartbeatInterval);
                        }
                        responseDuration++;
                    }

                    this.latestActivityTimeout++;
                }, 1);

            },
            reconnect() {

                let reconnectInterval = setInterval(() => {

                    if (!this.connected)
                    {
                        if (!this.connecting)
                        {
                            this.setConnection(this.config);
                            this.wsConnect();
                        }

                    } else {
                        this.heartbeat();
                        clearInterval(reconnectInterval);
                    }

                }, this.reconnectTimeout);

            },
            sendCommand(command)
            {
                this.latestActivityTimeout = 0;

                this.serverCommunicationHistory.push({
                    server: false,
                    time: this.dateTime(),
                    command: command,
                });

                this.sortHistoryByTimeDesc();

                this.sendMessage(command);
                this.commandLine = "";
            },
            calculateCarcetPosition(value)
            {
                const input = document.getElementById("calc_pos");
                input.innerText = value;

                this.carcetPos = input.clientWidth + 7;
            },
            sortHistoryByTimeDesc()
            {
                this.serverCommunicationHistory.sort((a, b) => {
                    return new Date('1970/01/01 ' + b.time) - new Date('1970/01/01 ' + a.time)
                });
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

                return h + ":" + m + ":" + s;
            }
        }
    }
</script>

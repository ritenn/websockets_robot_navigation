<template>
    <div class="row justify-content-center">
        <div class="col-sm-6 compass-col">
            <div @touchmove="startRotate" @touchstart="startRotate" @touchend="stopRotate" @mousedown="startRotate" @mouseup="stopRotate" class="rotation-wrapper rotation-wrapper-current">
            </div>

            <div class="rotation-wrapper">
                <div @click="angle=0" class="direction direction-north">0</div>
                <div @click="angle=90" class="direction direction-east">90</div>
                <div @click="angle=-90" class="direction direction-west">-90</div>
                <div @click="angle=180" class="direction direction-south">180</div>
            </div>
            <div class="p-lg-6 p-sm-5 p-md-5 overflow-hidden">
            <div class="controls">
                <button @click="sendMove('F')" class="controls-btn" :class="{active: direction == 'F'}">
                    <span class="triangle triangle-top"></span>
                </button>
                <div class="controls-center">
                    <div class="controls-center-wrapper controls-center-wrapper-right">
                        <button @click="sendMove('R')" class="controls-btn" :class="{active: direction == 'R'}">
                            <span class="triangle triangle-right"></span>
                        </button>
                    </div>
                    <button @click="sendMove('H')" class="controls-btn" :class="{active: direction == 'H'}">
                        <span class="triangle triangle-center"></span>
                        <div class="direction-display">
                            <span class="direction-display-value">{{ Math.round(angle) }}</span>&deg;
                        </div>
                    </button>
                    <div class="controls-center-wrapper controls-center-wrapper-left">
                        <button @click="sendMove('L')" class="controls-btn" :class="{active: direction == 'L'}">
                            <span class="triangle triangle-left"></span>
                        </button>
                    </div>
                </div>
                <button @click="sendMove('B')" class="controls-btn" :class="{active: direction == 'B'}">
                    <span class="triangle triangle-down"></span>
                </button>
            </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="speed-controls d-inline-flex flex-row justify-content-between w-100">
                <div @click="speed.leftActive = !speed.leftActive"
                     class="text-center speed-controls-indicator" :class="{active: speed.leftActive}"
                >
                    {{speed.left}}
                </div>
                <div class="d-flex w-100 justify-content-center">
                    <input @click="sendSpeed" class="speed-controls-range-speed" type="range" min="60" max="255" v-model="speedIndicator">
                </div>
                <div @click="speed.rightActive = !speed.rightActive"
                     class="text-center speed-controls-indicator" :class="{active: speed.rightActive}"
                >
                    {{speed.right}}
                </div>
            </div>

            <div class="mt-3 speed-controls d-inline-flex flex-row justify-content-between w-100">
                <div class="w-50 text-center speed-controls-indicator active">
                    {{speed.rotation}}
                </div>
                <div class="d-flex w-100 justify-content-end">
                    <input class="speed-controls-range-speed rotation" type="range" min="60" max="255" v-model="speed.rotation">
                </div>

            </div>
        </div>

        <console :config="configurationData" />
    </div>
</template>

<script>
    import { mapState, mapActions } from 'vuex'

    export default {
        props: ['configurationData'],
        computed: {
            ...mapState('connections', ['openManager'])
        },
        mounted() {
            window.addEventListener("resize", this.handleResize);
            this.compassDiv = document.getElementsByClassName("rotation-wrapper")[0];
            this.currentAngleDiv = document.getElementsByClassName("rotation-wrapper")[1];

            var interval = 0;
            var resizeInterval = setInterval( () => {
                if (interval > 3)
                {
                    clearInterval(resizeInterval);
                } else {
                    this.handleResize()
                }
                interval++;
            }, 200);

        },
        data() {
            return {
                compassDiv: {},
                currentAngleDiv: {},
                direction: 'H',
                angle: 0,
                speedIndicator: 100,
                speed: {
                    leftActive: true,
                    rightActive: true,
                    left: this.configurationData.left_engine_speed,
                    right: this.configurationData.right_engine_speed,
                    rotation: this.configurationData.rotation_speed,
                },
            }
        },
        watch: {
            angle: function(angle) {
                this.compassDiv.style.transform = "rotate(" + angle + "deg)";
            },
            speedIndicator: function(speed) {

                if (this.speed.leftActive)
                {
                    this.speed.left = speed;
                }

                if (this.speed.rightActive)
                {
                    this.speed.right = speed;
                }
            }
        },
        methods: {

            handleResize()
            {
                let compasHeight = this.compassDiv.offsetHeight;
                this.compassDiv.style.width = compasHeight + "px";
                this.currentAngleDiv.style.width = compasHeight + "px";
            },
            rotate(e)
            {
                let compasDivWidth = document.getElementsByClassName("compass-col")[0].offsetWidth;
                let compasDivHeight = document.getElementsByClassName("compass-col")[0].offsetHeight;
                let compasDivTopOffset = document.getElementsByClassName("compass-col")[0].offsetTop;

                let center = [(compasDivWidth/2), compasDivTopOffset + compasDivHeight/2];

                if(e.type == 'touchstart' || e.type == 'touchmove' || e.type == 'touchend' || e.type == 'touchcancel'){
                    let evt = (typeof e.originalEvent === 'undefined') ? e : e.originalEvent;
                    let touch = evt.touches[0] || evt.changedTouches[0];

                    var pageX = touch.pageX;
                    var pageY = touch.pageY;

                } else if (e.type == 'mousedown' || e.type == 'mouseup' || e.type == 'mousemove' || e.type == 'mouseover'|| e.type=='mouseout' || e.type=='mouseenter' || e.type=='mouseleave') {

                    var pageX = e.clientX;
                    var pageY = e.clientY;
                }

                this.angle = Math.atan2(pageX - center[0], - (pageY - center[1]) ) * (180/Math.PI);
            },
            startRotate()
            {
                window.addEventListener('mousemove', this.rotate);
                window.addEventListener('touchstart', this.rotate);
                window.addEventListener('touchmove', this.rotate);
            },
            stopRotate()
            {
                window.removeEventListener('mousemove', this.rotate);
                window.removeEventListener('touchmove', this.rotate);
                window.removeEventListener('touchstart', this.rotate);
            },
            sendMove(direction)
            {
                this.direction = direction;
            },
            sendSpeed()
            {
                // console.log(this.speedIndicator);
            }
        }
    }
</script>

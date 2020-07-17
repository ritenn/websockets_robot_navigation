<template>
    <div class="resize-wrapper">
        <button v-if="isFullscreen" class="resize resize-full pull-right" @click="fullscreen"><i class="fa fa-arrows-alt" aria-hidden="true"></i></button>
        <button v-else class="resize resize-exit pull-right" @click="fullscreen"><i class="fa fa-compress" aria-hidden="true"></i></button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                isFullscreen: true
            }
        },
        methods: {
            fullscreen()
            {
                if (this.isFullscreen)
                {
                    document.documentElement.requestFullscreen();
                } else {
                    document.webkitExitFullscreen();
                }

                this.isFullscreen = !this.isFullscreen;
            }
        }
    }
</script>

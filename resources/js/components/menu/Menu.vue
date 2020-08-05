<template>
<div class="container-fluid" :class="{'menu-open': open}">
    <div class="main-menu-wrapper">
        <button v-if="open" class="pull-left" @click="open = !open"><i class="fa fa-times" aria-hidden="true"></i></button>
        <button v-else class="pull-left" @click="open = !open"><i class="fa fa-bars" aria-hidden="true"></i></button>
    </div>
    <fullscreen-managment/>
    <transition name="fade">
    <div class="row" v-show="open">
        <div class="col-lg-12 mt-5">
            <div class="menu-wrapper">
                <h2>Menu</h2>
                <hr class="bg-white" />
                <ul class="menu-list">
                    <li class="menu-list-item d-flex flex-column">
                        <a class="menu-list-item-action " href="/">
                            <i class="fa fa-wifi" aria-hidden="true"></i> Connections
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    </transition>
</div>
</template>

<script>
export default {
    data() {
        return {
            open: false
        }
    },
    methods: {

    }
}
</script>


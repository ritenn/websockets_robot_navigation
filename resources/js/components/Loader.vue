<template>
    <div class="loader-wrapper" v-show="display">
        <div class="loader h-100 d-flex flex-column align-items-center">
            <img class="loader-gif m-auto" src="/loader.gif"/>
        </div>
    </div>
</template>

<script>
    import { mapState, mapActions } from 'vuex'
    export default {
        computed: {
            ...mapState('loader', ['display']),
        },
    }
</script>
<style>
    .loader-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        overflow: hidden;
        margin: auto;
        background: #000000;
        z-index: 120;
        animation: fadeIn 5s infinite;
    }
    .loader-gif {
        width:30%;
        max-width: 150px;
        animation: flying 5s infinite;
    }

    @keyframes fadeIn {
        0%   { background: #000000; }
        25%  { background: #000000f0; }
        50%  { background: #000000e8; }
        75%  { background: #00000094; }
        100% { background: #ffffff94 }
    }

    @keyframes flying {
        0%   {transform: rotate(10deg); }
        25%  {transform: rotate(20deg); }
        50%  {transform: rotate(30deg); }
        75%  {transform: rotate(40deg); }
        100% {transform: rotate(45deg); }
    }

</style>

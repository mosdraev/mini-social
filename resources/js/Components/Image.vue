<template>
    <img :src="source" class="image-box">
</template>

<style scoped>
.image-box {
    width: 250px;
    max-height: 250px;
}
</style>

<script>
export default {

    props: ['src'],

    computed: {
        source() {
            let path = this.src.split('/');
            path[0] = 'storage';

            return '/' + path.join('/');
        }
    }
}
</script>
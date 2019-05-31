<template>
    <div>
        <h2>This is a Vue Component</h2>
        <p>Counter: {{counter}}</p>
        <button v-on:click="updateCounter">Update Counter</button>
    </div>
</template>

<script>
    export default {
        name: "App",
        data:function(){
            return{
                counter: 0
            }
        },
        methods:{
            updateCounter: function(){
                this.counter = this.counter + 1;
            }
        }
    }
</script>

<style scoped>

</style>
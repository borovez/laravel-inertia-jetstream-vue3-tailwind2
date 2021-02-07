<template>
    <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    ref="input">
</template>

<script>
    export default {
        props: {
            modelValue: {
                type: [String, Number],
                default: ''
            }
        },
        methods: {
            focus() {
                this.$refs.input.focus()
            }
        },
        emits: ['update:modelValue']
    }
</script>


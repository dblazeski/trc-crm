<template>
    <div v-if="errors.length">
        <ul class="list-disc">
            <div v-for="(error, key) in errors" :key="key">
                <li class="text-red-500">{{ error.join('. ') }}</li>
            </div>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        init_errors: Object
    },
    computed: {
        errors: function() {
            return Object.values(this.init_errors)
        }
    }
}
</script>

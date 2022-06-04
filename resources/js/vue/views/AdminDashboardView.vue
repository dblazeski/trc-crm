<template>
    <div class="divide-y gap-4 divide-solid divide-gray-400">
        <h1 class="mb-4 pb-1">Resources</h1>

        <div v-for="resource in resources"
            :key="resource.id"
            class="grid grid-cols-4 p-2">

            <div>{{ resource.title }}</div>

            <div v-if="resource.resource_type == 'file'">
                <button type="button"
                    @click="downloadFile(resource.id)"
                    class="underline"
                >
                    Download
                </button>
            </div>

            <div v-if="resource.resource_type == 'html'"></div>
            <div v-if="resource.resource_type == 'html'" class="pre" v-html="resource.snippet_description"></div>

            <div v-if="resource.resource_type == 'link'">
                <a :href="resource.link" :target="resource.link_in_new_tab ? '_blank' : '_self'"
                    class="underline">
                    Open {{ resource.link_in_new_tab }}
                </a>
            </div>

            <div class="text-sm space-x-2 items-center flex justify-end col-end-5">
                <button type="button" @click="edit(resource)" class="hover:underline">Edit</button>
                <button type="button" @click="destroy(resource)" class="hover:underline">Delete</button>
            </div>
        </div>
    </div>
</template>

<script>
import { saveAs } from 'file-saver'

export default {
    data() {
        return {
            resources: []
        }
    },
    beforeDestroy() {
        EventBus.$off('refresh-admin.dashboard')
    },
    created() {
        EventBus.$on('refresh-admin.dashboard', () => this.loadPage())
        this.loadPage();
    },
    methods: {
        loadPage: async function() {
            try {
                let res = await this.$http.get(`${this.$ApiUrl}/resources`)
                this.resources = res.data
            } catch(e) {
                console.log('error',e)
            }
        },
        edit(resource) {
            EventBus.$emit('show_new_upload_form', resource)
        },
        destroy(resource) {
            this.$http
                .post(`${this.$ApiUrl}/resources/destroy/${resource.id}`)
                .then(response => this.loadPage())
        },
        downloadFile(resource) {
            this.$http
                .get(`${this.$ApiUrl}/resources/download/${resource}`,{ responseType: 'blob' })
                .then(response => saveAs(response.data, resource.file))
                .catch(e => alert('File not found'))
        },
    }
}
</script>

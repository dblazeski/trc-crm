<template>
    <form @submit.prevent="store" action="POST" v-if="show_form">
        <div class="flex flex-col space-y-8 border border-gray-300 p-8 rounded mb-14">

            <div class="col-span-3 sm:col-span-2">
                <label for="resource_type" class="text-sm font-medium text-gray-700">
                    Resource type
                    <select v-model="resource_type"
                        class="block mt-1 border border-gray-300 rounded h-8 leading-6 px-2 w-1/3">
                        <option disabled value="">Please select the type of the resource</option>
                        <option v-for="resource_type in resource_types" :value="resource_type" :key="resource_type">
                            {{ resource_type }}
                        </option>
                    </select>
                </label>
            </div>

            <div class="col-span-3 sm:col-span-2" v-if="requiredInputs.includes('title')">
                <label for="title" class="text-sm font-medium text-gray-700">
                    Title
                    <input type="text"
                        class="block mt-1 border border-gray-300 rounded h-8 leading-6 px-2 w-1/3"
                        placeholder="The title of the resource"
                        v-model="title"
                    />
                </label>
            </div>

            <div class="col-span-3 sm:col-span-2" v-if="requiredInputs.includes('file')">
                <label for="pdf" class="text-sm font-medium text-gray-700">
                    PDF
                    <input type="file"
                        class="block mt-1 rounded h-8 leading-6 w-1/3"
                        @change="handleFileUpload"
                    />
                </label>
            </div>

            <div class="col-span-3 sm:col-span-2" v-if="requiredInputs.includes('snippet_description')">
                <label for="snippet_description" class="text-sm font-medium text-gray-700">
                    Snippet Description
                    <textarea rows="2"
                        cols="20"
                        class="block mt-1 border border-gray-300 rounded leading-6 px-2 w-1/3"
                        placeholder="Tell us what the file is"
                        v-model="snippet_description"
                    ></textarea>
                </label>
            </div>

            <div class="col-span-3 sm:col-span-2" v-if="requiredInputs.includes('snippet_html')">
                <label for="snippet_html" class="text-sm font-medium text-gray-700">
                    HTML Snippet
                    <textarea rows="4"
                        cols="20"
                        name="snippet_html"
                        class="block mt-1 border border-gray-300 rounded leading-6 px-2 w-1/3"
                        placeholder="Add any HTML. We will render is nicely"
                        v-model="snippet_html"
                    ></textarea>
                </label>
            </div>

            <div class="col-span-3 sm:col-span-2" v-if="requiredInputs.includes('link')">
                <label for="link" class="text-sm font-medium text-gray-700">
                    Link
                    <input type="text"
                        class="block mt-1 border border-gray-300 rounded h-8 leading-6 px-2 w-2/3"
                        v-model="link"
                        placeholder="Target url"
                    />
                </label>
                <label for="link_in_new_tab" class="text-sm font-medium text-gray-700 flex items-center mt-2">
                    <input type="checkbox"
                        class="block rounded h-8 leading-6 w-6 border-gray-400 mr-2"
                        v-model="link_in_new_tab"
                    />
                    Open in new tab
                </label>
            </div>

            <error-list :init_errors="errors"></error-list>

            <div class="col-span-3 sm:col-span-2">
                <button type="submit"
                    class="flex items-center bg-gray-50 border border-gray-400 py-1 px-2 rounded hover:bg-gray-100"
                >
                    Save
                </button>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    data() {
        return {
            errors: {},
            id: null,
            show_form: false,
            resource_type: '',
            resource_types: [
                'file',
                'html',
                'link'
            ],
            title: '',
            file: null,
            snippet_description: '',
            snippet_html: '',
            link: '',
            link_in_new_tab: ''
        }
    },
    created() {
        EventBus.$on('show_new_upload_form', (data = null) => {
            this.show_form = true;

            // Populate the form when editing
            if (data && data.id) {
                this.id = data.id
                this.resource_type = data.resource_type
                this.requiredInputs.forEach(input => this[input] = data[input]);
            }
        })
    },
    beforeDestroy() {
        EventBus.$off('show_new_upload_form')
    },
    computed: {
        requiredInputs() {
            if (!this.resource_type) {
                return []
            }

            const map = {
                'file': [ 'title', 'file' ],
                'html': [ 'title', 'snippet_description', 'snippet_html' ],
                'link': [ 'title', 'link', 'link_in_new_tab' ]
            }

            return map[this.resource_type]
        },
    },
    methods: {
        store: async function() {
            let formData = new FormData();
            formData.append('resource_type', this.resource_type)
            this.requiredInputs.forEach(input => formData.append(input, this[input]));

            const urlToPost = this.id
                ? `${this.$ApiUrl}/resources/update/${this.id}`
                : `${this.$ApiUrl}/resources`;

            try {
                let res = await this.$http.post(urlToPost,
                    formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })

                EventBus.$emit('refresh-admin.dashboard')
                this.show_form = false
            } catch(e){
                this.errors = e.response.data.errors || {}
                console.log(this.errors)
            }
        },
        handleFileUpload: function($event) {
            this.file = $event.target.files[0];
        }
    }
}
</script>

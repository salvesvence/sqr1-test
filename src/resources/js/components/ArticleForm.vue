<template>
    <div class="grid grid-cols-1">
        <form @submit.prevent="saveArticle">
            <div>
                <label class="block font-medium text-sm text-gray-700 mb-2" for="title">Title</label>
                <input
                    type="text" v-model="title" id="title"
                    class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mb-3"
                >
            </div>
            <div>
                <label class="block font-medium text-sm text-gray-700 mb-2" for="description">Description</label>
                <textarea
                    v-model="description" id="description"
                    class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mb-4"
                ></textarea>
            </div>
            <button type="submit" class="mb-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Save
                <spinner v-if="isLoading" class="text-white ml-3 h-3 w-3"></spinner>
                <check v-else></check>
            </button>
            <button @click="cancel" class="mb-4 ml-4 inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Cancel</button>
        </form>
    </div>
</template>

<script>

    import Check from "./Check";
    import Spinner from "./Spinner";

    export default {

        name: "ArticleForm",

        components: {
            Spinner,
            Check
        },

        data() {
            return {
                title: '',
                description: '',
                isLoading: false
            }
        },

        methods: {

            cancel() {
                this.emitter.emit('cancel');
            },

            saveArticle() {

                this.isLoading = true;

                axios.post('auth/articles', this.$data)
                    .then(response => {
                        toastr.success(response.data.message);
                        this.emitter.emit('reload-articles');
                        this.isLoading = false;
                    })
                    .catch(error => {
                        console.log(error.data);
                        this.isLoading = false;
                    });
            }
        }
    }

</script>

<template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-2">
            <div>
                <button @click="hideForm = false" class="mb-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Create New Article</button>
            </div>
            <div class="text-right">
                <button
                    @click="reverseArticlesOrder"
                    class="mb-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                >Reverse Article's Order By Publication Date
                </button>
            </div>
        </div>

        <article-form v-if="!hideForm"></article-form>

        <div v-if="articles" class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div
                v-for="article in articles"
                class="h-full bg-white rounded overflow-hidden shadow-md hover:shadow-lg relative smooth"
            >
                <a href="#" class="no-underline hover:no-underline">
                    <div class="p-6 h-auto md:h-48">
                        <p class="text-gray-600 text-xs md:text-sm mb-1.5">{{ article.published_at }}</p>
                        <div class="font-bold text-xl text-gray-900 mb-3 truncate">{{ article.title }}</div>
                        <div class="h-50">
                            <p class="text-gray-800 font-serif text-base line-clamp-3">
                                {{ article.description }}
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div v-else class="grid grid-cols-1 m-auto">
            <div class="w-full flex h-screen justify-center items-center" style="height: 192px">
                <spinner class="h-5 w-5 text-gray-800"></spinner>
            </div>
        </div>

        <div class="grid grid-cols-1" v-if="paginator">
            <div class="mt-6">

                <nav v-if="paginator.total > paginator.per_page" role="navigation" class="flex items-center justify-between">
                    <div class="flex justify-between flex-1 sm:hidden">
                        <a
                            v-if="paginator.prev_page_url" @click="getData(paginator.prev_page_url)"
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                        >
                            Previous Page
                        </a>
                        <span v-else class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                            Previous Page
                        </span>

                        <a
                            v-if="paginator.next_page_url" @click="getData(paginator.next_page_url)"
                            class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                        >
                            Next Page
                        </a>
                        <span v-else class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                            Next Page
                        </span>
                    </div>

                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700 leading-5">
                                Showing
                                <span class="font-medium">{{ paginator.from }}</span>
                                to
                                <span class="font-medium">{{ paginator.to }}</span>
                                of
                                <span class="font-medium">{{ paginator.total }}</span>
                                results
                            </p>
                        </div>

                        <div>
                            <span class="relative z-0 inline-flex shadow-sm rounded-md">
                                <a
                                    v-if="paginator.prev_page_url" @click="getData(paginator.prev_page_url)"
                                    rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="Previous"
                                >
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <span v-else aria-disabled="true" aria-label="Previous">
                                    <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5" aria-hidden="true">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </span>
                                <span aria-current="page" v-for="link in paginator.links">
                                    <a v-if="!isNaN(link.label)" @click="getData(link.url)"
                                       class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                                    >
                                        {{ link.label }}
                                    </a>
                                </span>
                                <a
                                    v-if="paginator.next_page_url" @click="getData(paginator.next_page_url)"
                                    rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="Next"
                                >
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <span v-else aria-disabled="true" aria-label="Next">
                                    <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5" aria-hidden="true">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </span>
                            </span>
                        </div>

                    </div>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>

    import ArticleForm from "./ArticleForm";
    import Spinner from "./Spinner";

    export default {

        name: "App",

        components: {
            Spinner,
            ArticleForm
        },

        data() {
            return {
                hideForm: true,
                articles: null,
                paginator: null,
                asc: false
            }
        },

        created() { this.getData() },

        mounted() {

            this.emitter.on('reload-articles', () => {
                this.hideForm = true;
                this.getData();
            });

            this.emitter.on('cancel', () => this.hideForm = true);
        },

        methods: {

            getData(url = 'auth/articles?page=1') {

                url = `${url}&sortBy=publication_date&direction=${this.asc ? 'asc' : 'desc' }`;

                this.articles = null;

                axios.get(url)
                    .then(response => {
                        this.paginator = response.data.articles;
                        this.articles = this.paginator.data;
                    })
                    .catch(error => {
                        console.log(error.data)
                    })
            },

            reverseArticlesOrder() {

                this.asc = !this.asc;

                this.getData();
            }
        }
    }

</script>

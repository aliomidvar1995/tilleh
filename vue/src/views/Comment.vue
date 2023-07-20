<template>
    <div class="container">
        <router-link :to="{ name: 'News' }">
            <v-btn class="ma-2" color="orange-darken-2">
                <v-icon start icon="mdi-arrow-left"></v-icon>
                Back
            </v-btn>
        </router-link>
        <v-form class="news-form" @submit.prevent="handleSubmit">
            <v-textarea label="Comment content" v-model="content"></v-textarea>
            <span class="error">{{ errors.content }}</span>
            <v-btn :loading="loading" type="submit" class="news-btn" text="Submit"></v-btn>
        </v-form>
        <v-card v-if="news" class="news-card">
            <v-img :src="news.image" cover></v-img>
            <h2 class="news-title">
                {{ news.title }}
            </h2>
            <p class="news-content">
                {{ news.content }}
            </p>
        </v-card>
        <template v-if="comments.length">
            <h2 class="text-center">Comments</h2>
            <v-card v-for="comment in comments" :key="comment.id" class="news-card">
                <p class="news-content">
                    {{ comment.content }}
                </p>
                <v-card-actions>
                    <v-btn>
                        <v-icon @click="handleDelete(comment.id)" icon="mdi-delete"></v-icon>
                    </v-btn>
                </v-card-actions>
                <div>
                    <v-btn @click="(e) => handleLike(e, comment.id)" variant="text" icon="mdi-thumb-up-outline"></v-btn>
                    <span>{{ comment.likes }}</span>

                    <v-btn @click="(e) => handleDislike(e, comment.id)" variant="text" icon="mdi-thumb-down-outline"></v-btn>
                    <span>{{ comment.dislikes }}</span>
                </div>
            </v-card>
        </template>
        <div class="text-center">
            <v-container>
                <v-row justify="center">
                    <v-col cols="8">
                        <v-container class="max-width">
                            <v-pagination @click="getComments" v-model="page" class="my-4" :length="length"></v-pagination>
                        </v-container>
                    </v-col>
                </v-row>
            </v-container>
        </div>
    </div>
</template>

<script setup>
import axiosInstance from "@/axios";
import { onMounted, ref } from "vue"


const props = defineProps(['news_id'])

const news = ref(null)

const loading = ref(false)

const content = ref('')

const comments = ref([])

const page = ref(1)

const length = ref(1)

const errors = ref({
    content: ''
})

function handleLike(e, id) {
    e.target.classList.add(`v-btn--disabled`)
    axiosInstance.put(`/comments/${id}`, {likes: 1})
    .then((res) => {
        getComments()
        e.target.classList.remove(`v-btn--disabled`)
    })
}

function handleDislike(e, id) {
    e.target.classList.add(`v-btn--disabled`)
    axiosInstance.put(`/comments/${id}`, {dislikes: 1})
    .then((res) => {
        getComments()
        e.target.classList.remove(`v-btn--disabled`)
    })
}

function getComments() {
    axiosInstance.get(`/news/${props.news_id}/comments?page=${page.value}`)
    .then((res) => {
        if (res.statusText === 'OK') {
            comments.value = res.data.data
            length.value = res.data.meta.last_page
        }
    })
}

function handleDelete(id) {
    axiosInstance.delete(`/comments/${id}`)
    .then((res) => {
        if(res.statusText === 'OK') {
            getComments()
        }
    })
}

onMounted(() => {
    axiosInstance.get(`/news/${props.news_id}`)
    .then((res) => {
        news.value = res.data
        getComments()
    })
})

function handleSubmit() {
    errors.value.content = ''
    loading.value = true;
    axiosInstance.post(`/comments`, { news_id: props.news_id, content: content.value })
    .then((res) => {
        loading.value = false
        if (res.statusText === 'OK') {
            getComments()
        }
    })
    .catch((err) => {
        if(err.response.data.errors.content) errors.value.content = err.response.data.errors.content[0]
        loading.value = false
    })
}

</script>

<style>

</style>
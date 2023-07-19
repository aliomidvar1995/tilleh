<template>
    <div class="container">
        <form class="news-form" @submit.prevent="handleSubmit">
            <v-file-input @change="onChange" label="News image"></v-file-input>
            <span class="error">{{ errors.image }}</span>
            <v-text-field clearable label="News title" v-model="title"></v-text-field>
            <span class="error">{{ errors.title }}</span>
            <v-textarea clearable label="News content" v-model="content"></v-textarea>
            <span class="error">{{ errors.content }}</span>
            <v-btn :loading="loading" type="submit" class="news-btn" text="Submit"></v-btn>
        </form>
        <template v-if="news.length">
            <v-card v-for="n in news" :key="n.id" class="news-card">
                <v-img :src="n.image" cover></v-img>
                <h2 class="news-title">
                    {{ n.title }}
                </h2>
                <p class="news-content">
                    {{ n.content }}
                </p>
                <router-link :to="{ name: 'Comment', params: { news_id: n.id } }">
                    <v-card-actions>
                        <v-btn>
                            <v-icon size="large" color="blue-darken-2" icon="mdi-message-text"></v-icon>
                        </v-btn>
                    </v-card-actions>
                </router-link>
                <div>
                    <v-btn @click="(e) => handleLike(e, n.id)" variant="text" icon="mdi-thumb-up-outline"></v-btn>
                    <span>{{ n.likes }}</span>

                    <v-btn @click="(e) => handleDislike(e, n.id)" variant="text" icon="mdi-thumb-down-outline"></v-btn>
                    <span>{{ n.dislikes }}</span>
                </div>
            </v-card>
        </template>
        <div class="text-center">
            <v-container>
                <v-row justify="center">
                    <v-col cols="8">
                        <v-container class="max-width">
                            <v-pagination @click="getNews" v-model="page" class="my-4" :length="length"></v-pagination>
                        </v-container>
                    </v-col>
                </v-row>
            </v-container>
        </div>
    </div>
</template>

<script setup>
import axiosInstance from '@/axios'
import { onMounted, ref } from 'vue';

const loading = ref(false)

const title = ref('')

const content = ref('')

const news = ref([])

const page = ref(1)

const length = ref(1)

const errors = ref({
    title: '',
    content: '',
    image: ''
})

const image = ref({})



function onChange(e) {
    image.value = e.target.files[0]
    console.log(image.value);
}

function getNews() {
    axiosInstance.get(`/news?page=${page.value}`)
        .then((res) => {
            news.value = res.data.data
            length.value = res.data.links.length - 2
        })
}


function handleLike(e, id) {
    e.target.classList.add(`v-btn--disabled`)
    axiosInstance.put(`/news/${id}`, {likes: 1})
    .then((res) => {
        getNews()
        e.target.classList.remove(`v-btn--disabled`)
    })
}

function handleDislike(e, id) {
    e.target.classList.add(`v-btn--disabled`)
    axiosInstance.put(`/news/${id}`, {dislikes: 1})
    .then((res) => {
        getNews()
        e.target.classList.remove(`v-btn--disabled`)
    })
}

function handleSubmit() {
    errors.value.title = ''
    errors.value.content = ''
    errors.value.image = ''
    loading.value = true;
    let fd = new FormData()
    fd.append('image', image.value)
    fd.append('title', title.value)
    fd.append('content', content.value)
    axiosInstance.post(`/news`,
        fd,
        {
            headers: { 'Content-Type': 'multipart/form-data' }
        }
    )
        .then((res) => {
            if (res.statusText === 'OK') {
                getNews()
            }
            loading.value = false;
        })
        .catch((err) => {
            if (err.response.data.errors.title) errors.value.title = err.response.data.errors.title[0]
            if (err.response.data.errors.content) errors.value.content = err.response.data.errors.content[0]
            if (err.response.data.errors.image) errors.value.image = err.response.data.errors.image[0]
            loading.value = false
        })

}

onMounted(() => {
    getNews()
})

</script>

<style>
.container {
    width: 60%;
    margin-inline: auto;
}

.news-form {
    display: flex;
    flex-direction: column;
    margin-top: 20px;
}

.news-btn {
    margin-inline: auto;
}

.news-card {
    margin-block: 10px;
}

a {
    text-decoration: none;
    color: black;
}

.news-title {
    margin: 20px;
}

.news-content {
    text-align: justify;
    margin: 20px;
}

.error {
    color: red;
}
</style>

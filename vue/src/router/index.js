// Composables
import { createRouter, createWebHistory } from 'vue-router'
import News from '@/views/News.vue'
import Comment from '@/views/Comment.vue'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'News',
            component: News,
            meta: {title: 'News'}
        },
        {
            path: '/news/:news_id/comments',
            name: 'Comment',
            component: Comment,
            meta: {title: 'Comment'},
            props: true
        },
    ],
})

router.beforeEach((to, from, next) => {
    document.title = to.meta.title;
    next();
})

export default router

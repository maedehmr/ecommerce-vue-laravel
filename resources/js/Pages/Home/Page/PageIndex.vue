<template>
    <home-layout>
        <div class="allPages width">
            <div class="allPagesTitle">
                <h1>{{page.title}}</h1>
            </div>
            <div class="allPagesBody">
                <p v-html="page.body"></p>
            </div>
        </div>
    </home-layout>
</template>

<script>
import HomeLayout from '../../../Layouts/Home/HomeLayout';
export default {
    components: { HomeLayout },
    props:['page','title'],
    metaInfo() {
        return {
            title: `${this.page.title} - ${this.title}`,
            htmlAttrs: {
                lang: 'fa',
                amp: true,
                reptilian: 'gator'
            },
            headAttrs: {
                nest: 'eggs'
            },
            meta: [
                { charset: 'utf-8' },
            ]
        }
    },
}
</script>

<style>

</style>

<template>
    <section class="allShowGallery">
        <div class="panelImage">
            <div class="detailGallery">
                <div class="imageNameDetail">
                    <svg-icon :icon="'#image'"></svg-icon>
                    <h3>{{image.name}}</h3>
                </div>
                <div class="titleDetailGallery">
                    <span>جزییات فایل</span>
                </div>
                <img :src="image.url" :alt="image.name">
                <div class="imageSubject">
                    <div class="imageSubjectItem">
                        <label>نوع :</label>
                        <span>{{image.type}}</span>
                    </div>
                    <div class="imageSubjectItem">
                        <label>سایز :</label>
                        <span>{{image.size}}</span>
                    </div>
                    <div class="imageSubjectItem">
                        <label>آدرس :</label>
                        <span>{{image.url}}</span>
                    </div>
                    <div class="imageSubjectItem">
                        <label>مسیر فایل :</label>
                        <span>{{image.path}}</span>
                    </div>
                    <div class="imageSubjectItem">
                        <label>تاریخ آپلود :</label>
                        <span>{{image.created_at}}</span>
                    </div>
                </div>
                <div class="sendImage">
                    <button @click.prevent="sendUrl(image.url)">انتخاب تصویر</button>
                </div>
            </div>
            <div class="showAllImage">
                <div class="topImage">
                    <div class="titleImage">
                        <h3>
                            <svg-icon :icon="'#align'"></svg-icon>
                            مدیریت فایل
                        </h3>
                        <div class="address">
                            <inertia-link href="/">خانه</inertia-link>
                            <span>/</span>
                            <inertia-link href="/admin">داشبورد</inertia-link>
                            <span>/</span>
                            <span>مدیریت فایل</span>
                        </div>
                    </div>
                    <div class="buttonsImage">
                        <i class="icon-002-image-file" v-if="index == 1" @click.prevent="getImage">
                            <svg-icon :icon="'#image'"></svg-icon>
                        </i>
                        <i class="icon-plus" @click.prevent="index = 1" v-if="index == 0">
                            <svg-icon :icon="'#plus'"></svg-icon>
                        </i>
                        <input v-model="search" type="text" placeholder="جستجو..." @keyup="btnSearch">
                        <button @click.prevent="btnSendClose">
                            <svg-icon :icon="'#cancel'"></svg-icon>
                        </button>
                    </div>
                </div>
                <div class="botNav">
                    <div class="images" v-if="index == 0">
                        <div class="loader" v-if="showLoader">
                            <img src="/img/loading.gif" alt="">
                        </div>
                        <div class="itemImages">
                            <select v-model="show">
                                <option value="0" @click="choice(show = 0)">همه</option>
                                <option value="1" @click="choice(show = 1)">تصاویر</option>
                                <option value="2" @click="choice(show = 2)">موزیک</option>
                                <option value="3" @click="choice(show = 3)">ویدیو</option>
                            </select>
                        </div>
                        <div class="allImages">
                            <ul>
                                <li v-for="item in galleries" @click.prevent="getUrl(item)">
                                    <img :src="item.url" alt="">
                                    <div class="subject">
                                        <svg-icon :icon="'#image'"></svg-icon>
                                        <span>{{item.name}}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="createImage" v-if="index == 1">
                        <dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" :useCustomSlot=true>
                            <div class="dropzone-custom-content">
                                <h3 class="dropzone-custom-title">برای بارگذاری محتوا ، بکشید و رها کنید!</h3>
                                <div class="subtitle">یا برای انتخاب پرونده از رایانه خود کلیک کنید ...</div>
                            </div>
                        </dropzone>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import SvgIcon from "../Svg/SvgIcon";
    import Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'
    import PaginatePanel from "./PaginatePanel";
    export default {
        name: "ShowImage",
        components: {
            PaginatePanel,
            SvgIcon,
            Dropzone
        },
        data(){
            return{
                dropzoneOptions: {
                    url: '/admin/gallery/create',
                    thumbnailWidth: 150,
                    maxFilesize: 120000,
                    headers: {'X-CSRF-TOKEN': document.head.querySelector("[name=csrf-token]").content}
                },
                settings: {
                    maxScrollbarLength: 70,
                },
                showLoader:false,
                showText1 : false,
                showTax : false,
                search : '',
                show : 0,
                index : 0,
                image : [],
                galleries : [],
                folders : [],
            }
        },
        methods:{
            choice() {
                this.showLoader = true;
                if (this.show == 0){
                    this.getImage();
                }else{
                    const url = '/admin/show-choice';
                    axios.post(url,{
                        show : this.show
                    })
                        .then(response=>{
                            this.showLoader = false;
                            this.galleries = response.data;
                        });
                }
            },
            getImage() {
                this.show = 0;
                this.index = 0;
                this.showLoader = true;
                const url = '/admin/get-image';
                axios.get(url)
                    .then(response=>{
                        this.showLoader = false;
                        this.galleries = response.data;
                        this.image = this.galleries[0];
                    });
            },
            btnSendClose(){
                this.$emit('sendClose');
            },
            btnSearch(){
                this.show = 0;
                if (this.search == ''){
                    this.getImage();
                }else{
                    this.showLoader = true;
                    const url = '/admin/search-gallery';
                    axios.post(url ,{
                        search: this.search
                    })
                        .then(response=>{
                            this.showLoader = false;
                            this.galleries = response.data;
                        })
                }
            },
            btnShowText1(index) {
                if (this.showText1 === index){
                    this.showText1 = false
                }else{
                    this.showText1 = index;
                }
            },
            getUrl(item){
                this.image = item;
            },
            sendUrl(url){
                this.$emit('sendUrl' , url)
                this.$emit('sendClose')
            },
            getPage(page){
                this.galleries = page;
            },
        },
        mounted() {
            this.getImage();
        }
    }
</script>

<style scoped>

</style>

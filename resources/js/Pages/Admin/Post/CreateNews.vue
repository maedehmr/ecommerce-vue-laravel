<template>
    <admin-layout>
        <div class="allCreatePost">
            <div class="allCreatePostData">
                <div class="allCreatePostSubject">
                    <div class="errorsCreate" v-if="Object.keys(errors).length > 0">
                        <span>
                            {{errors[Object.keys(errors)[0]][0]}}
                        </span>
                    </div>
                    <div class="allCreatePostItem">
                        <label>عنوان :</label>
                        <input type="text"  placeholder="عنوان را وارد کنید" v-model="form.title">
                    </div>
                    <div class="allCreatePostItem">
                        <label>توضیحات :</label>
                        <CKEditor
                            :editor="editor"
                            v-model="form.body"
                            :config="editorConfig"
                            @ready="onReady"
                        ></CKEditor>
                    </div>
                    <div class="sendGallery">
                        <show-image v-on:sendClose="getClose" v-if="showImage" v-on:sendUrl="getUrl"></show-image>
                        <div class="getImageItem" @click="showImage = !showImage">
                            <div class="getImagePic" v-if="form.image">
                                <img :src="form.image">
                            </div>
                            <span v-else>تصویر شاخص خود را وارد کنید</span>
                        </div>
                    </div>
                    <button class="button" @click="sendData">ارسال اطلاعات</button>
                </div>
                <div class="allCreatePostDetails">
                    <div class="allCreatePostDetail">
                        <div class="allCreatePostDetailItemsTitle" @click="checkShowDetail(2)">
                            وضعیت
                            <svg-icon :icon="'#up'" v-if="showDetail == 2"></svg-icon>
                            <svg-icon :icon="'#down'" v-else></svg-icon>
                        </div>
                        <transition name="slide-fade">
                            <div class="allCreatePostDetailItems" v-if="showDetail == 2">
                                <div class="allCreatePostDetailItem">
                                    <label>پیوند یکتا (slug) :</label>
                                    <input type="text"  placeholder="slug را وارد کنید" v-model="form.slug">
                                </div>
                                <div class="allCreatePostDetailItem">
                                    <label>مدت زمان مطالعه(دقیقه) :</label>
                                    <input type="text"  placeholder="مدت زمان مطالعه(دقیقه) را وارد کنید" v-model="form.time">
                                </div>
                                <div class="allCreatePostDetailItem">
                                    <label>وضعیت :</label>
                                    <div class="allCategoryPanel" @click.stop="showStatus = 2">
                                        <div class="categoryShow">
                                            <h4 v-if="form.status == null">وضعیت را وارد کنید ...</h4>
                                            <h4 v-if="form.status == 0">پیشنویس</h4>
                                            <h4 v-if="form.status == 1">منتشر شده</h4>
                                        </div>
                                        <ul v-if="showStatus == 2">
                                            <li @click.stop="sendStatus(0)">پیشنویس</li>
                                            <li @click.stop="sendStatus(1)">منتشر شده</li>
                                        </ul>
                                    </div>
                                </div>
                                <label for="s1d" class="allCreatePostDetailItemSuggest">
                                    تایید شده
                                    <input id="s1d" type="checkbox" class="switch" v-model="form.accept">
                                </label>
                                <label for="s2d" class="allCreatePostDetailItemSuggest">
                                    پیشنهادی
                                    <input id="s2d" type="checkbox" class="switch" v-model="form.suggest">
                                </label>
                            </div>
                        </transition>
                    </div>
                    <div class="allCreatePostDetail">
                        <div class="allCreatePostDetailItemsTitle">
                            تاکسونامی
                        </div>
                        <transition name="slide-fade">
                            <div class="allCreatePostDetailItems">
                                <div class="allCreatePostDetailItem">
                                    <label>دسته بندی :</label>
                                    <post-taxonami :taxes="categories" :taxRoute="'دسته بندی'" :tax="['0']"  v-on:sendTax="getCat"></post-taxonami>
                                </div>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import PostTaxonami from "./PostTaxonami";
import AdminLayout from "../../../Layouts/Admin/AdminLayout";
import SvgIcon from "../../Svg/SvgIcon";
import ShowImage from "../ShowImage";
import ClassicEditor from '@ckeditor/ckeditor5-build-decoupled-document';
import CKEditor from '@ckeditor/ckeditor5-vue2'
export default {
    name: "CreateNews",
    props: ['errors','categories'],
    metaInfo: {
        title: 'افزودن خبر',
        link: [
            { rel: 'stylesheet', href: '/css/admin.css' },
        ],
    },
    components:{
        AdminLayout,
        SvgIcon,
        ShowImage,
        PostTaxonami,
        CKEditor: CKEditor.component
    },
    data(){
        return{
            showDetail: false,
            showStatus:false,
            showImage: false,
            form:{
                time : null,
                slug : null,
                status : null,
                title : null,
                body : null,
                suggest : 0,
                accept : 0,
                allCategory: null,
                allTag: null,
            },
            csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            editor: ClassicEditor,
            editorConfig: {
                extraPlugins: [ MyCustomUploadAdapterPlugin ],
            },
        }
    },
    methods:{
        sendData(){
            const url = `/admin/news/create`;
            this.$inertia.post(url , this.form)
                .then(response=>{
                    if(Object.keys(this.errors).length <= 0){
                        this.$eventHub.emit('deleteTax');
                        this.form.time = null;
                        this.form.slug = null;
                        this.form.title = null;
                        this.form.body = '';
                        this.form.suggest = 0;
                        this.form.status = null;
                        this.form.image = null;
                        this.form.allCategory = null;
                        this.form.allTag = null;
                    }
                })
        },
        checkShowDetail(number){
            if(this.showDetail == number){
                this.showDetail = 0;
            }else{
                this.showDetail = number;
            }
        },
        sendStatus(number){
            this.form.status = number;
            this.showStatus = -1;
        },
        getClose(){
            this.showImage = false;
        },
        getUrl(url){
            this.form.image = url;
        },
        getCat(cat){
            this.form.allCategory = cat;
        },
        sidebars(){
            this.$eventHub.emit('sidebar' , [10,43]);
        },
        onReady( editor )  {
            editor.ui.getEditableElement().parentElement.insertBefore(
                editor.ui.view.toolbar.element,
                editor.ui.getEditableElement()
            );
        },
    },
    mounted(){
        this.sidebars();
    }
}
class MediaUploadAdapter {
    constructor(loader) {
        this.loader = loader;
    }

    upload() {
        return this.loader.file.then(uploadedFile => {
            return new Promise((resolve, reject) => {
                const formData = new FormData();
                formData.append('image', uploadedFile);

                axios.post('/admin/create/image', formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data;',
                            '_token': document.head.querySelector('meta[name="csrf-token"]'),
                        }
                    }
                ).then(response => {
                    if (response.status == 201) {
                        resolve( {
                            default: response.data.url
                        } );
                    } else {
                        reject(response.data.message);
                    }
                }).catch(error => {
                    console.log(error.response.status, error.response.data.message);
                });
            });
        });
    }

    abort() {
    }
}
function MyCustomUploadAdapterPlugin( editor ) {
    editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
        // Configure the URL to the upload script in your back-end here!
        return new MediaUploadAdapter( loader );
    };
}
</script>

<style scoped>

</style>

<template>
    <admin-layout>
        <div class="allCreatePost">
            <div class="allPostPanelTop">
                <h1>افزودن پست</h1>
                <div class="allPostTitle">
                    <inertia-link href="/admin">داشبورد</inertia-link>
                    <span>/</span>
                    <inertia-link href="/admin/post">همه پست ها</inertia-link>
                    <span>/</span>
                    <inertia-link href="/admin/post/create">افزودن پست</inertia-link>
                </div>
            </div>
            <div class="getDigikala">
                <label>کد محصول دیجیکالا :</label>
                <input type="text" v-model="digikala" placeholder="مثال : 272465">
                <button @click="btnGetDigikala">دریافت محصول</button>
            </div>
            <div class="allCreatePostData">
                <div class="allCreatePostSubject">
                    <div class="errorsCreate" v-if="Object.keys(errors).length > 0">
                        <span>
                            {{errors[Object.keys(errors)[0]][0]}}
                        </span>
                    </div>
                    <div class="allCreatePostItem">
                        <label>توضیحات :</label>
                        <CKEditor :editor="editor" @ready="onReady" :config="editorConfig" v-model="form.body"></CKEditor>
                    </div>
                    <div class="sendGallery">
                        <show-image v-on:sendClose="getClose" v-if="showImage" v-on:sendUrl="getUrl"></show-image>
                        <div class="getImageItem" @click="showImage = !showImage">
                            <span v-if="form.images.length == 0">تصویر شاخص خود را وارد کنید</span>
                            <div class="getImagePic" v-else v-for="(item , index) in form.images" :key="index">
                                <i @click.stop="deleteImage(index)">
                                    <svg-icon :icon="'#trash'"></svg-icon>
                                </i>
                                <img :src="item">
                            </div>
                        </div>
                    </div>
                    <div class="abilityPost">
                        <div class="abilityTitle">
                            <label>ویژگی‌های محصول</label>
                            <i @click="addAbility">
                                <svg-icon :icon="'#add'"></svg-icon>
                            </i>
                        </div>
                        <table class="abilityTable">
                            <tr>
                                <th>ویژگی‌های محصول</th>
                                <th>حذف</th>
                            </tr>
                            <tr v-for="(item, index) in form.abilities" :key="index">
                                <td>
                                    <input type="text" placeholder="ویژگی‌ را وارد کنید" v-model="item.name">
                                </td>
                                <td>
                                    <i @click="deleteAbility(index)">
                                        <svg-icon :icon="'#trash'"></svg-icon>
                                    </i>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="abilityPost">
                        <div class="abilityTitle">
                            <label>امتیاز به ویژگی‌</label>
                            <i @click="addRate">
                                <svg-icon :icon="'#add'"></svg-icon>
                            </i>
                        </div>
                        <table class="abilityTable">
                            <tr>
                                <th>ویژگی‌</th>
                                <th>امتیاز ( 0 , 4 )</th>
                                <th>حذف</th>
                            </tr>
                            <tr v-for="(item, index) in form.rates" :key="index">
                                <td>
                                    <input type="text" v-model="item.name" placeholder="ویژگی‌ را وارد کنید">
                                </td>
                                <td>
                                    <input type="range" v-model="item.rate" min="0" max="4">
                                </td>
                                <td>
                                    <i @click="deleteRate(index)">
                                        <svg-icon :icon="'#trash'"></svg-icon>
                                    </i>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="abilityPost">
                        <div class="abilityTitle">
                            <label>مشخصات‌</label>
                            <i @click="addProperties">
                                <svg-icon :icon="'#add'"></svg-icon>
                            </i>
                        </div>
                        <table class="abilityTable">
                            <tr>
                                <th>مشخصات‌</th>
                                <th>توضیح</th>
                                <th>حذف</th>
                            </tr>
                            <tr v-for="(item, index) in form.properties" :key="index">
                                <td>
                                    <input type="text" v-model="item.title" placeholder="مشخصات‌ را وارد کنید">
                                </td>
                                <td>
                                    <textarea v-model="item.body" placeholder="توضیح را وارد کنید"></textarea>
                                </td>
                                <td>
                                    <i @click="deleteProperties(index)">
                                        <svg-icon :icon="'#trash'"></svg-icon>
                                    </i>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <button class="button" @click="sendData">ارسال اطلاعات</button>
                </div>
                <div class="allCreatePostDetails">
                    <div class="allCreatePostDetail">
                        <div class="allCreatePostDetailItemsTitle" @click="checkShowDetail(1)">
                            جزییات
                            <svg-icon :icon="'#up'" v-if="showDetail == 1"></svg-icon>
                            <svg-icon :icon="'#down'" v-else></svg-icon>
                        </div>
                        <transition name="slide-fade">
                            <div class="allCreatePostDetailItems" v-if="showDetail == 1">
                                <div class="allCreatePostDetailItem">
                                    <label>عنوان :</label>
                                    <input type="text"  placeholder="عنوان را وارد کنید" v-model="form.title">
                                </div>
                                <div class="allCreatePostDetailItem">
                                    <label>عنوان انگلیسی :</label>
                                    <input type="text"  placeholder="عنوان را وارد کنید" v-model="form.titleEn">
                                </div>
                                <div class="allCreatePostDetailItem">
                                    <label>پیوند(slug) :</label>
                                    <input type="text"  placeholder="پیوند را وارد کنید" v-model="form.slug">
                                </div>
                                <div class="allCreatePostDetailItem">
                                    <label>توضیح اجمالی :</label>
                                    <textarea placeholder="توضیح را وارد کنید" v-model="form.summery"></textarea>
                                </div>
                            </div>
                        </transition>
                    </div>
                    <div class="allCreatePostDetail">
                        <div class="allCreatePostDetailItemsTitle" @click="checkShowDetail(3)">
                            اطلاعات بیشتر
                            <svg-icon :icon="'#up'" v-if="showDetail == 3"></svg-icon>
                            <svg-icon :icon="'#down'" v-else></svg-icon>
                        </div>
                        <transition name="slide-fade">
                            <div class="allCreatePostDetailItems" v-if="showDetail == 3">
                                <div class="allCreatePostDetailItem">
                                    <label>وضعیت :</label>
                                    <div class="allCategoryPanel" @click.stop="showStatus = !showStatus">
                                        <div class="categoryShow">
                                            <h4 v-if="form.status == null">وضعیت را وارد کنید ...</h4>
                                            <h4 v-if="form.status == 0">پیشنویس</h4>
                                            <h4 v-if="form.status == 1">منتشر شده</h4>
                                        </div>
                                        <ul v-if="showStatus">
                                            <li @click.stop="sendStatus(0)">پیشنویس</li>
                                            <li @click.stop="sendStatus(1)">منتشر شده</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="allCreatePostDetailItem">
                                    <label>درصد تخفیف(50) :</label>
                                    <input type="text" v-model="form.off" placeholder="تخفیف را وارد کنید">
                                </div>
                                <div class="allCreatePostDetailItem">
                                    <label>قیمت(تومان) :</label>
                                    <input type="text" v-model="form.price" placeholder="قیمت را وارد کنید">
                                </div>
                                <div class="allCreatePostDetailItem">
                                    <label>گارانتی :</label>
                                    <input type="text" v-model="form.guarantee" placeholder="گارانتی را وارد کنید">
                                </div>
                                <div class="allCreatePostDetailItem">
                                    <label>تعداد :</label>
                                    <input type="text" v-model="form.count" placeholder="تعداد را وارد کنید">
                                </div>
                                <div class="allCreatePostDetailItem">
                                    <label>پیشنهاد</label>
                                    <div class="timerItem">
                                        <date-picker
                                            v-model="form.suggest"
                                            type="datetime"
                                            format="YYYY-MM-DD HH:mm"
                                            display-format="jYYYY-jMM-jDD HH:mm"
                                            :timezone="true"
                                        />
                                        <i @click="form.suggest = ''" v-if="form.suggest">
                                            <svg-icon :icon="'#cancel'"></svg-icon>
                                        </i>
                                    </div>
                                </div>
                                <div class="allCreatePostDetailItem">
                                    <label for="s1d" class="allCreatePostDetailItemData">
                                        در ویترین آرشیو
                                        <input id="s1d" type="checkbox" class="switch" v-model="form.showcase">
                                    </label>
                                    <label for="s2d" class="allCreatePostDetailItemData">
                                        اصل
                                        <input id="s2d" type="checkbox" class="switch" v-model="form.original">
                                    </label>
                                    <label for="s3d" class="allCreatePostDetailItemData">
                                        کارکرده
                                        <input id="s3d" type="checkbox" class="switch" v-model="form.used">
                                    </label>
                                </div>
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
                                <div class="allCreatePostDetailItem">
                                    <label>سایز :</label>
                                    <post-taxonami :taxes="sizes" :taxRoute="'سایز'" :tax="['0']"  v-on:sendTax="getSize"></post-taxonami>
                                </div>
                                <div class="allCreatePostDetailItem">
                                    <label>رنگ :</label>
                                    <post-taxonami :taxes="colors" :taxRoute="'رنگ'" :tax="['0']"  v-on:sendTax="getColor"></post-taxonami>
                                </div>
                                <div class="allCreatePostDetailItem">
                                    <label>برند :</label>
                                    <post-taxonami :taxes="brands" :taxRoute="'برند'" :tax="['0']"  v-on:sendTax="getBrand"></post-taxonami>
                                </div>
                                <div class="allCreatePostDetailItem">
                                    <label>زمان :</label>
                                    <post-taxonami :taxes="times" :taxRoute="'زمان'" :tax="['0']"  v-on:sendTax="getTime"></post-taxonami>
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
import AdminLayout from '../../../Layouts/Admin/AdminLayout.vue'
import SvgIcon from '../../Svg/SvgIcon.vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-decoupled-document';
import CKEditor from '@ckeditor/ckeditor5-vue2'
import PostTaxonami from './PostTaxonami.vue';
import ShowImage from '../ShowImage.vue';
export default {
    props:['sidebar','errors','categories','brands','times','sizes','colors'],
    components: { AdminLayout, SvgIcon ,CKEditor: CKEditor.component, PostTaxonami, ShowImage },
    metaInfo: {
      title: 'افزودن پست',
        link: [
            { rel: 'stylesheet', href: '/css/admin.css' },
        ],
    },
    data(){
        return{
            showDetail: -1,
            showStatus:false,
            showImage: false,
            digikala : '',
            i : 0,
            form:{
                guarantee : null,
                summery : null,
                price : null,
                count : null,
                slug : null,
                status : null,
                title : null,
                titleEn : null,
                body : null,
                suggest : '',
                off : '',
                images : [],
                used: 0,
                original: 0,
                image : [],
                allAbility : [],
                allRate : [],
                allProperty : [],
                allCategory: null,
                allSize: null,
                allColor: null,
                allBrand: null,
                allTime: null,
                abilities: [],
                rates: [],
                properties:[],
                showcase: false
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
            this.form.image = JSON.stringify(this.form.images);
            this.form.allAbility = JSON.stringify(this.form.abilities);
            this.form.allRate = JSON.stringify(this.form.rates);
            this.form.allProperty = JSON.stringify(this.form.properties);
            const url = `/admin/post/create`;
            this.$inertia.post(url , this.form)
            .then(response=>{
                if(Object.keys(this.errors).length <= 0){
                    this.$eventHub.emit('deleteTax');
                    this.form.summery = null;
                    this.form.guarantee = null;
                    this.form.price = null;
                    this.form.abilities = [];
                    this.form.rates = [];
                    this.form.slug = null;
                    this.form.properties = [];
                    this.form.title = null;
                    this.form.body = '';
                    this.form.suggest = '';
                    this.form.showcase = 0;
                    this.form.used = 0;
                    this.form.original = 0;
                    this.form.status = null;
                    this.form.titleEn = null;
                    this.form.images = [];
                    this.form.off = null;
                    this.form.count = null;
                    this.form.allCategory = [];
                    this.form.allTime = [];
                    this.form.allSize = [];
                    this.form.allBrand = [];
                    this.form.allColor = [];
                }
            })
        },
        sidebars(){
            this.$eventHub.emit('sidebar' , [this.sidebar[0],this.sidebar[1]]);
        },
        btnGetDigikala(){
            const url = `/admin/post/get-digikala`;
            axios.post(url , {
                digikala: this.digikala
            })
                .then(response=>{
                    this.form.title = response.data[0].product.title_fa;
                    this.form.titleEn = response.data[0].product.title_en;
                    this.form.status = 1;
                    this.form.price = response.data[3];
                    this.form.count = 10;
                    this.form.summery = response.data[0].product.review.short_review;
                    this.form.body = response.data[0].product.review.description;
                    this.form.images = response.data[4];
                    if(response.data[0].product.specifications[0]['attributes']){
                        for ( this.i ; this.i < response.data[0].product.specifications[0]['attributes'].length; this.i++) {
                            this.form.abilities.push({
                                name:response.data[0].product.specifications[0]['attributes'][this.i].title + ' : ' + response.data[0].product.specifications[0]['attributes'][this.i].values[0],
                            });
                        }
                    }
                    this.i = 0;
                    for ( this.i ; this.i < response.data[0].product.specifications[0]['attributes'].length; this.i++) {
                        this.form.properties.push({
                            title:response.data[0].product.specifications[0]['attributes'][this.i].title,
                            body:response.data[0].product.specifications[0]['attributes'][this.i].values[0],
                        });
                    }
                    this.$eventHub.emit('getCats2' , response.data[2] , 'دسته بندی');
                    this.$eventHub.emit('getCats2' , response.data[1] , 'برند');
                })
        },
        checkShowDetail(number){
            if(this.showDetail == number){
                this.showDetail = 0;
            }else{
                this.showDetail = number;
            }
        },
        deleteRate(index){
            this.form.rates.splice(index,1);
        },
        deleteProperties(index){
            this.form.properties.splice(index,1);
        },
        deleteAbility(index){
            this.form.abilities.splice(index,1);
        },
        addAbility() {
            this.form.abilities.push({
                name:'',
            });
        },
        addRate() {
            this.form.rates.push({
                name:'',
                rate:2,
            });
        },
        addProperties() {
            this.form.properties.push({
                title:'',
                body:'',
            });
        },
        sendStatus(number){
            this.form.status = number;
            this.showStatus = false;
        },
        getClose(){
            this.showImage = false;
        },
        getUrl(url){
            this.form.images.push(url);
        },
        getCat(cat){
            this.form.allCategory = cat;
        },
        getBrand(brand){
            this.form.allBrand = brand;
        },
        getTime(time){
            this.form.allTime = time;
        },
        getColor(Color){
            this.form.allColor = Color;
        },
        getSize(Size){
            this.form.allSize = Size;
        },
        deleteImage(index){
            this.form.images.splice(index , 1);
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

                axios.post('/admin/gallery/create-image', formData,
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

<style>

</style>

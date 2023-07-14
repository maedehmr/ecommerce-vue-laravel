<template>
    <admin-layout>
        <div class="allPackPanel">
            <div class="allTaxonamiPanelTop">
                <h1>پک ها</h1>
                <div class="allTaxonamiTitle">
                    <inertia-link href="/admin">داشبورد</inertia-link>
                    <span>/</span>
                    <inertia-link href="/admin/pack">پک ها</inertia-link>
                </div>
            </div>
            <div class="allTaxonamiOptions">
                <div class="allTaxonamiOptionsButtons">
                    <button @click="openCreate" v-if="adds == 1">افزودن پک</button>
                    <button v-if="value.length && deletes == 1" @click="btnRemoveArray('')">حذف</button>
                </div>
                <div class="filterItems">
                    <div class="ContentOptionsFilterButton" @click.stop="showFilter = !showFilter">
                        <svg-icon :icon="'#filter'"></svg-icon>
                        فیلتر اطلاعات
                    </div>
                    <transition name="bounce">
                        <div class="filterContent" v-if="showFilter">
                            <div class="filterContentItem">
                                <label>فیلتر عنوان یا آیدی</label>
                                <input type="text" v-model="search"  placeholder="عنوان یا آیدی را وارد کنید" @keypress.enter="btnSearch(0)">
                            </div>
                            <div class="filterContentItem">
                                <label>فیلتر تاریخ</label>
                                <div class="allTicketPanelTitleDate">
                                    <date-picker
                                        v-model="date"
                                        type="datetime"
                                        format="YYYY-MM-DD"
                                        display-format="jYYYY-jMM-jDD"
                                        @close="btnSearch(0)"
                                        placeholder="تاریخ را وارد کنید"
                                        :timezone="true"
                                    />
                                    <i @click.stop="btnSearch(1)" v-if="date">
                                        <svg-icon :icon="'#cancel'"></svg-icon>
                                    </i>
                                </div>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
            <transition name="slide-fade">
                <div class="createTaxonamiPanel" v-if="show || taxEditData">
                    <div class="errorsCreate" v-if="Object.keys(errors).length > 0">
                        <span>
                            {{errors[Object.keys(errors)[0]][0]}}
                        </span>
                    </div>
                    <p>توضیحات پک و اطلاعات را اینجا وارد کنید</p>
                    <div class="allCreateTaxonamiItems">
                        <div class="allCreateTaxonamiItem">
                            <label>نام :</label>
                            <input type="text" placeholder="نام را وارد کنید ..." v-model="form.title">
                        </div>
                        <div class="allCreateTaxonamiItem">
                            <label>تعداد موجود :</label>
                            <input type="text" placeholder="تعداد را وارد کنید ..." v-model="form.count">
                        </div>
                        <div class="allCreateTaxonamiItem">
                            <label>پیوند :</label>
                            <input type="text" placeholder="پیوند را وارد کنید ..." v-model="form.slug">
                        </div>
                        <div class="allCreateTaxonamiItem">
                            <label>قیمت :</label>
                            <input type="text" placeholder="قیمت را وارد کنید ..." v-model="form.price">
                        </div>
                        <div class="allCreateTaxonamiItem">
                            <label>محصولات</label>
                            <div class="allTaxes">
                                <div class="taxShow" @click="showPosts= !showPosts">
                                        <h4 v-if="allPost.length == 0">محصولات را وارد کنید</h4>
                                        <ul v-else>
                                            <li v-for="(item , index) in allPost">
                                                <i @click.stop="btnClose(index)">
                                                    <svg-icon :icon="'#cancel'"></svg-icon>
                                                </i>
                                                <span>{{item}}</span>
                                            </li>
                                        </ul>
                                        <svg-icon :icon="'#down'"></svg-icon>
                                </div>
                                <ul class="showAllTaxes" v-if="showPosts">
                                    <li class="searchTax">
                                        <input v-model="search" type="text" placeholder="جستجو براساس عنوان" @keyup="btnSearch">
                                    </li>
                                    <VuePerfectScrollbar class="scroll-area">
                                        <li v-for="(item , index) in posts" @click.stop="sendTax(item.title , item.id)" :key="index">
                                            {{item.title}}
                                        </li>
                                    </VuePerfectScrollbar>
                                </ul>
                            </div>
                        </div>
                        <div class="sendGallery">
                            <show-image v-on:sendClose="getClose" v-if="showImage" v-on:sendUrl="getUrl"></show-image>
                            <div class="getImageItem" @click="showImage = !showImage">
                                <span v-if="form.image == ''">تصویر شاخص خود را وارد کنید</span>
                                <div class="getImagePic" v-else>
                                    <img :src="form.image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="buttons">
                        <button @click="sendCreate">ارسال اطلاعات</button>
                        <button @click="btnCancel">انصراف</button>
                    </div>
                </div>
            </transition>
            <div class="pages">
                <paginate-panel :link="packs.links"></paginate-panel>
            </div>
            <transition name="slide-fade" v-if="shows">
                <div class="showTable" v-if="show == false">
                    <all-table :table="packs.data" :labels="labels" :deletes="deletes" :shows="0" :edits="edits" v-on:sendCheck="getCheck" v-on:sendEdit="openEdit" v-on:sendDelete="btnRemoveArray"></all-table>
                </div>
            </transition>
            <div class="pages">
                <paginate-panel :link="packs.links"></paginate-panel>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import VuePerfectScrollbar from "vue-perfect-scrollbar";
import AdminLayout from "../../../Layouts/Admin/AdminLayout";
import AllTable from '../Table/AllTable.vue';
import SvgIcon from "../../Svg/SvgIcon";
import PaginatePanel from '../PaginatePanel.vue';
import ShowImage from "../ShowImage";
export default {
    name:'packPanel',
    metaInfo: {
      title: 'همه پک ها',
        link: [
            { rel: 'stylesheet', href: '/css/admin.css' },
        ],
    },
    components:{
        ShowImage,
        SvgIcon,
        AllTable,
        AdminLayout,
        VuePerfectScrollbar,
        PaginatePanel,
    },
    props: [
        'posts',
        'labels',
        'errors',
        'packs',
        'adds',
        'edits',
        'deletes',
        'shows',
        'packEdit',
    ],
    data(){
        return{
            showPosts: false,
            show: false,
            showImage: false,
            allPost :[],
            i:0,
            search : '',
            taxEditData:'',
            showFilter: false,
            value:[],
            settings: {
                maxScrollbarLength: 60
            },
            form:{
                price : null,
                slug : null,
                title : null,
                count : null,
                image : null,
                taxId : null,
                allPostId :[],
            },
        }
    },
    methods:{
        getClose(){
            this.showImage = false;
        },
        getUrl(url){
            this.form.image = url;
        },
        sendTax(title , id){
            this.form.allPostId.push(id);
            this.allPost.push(title);
        },
        btnClose(index){
            this.form.allPostId.splice(index , 1);
            this.allPost.splice(index , 1);
        },
        btnSearch(){

        },
        btnRemoveArray(id){
            if(id){
                this.value = [id]
            }
            this.$swal.fire({
                title: 'آیا مطمینی ؟',
                text: "فایل حذف شده برگشتی ندارد!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله حذف شود',
                cancelButtonText: 'پشیمون شدم'
            }).then((result) => {
                if (result.value) {
                    const url = `/admin/pack`;
                    this.$inertia.post(url ,{'value' : this.value})
                    .then(response => {
                            this.value = []
                        }
                    )
                }
            })
        },
        openEdit(id){
            this.i = 0;
            this.form.title = '';
            this.form.slug = '';
            this.form.price = '';
            this.form.image = '';
            this.form.count = '';
            this.form.allPostId = [];
            this.allPost = [];
            this.show = !this.show;
            const url = `/admin/pack`;
            this.$inertia.post(url,{
                taxId : id
            })
                .then(response=>{
                    this.taxEditData = this.packEdit;
                    this.form.title = this.taxEditData.title;
                    this.form.slug = this.taxEditData.slug;
                    this.form.price = this.taxEditData.price;
                    this.form.count = this.taxEditData.count;
                    this.form.image = this.taxEditData.image;
                    this.form.taxId = id;
                    for ( this.i ; this.i < this.taxEditData.post.length; this.i++) {
                        this.form.allPostId.push(this.taxEditData.post[this.i].id);
                        this.allPost.push(this.taxEditData.post[this.i].title);
                    }
                })
        },
        getCheck(id){
            this.value = id;
        },
        openCreate(){
            this.show = true;
            this.form.title = '';
            this.form.slug = '';
            this.form.price = '';
            this.form.taxId = '';
            this.form.allPostId = [];
            this.form.image = '';
            this.form.count = '';
            this.allPost = [];
        },
        btnCancel(){
            this.form.title = '';
            this.form.slug = '';
            this.form.price = '';
            this.form.taxId = '';
            this.form.allPostId = [];
            this.allPost = [];
            this.show = false;
            this.taxEditData = '';
            this.form.image = '';
            this.form.count = '';
        },
        sendCreate(){
            const url = `/admin/pack`;
            this.$inertia.post(url , this.form)
            .then(response =>{
                if (!this.errors.name){
                    this.form.title = '';
                    this.form.slug = '';
                    this.form.peice = '';
                    this.form.allPostId = [];
                    this.allPost = [];
                    this.show = false;
                    this.taxEditData = '';
                }
            })
        },
        sidebar(){
            this.$eventHub.emit('sidebar' , ['0','40']);
        },
    }
}
</script>

<style>

</style>

<template>
    <div class="allSurprisingIndex width">
        <div class="allSurprisingIndexOver" v-if="loading">
            <div class="loader">
                <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            </div>
        </div>
        <div class="allSurprisingIndexRight">
            <div class="allSurprisingIndexRightPic">
                <div class="offProduct" v-if="showSuggest.off">
                    <div class="offProductItem">
                        <svg-icon :icon="'#off-tag'"></svg-icon>
                        <div>
                            <span>٪{{showSuggest.off}}</span>
                        </div>
                    </div>
                </div>
                <hooper :settings="hooperSettings">
                    <slide v-for="item in JSON.parse(showSuggest.image)" :key="item.image">
                        <img v-lazy="item" :alt="showSuggest.title">
                    </slide>
                    <hooper-pagination slot="hooper-addons"></hooper-pagination>
                </hooper>
                <div class="allSurprisingIndexRightPicShape"></div>
            </div>
            <inertia-link :href="'/product/'+showSuggest.slug" class="allSurprisingSubject">
                <div class="allSurprisingSubjectTitle">
                    {{showSuggest.title}}
                    <span class="fake" v-if="showSuggest.original == 0">غیراصل</span>
                    <span class="original" v-if="showSuggest.original == 1">اصل</span>
                    <span class="used" v-if="showSuggest.used == 1">کارکرده</span>
                </div>
                <ul>
                    <li v-for="(item,index2) in JSON.parse(showSuggest.post_meta[0].ability).slice(0 , 3)" :key="index2">
                        <svg-icon :icon="'#checkmark'"></svg-icon>
                        <span>{{item.name}}</span>
                    </li>
                </ul>
                <div class="allSurprisingSubjectPrice">
                    <h4>{{showSuggest.price|NumFormat}}
                        <span>تومان</span>
                    </h4>
                    <s>{{showSuggest.offPrice|NumFormat}} تومان</s>
                </div>
                <div class="allSurprisingSubjectOptions">
                    <div class="allSurprisingSubjectOption" @click.prevent="btnBookmark(showSuggest.id)">
                        <svg-icon v-for="(values,index) in bookmark" :key="index" v-if="values == showSuggest.id" :icon="'#bookmark'"></svg-icon>
                        <svg-icon :icon="'#unbookmark'"></svg-icon>
                    </div>
                    <div class="allSurprisingSubjectOption" @click.prevent="btnLike(showSuggest.id)">
                        <svg-icon v-for="(values,index) in like" :key="index" v-if="values == showSuggest.id" :icon="'#like'"></svg-icon>
                        <svg-icon :icon="'#unlike'"></svg-icon>
                    </div>
                    <div class="allSurprisingSubjectOption" @click.prevent="btnShow(showSuggest.id)">
                        <svg-icon :icon="'#search'"></svg-icon>
                    </div>
                </div>
                <div class="allSurprisingSubjectButtons" v-if="showTab != 0">
                    <div class="allSurprisingSubjectButton" @click.prevent="show = 0">
                        <button class="active" v-if="show == 0">
                            <svg-icon :icon="'#clock'"></svg-icon>
                            زمان باقیمانده
                        </button>
                        <button v-else>زمان باقیمانده</button>
                    </div>
                    <div class="allSurprisingSubjectButton" @click.prevent="show = 1">
                        <button class="active" v-if="show == 1">
                            <svg-icon :icon="'#description'"></svg-icon>
                            جزییات
                        </button>
                        <button v-else>جزییات</button>
                    </div>
                    <div class="allSurprisingSubjectButton" @click.prevent="show = 2">
                        <button class="active" v-if="show == 2">
                            <svg-icon :icon="'#description'"></svg-icon>
                            توضیحات
                        </button>
                        <button v-else>توضیحات</button>
                    </div>
                </div>
                <div class="allSurprisingSubjectDetail" v-if="showTab != 0">
                    <div class="allSurprisingSubjectDetailTime" v-if="show == 0">
                        <div class="timer">
                            <flip-countdown :deadline="showSuggest.suggest"></flip-countdown>
                        </div>
                        <h5>زمان باقیمانده تا پایان پیشنهاد</h5>
                    </div>
                    <div class="allSurprisingSubjectDetailOptions" v-if="show == 1">
                        <div class="allSurprisingSubjectDetailOption">
                            <label>
                                <svg-icon :icon="'#shield'"></svg-icon>
                                گارانتی محصول :
                            </label>
                            <h4>{{showSuggest.post_meta[0].guarantee}}</h4>
                        </div>
                        <div class="allSurprisingSubjectDetailOption" v-if="showSuggest.color.length">
                            <label>
                                <svg-icon :icon="'#color'"></svg-icon>
                                رنگ های موجود :
                            </label>
                            <div class="swatch clearfix" data-option-index="1">
                                <div v-for="item in showSuggest.color.slice(0,3)" :key="item.name" class="swatch-element color blue available">
                                    <div class="tooltip">{{item.name}}</div>
                                    <input quickbeam="color" type="radio"/>
                                    <label :for="item.name">
                                        <span :style="{'background-color': item.code}"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="allSurprisingSubjectDetailOption" v-if="showSuggest.size.length">
                            <label>
                                <svg-icon :icon="'#size'"></svg-icon>
                                سایز های موجود :
                            </label>
                            <ul>
                                <li v-for="item in showSuggest.size.slice(0,3)" :key="item.id" :title="item.name">
                                    <h4>{{item.name}}</h4>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="allSurprisingSubjectDetailBody" v-if="show == 2">
                        <p>{{showSuggest.summery}}</p>
                    </div>
                </div>
            </inertia-link>
        </div>
        <div class="allSurprisingIndexList">
            <div class="allSurprisingListItems">
                <div class="allSurprisingListItem" v-for="item in getSuggest.slice(0,8)" :key="item.id" :title="item.title" @click.prevent="changeSuggest(item.id)">
                    <div class="active" v-if="showSuggest.id == item.id">
                        <h4>{{item.title}}</h4>
                    </div>
                    <div v-else><h4>{{item.title}}</h4></div>
                </div>
            </div>
            <div class="allSurprisingListMore">
                <inertia-link href="/archive/suggest">
                    <i>
                        <svg-icon :icon="'#right-arrow'"></svg-icon>
                    </i>
                    مشاهده همه
                </inertia-link>
            </div>
        </div>
    </div>
</template>

<script>
import SvgIcon from '../../Svg/SvgIcon';
import FlipCountdown from 'vue2-flip-countdown';
import 'hooper/dist/hooper.css';
import {
    Hooper,
    Slide,
    Pagination as HooperPagination,
} from 'hooper';
export default {
    components: {
        SvgIcon ,
        FlipCountdown,
        Hooper,
        Slide,
        HooperPagination,
    },
    props: ['getSuggest','showTab'],
    data(){
        return{
            showSuggest: this.getSuggest[0],
            like: [],
            bookmark: [],
            i: 0,
            show: 0,
            loading: false,
            notificationSystem: {
                options: {
                    show: {
                        icon: "icon-person",
                        position: "topCenter",
                    },
                    success: {
                        position: "bottomRight"
                    },
                    error: {
                        theme: "#FCA001",
                        progressBarColor: "#DC0808",
                        position: "bottomRight"
                    },
                }
            },
            hooperSettings: {
                wheelControl:false,
                centerMode: false,
                rtl: true,
                transition: 300,
                itemsToShow: 1,
                autoPlay:true,
                playSpeed : 5000
            },
        }
    },
    methods:{
        changeSuggest(id) {
            this.loading = true;
            const url = `/get-suggest-index`;
            axios.post(url,{
                postSuggestId : id
            })
                .then(response=>{
                    this.loading = false;
                    this.showSuggest = response.data;
                })
        },
        checkLike(item){
            this.like = item;
        },
        checkBookmark(item){
            this.bookmark = item;
        },
        btnLike(id){
            const url = `/like`;
            axios.post(url ,{
                postID : id
            })
                .then(response=>{
                    if (response.data === 'noUser'){
                        this.$toast.error('عضو نیستید', 'ابتدا عضو شوید', this.notificationSystem.options.error);
                        this.$eventHub.emit('getLike' , []);
                    }else{
                        if (response.data === 'delete'){
                            this.$eventHub.emit('allLike');
                        }else{
                            this.$toast.success('انجام شد', 'به علاقه مندی با موفقیت اضافه شد', this.notificationSystem.options.success);
                            this.like.push(response.data.post_id);
                            this.$eventHub.emit('getLike' , this.like);
                        }
                    }
                })
        },
        btnBookmark(id){
            const url = `/bookmark`;
            axios.post(url ,{
                postID : id
            })
                .then(response=>{
                    if (response.data === 'noUser'){
                        this.$toast.error('عضو نیستید', 'ابتدا عضو شوید', this.notificationSystem.options.error);
                        this.$eventHub.emit('getBookmark' , []);
                    }else {
                        if (response.data === 'delete') {
                            this.$eventHub.emit('allBookmark');
                        }else {
                            this.$toast.success('انجام شد', 'نشانه با موفقیت اضافه شد', this.notificationSystem.options.success);
                            this.bookmark.push(response.data.post_id);
                            this.$eventHub.emit('getBookmark' , this.bookmark);
                        }
                    }
                })
        },
        btnShow(id){
            this.$eventHub.emit('sendShow' , id);
        }
    },
    created: function() {
        this.$eventHub.on('getLike', this.checkLike);
        this.$eventHub.on('getBookmark', this.checkBookmark);
    },
}
</script>

<style>

</style>

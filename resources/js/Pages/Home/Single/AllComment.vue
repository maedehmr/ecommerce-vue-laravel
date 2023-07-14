<template>
    <div class="allComment">
        <div class="allCommentContainerSend" v-if="showSendLoader">
            <div class="allCommentContainerTop">
                <div class="allCommentContainerTopPic">
                    <img v-lazy="JSON.parse(posts.image)[0]" :alt="posts.title">
                </div>
                <div class="allCommentContainerTopItems">
                    <div class="allCommentContainerTopItemsTitle">
                        <h3>{{posts.title}}</h3>
                    </div>
                    <div class="allCommentContainerTopItemsRate">
                        <div class="allCommentContainerTopItemsRateItem" v-for="item in rates">
                            <label>{{item.name}}</label>
                            <div class="rateItemsCount">
                                <div class="rateItemsCountItem">
                                    <div class="rateItemsCountItemBarActive" v-if="item.rate >= 1"></div>
                                    <div class="rateItemsCountItemBar" v-if="item.rate == 0"></div>
                                    <div class="rateItemsCountItemCircleActives" @click.prevent="item.rate = 0" v-if="item.rate >= 1"></div>
                                    <div class="rateItemsCountItemCircleActive" @click.prevent="item.rate = 0" v-if="item.rate == 0"></div>
                                </div>
                                <div class="rateItemsCountItem">
                                    <div class="rateItemsCountItemBarActive" v-if="item.rate >= 2"></div>
                                    <div class="rateItemsCountItemBar" v-if="item.rate <= 1"></div>
                                    <div class="rateItemsCountItemCircleActives" @click.prevent="item.rate = 1" v-if="item.rate >= 2"></div>
                                    <div class="rateItemsCountItemCircleActive" @click.prevent="item.rate = 1" v-if="item.rate == 1"></div>
                                    <div class="rateItemsCountItemCircle" @click.prevent="item.rate = 1" v-if="item.rate <= 0"></div>
                                </div>
                                <div class="rateItemsCountItem">
                                    <div class="rateItemsCountItemBarActive" v-if="item.rate >= 3"></div>
                                    <div class="rateItemsCountItemBar" v-if="item.rate <= 2"></div>
                                    <div class="rateItemsCountItemCircleActives" @click.prevent="item.rate = 2" v-if="item.rate >= 3"></div>
                                    <div class="rateItemsCountItemCircleActive" @click.prevent="item.rate = 2" v-if="item.rate == 2"></div>
                                    <div class="rateItemsCountItemCircle" @click.prevent="item.rate = 2" v-if="item.rate <= 1"></div>
                                </div>
                                <div class="rateItemsCountItem">
                                    <div class="rateItemsCountItemBarActive" v-if="item.rate >= 4"></div>
                                    <div class="rateItemsCountItemBar" v-if="item.rate <= 3"></div>
                                    <div class="rateItemsCountItemCircleActives" @click.prevent="item.rate = 3" v-if="item.rate >= 4"></div>
                                    <div class="rateItemsCountItemCircleActive" @click.prevent="item.rate = 3" v-if="item.rate == 3"></div>
                                    <div class="rateItemsCountItemCircle" @click.prevent="item.rate = 3" v-if="item.rate <= 2"></div>
                                </div>
                                <div class="rateItemsCountItem">
                                    <div class="rateItemsCountItemCircleActive" @click.prevent="item.rate = 4" v-if="item.rate == 4"></div>
                                    <div class="rateItemsCountItemCircle" @click.prevent="item.rate = 4" v-if="item.rate <= 3"></div>
                                </div>
                                <span v-if="item.rate == 0">خیلی بد</span>
                                <span v-if="item.rate == 1">بد</span>
                                <span v-if="item.rate == 2">متوسط</span>
                                <span v-if="item.rate == 3">خوب</span>
                                <span v-if="item.rate == 4">عالی</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="allCommentContainerBottom">
                <div class="allCommentContainerBottomCoercion" v-if="coercion == 1">
                    <div class="allCommentContainerBottomCoercionItem">
                        <label>نام</label>
                        <label>
                            <input type="text" placeholder="نام را وارد کنید" v-model="UserName">
                        </label>
                    </div>
                    <div class="allCommentContainerBottomCoercionItem">
                        <label>ایمیل</label>
                        <label>
                            <input type="email" placeholder="ایمیل را وارد کنید" v-model="emailUser">
                        </label>
                    </div>
                </div>
                <div class="allCommentContainerBottomItem">
                    <label>عنوان</label>
                    <label>
                        <input type="text" placeholder="عنوان را وارد کنید" v-model="title">
                    </label>
                </div>
                <div class="allCommentContainerBottomItem">
                    <div class="allCommentContainerBottomItemTitle">
                        <i>
                            <svg-icon :icon="'#circle'"></svg-icon>
                        </i>
                        <label>نقاط قوت</label>
                    </div>
                    <label>
                        <input type="text" placeholder="نقطه قوت را وارد کنید" v-model="good" @keyup.enter="addGood">
                        <i @click.prevent="addGood" v-if="good">
                            <svg-icon :icon="'#add'"></svg-icon>
                        </i>
                    </label>
                    <span v-for="(item , index) in goods" :key="index">
                        {{item}}
                        <i @click.prevent="removeGood(index)">
                            <svg-icon :icon="'#cancel'"></svg-icon>
                        </i>
                    </span>
                </div>
                <div class="allCommentContainerBottomItem">
                    <div class="allCommentContainerBottomItemTitle">
                        <i>
                            <svg-icon :icon="'#circle'"></svg-icon>
                        </i>
                        <label>نقاط ضعف</label>
                    </div>
                    <label>
                        <input type="text" placeholder="نقطه ضعف را وارد کنید" v-model="bad" @keyup.enter="addBad">
                        <i @click.prevent="addBad" v-if="bad">
                            <svg-icon :icon="'#add'"></svg-icon>
                        </i>
                    </label>
                    <span v-for="(item , index) in bads" :key="index">
                        {{item}}
                        <i @click.prevent="removeBad(index)">
                            <svg-icon :icon="'#cancel'"></svg-icon>
                        </i>
                    </span>
                </div>
                <div class="allCommentContainerBottomItem">
                    <label>توضیحات</label>
                    <textarea v-model="body" placeholder="توضیحات را وارد کنید"></textarea>
                </div>
                <div class="allCommentContainerBottomSuggest">
                    <label>آیا خرید این محصول را به دوستانتان پیشنهاد می کنید؟</label>
                    <div class="allCategoryPanel" @click="showStatus = !showStatus">
                        <div class="categoryShow">
                            <h4 v-if="status == 0">در مورد خرید این محصول مطمئن نیستم</h4>
                            <h4 v-if="status == 1">خرید این محصول را توصیه نمی‌کنم</h4>
                            <h4 v-if="status == 2">خرید این محصول را توصیه می‌کنم</h4>
                            <i>
                                <svg-icon :icon="'#down'"></svg-icon>
                            </i>
                        </div>
                        <ul v-if="showStatus">
                            <li @click="status = 0">در مورد خرید این محصول مطمئن نیستم</li>
                            <li @click="status = 1">خرید این محصول را توصیه نمی‌کنم</li>
                            <li @click="status = 2">خرید این محصول را توصیه می‌کنم</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="allCommentButtons">
                <button @click.prevent="sendComment">
                    <i>
                        <svg-icon :icon="'#commentFront'"></svg-icon>
                    </i>
                    ارسال
                    <img src="/img/loaderHome.gif" alt="صبر کنید ..." v-if="showLoader">
                </button>
                <button @click.prevent="showSendLoader = !showSendLoader">انصراف</button>
            </div>
        </div>
        <div class="allCommentAllow" v-if="showSendLoader == false">
            <div class="allCommentAllowItem">
                <div class="allCommentAllowItemBtn">
                    <h5>شما هم می‌توانید در مورد این کالا نظر بدهید.</h5>
                    <p>برای ثبت نظر، لازم است ابتدا وارد حساب کاربری خود شوید.</p>
                    <button @click.prevent="showSendLoader = !showSendLoader">افزودن نظر جدید</button>
                </div>
                <div class="container">
                    <div class="feedback">
                        <div class="rating">
                            <input type="radio" value="5" id="5" v-model="rating">
                            <label @click="btnRating(5)" :for="rating"></label>
                            <input type="radio" value="4" id="4" v-model="rating">
                            <label @click="btnRating(4)" :for="rating"></label>
                            <input type="radio" value="3" id="3" v-model="rating">
                            <label @click="btnRating(3)" :for="rating"></label>
                            <input type="radio" value="2" id="2" v-model="rating">
                            <label @click="btnRating(2)" :for="rating"></label>
                            <input type="radio" value="1" id="1" v-model="rating">
                            <label @click="btnRating(1)" :for="rating"></label>
                            <div class="emoji-wrapper">
                                <div class="emoji">
                                    <svg class="rating-0" v-if="rating == 0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
                                    <path d="M512 256c0 141.44-114.64 256-256 256-80.48 0-152.32-37.12-199.28-95.28 43.92 35.52 99.84 56.72 160.72 56.72 141.36 0 256-114.56 256-256 0-60.88-21.2-116.8-56.72-160.72C474.8 103.68 512 175.52 512 256z" fill="#f4c534"/>
                                    <ellipse transform="scale(-1) rotate(31.21 715.433 -595.455)" cx="166.318" cy="199.829" rx="56.146" ry="56.13" fill="#fff"/>
                                    <ellipse transform="rotate(-148.804 180.87 175.82)" cx="180.871" cy="175.822" rx="28.048" ry="28.08" fill="#3e4347"/>
                                    <ellipse transform="rotate(-113.778 194.434 165.995)" cx="194.433" cy="165.993" rx="8.016" ry="5.296" fill="#5a5f63"/>
                                    <ellipse transform="scale(-1) rotate(31.21 715.397 -1237.664)" cx="345.695" cy="199.819" rx="56.146" ry="56.13" fill="#fff"/>
                                    <ellipse transform="rotate(-148.804 360.25 175.837)" cx="360.252" cy="175.84" rx="28.048" ry="28.08" fill="#3e4347"/>
                                    <ellipse transform="scale(-1) rotate(66.227 254.508 -573.138)" cx="373.794" cy="165.987" rx="8.016" ry="5.296" fill="#5a5f63"/>
                                    <path d="M370.56 344.4c0 7.696-6.224 13.92-13.92 13.92H155.36c-7.616 0-13.92-6.224-13.92-13.92s6.304-13.92 13.92-13.92h201.296c7.696.016 13.904 6.224 13.904 13.92z" fill="#3e4347"/>
                                    </svg>
                                    <svg class="rating-1" v-if="rating == 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
                                    <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/>
                                    <path d="M328.4 428a92.8 92.8 0 0 0-145-.1 6.8 6.8 0 0 1-12-5.8 86.6 86.6 0 0 1 84.5-69 86.6 86.6 0 0 1 84.7 69.8c1.3 6.9-7.7 10.6-12.2 5.1z" fill="#3e4347"/>
                                    <path d="M269.2 222.3c5.3 62.8 52 113.9 104.8 113.9 52.3 0 90.8-51.1 85.6-113.9-2-25-10.8-47.9-23.7-66.7-4.1-6.1-12.2-8-18.5-4.2a111.8 111.8 0 0 1-60.1 16.2c-22.8 0-42.1-5.6-57.8-14.8-6.8-4-15.4-1.5-18.9 5.4-9 18.2-13.2 40.3-11.4 64.1z" fill="#f4c534"/>
                                    <path d="M357 189.5c25.8 0 47-7.1 63.7-18.7 10 14.6 17 32.1 18.7 51.6 4 49.6-26.1 89.7-67.5 89.7-41.6 0-78.4-40.1-82.5-89.7A95 95 0 0 1 298 174c16 9.7 35.6 15.5 59 15.5z" fill="#fff"/>
                                    <path d="M396.2 246.1a38.5 38.5 0 0 1-38.7 38.6 38.5 38.5 0 0 1-38.6-38.6 38.6 38.6 0 1 1 77.3 0z" fill="#3e4347"/>
                                    <path d="M380.4 241.1c-3.2 3.2-9.9 1.7-14.9-3.2-4.8-4.8-6.2-11.5-3-14.7 3.3-3.4 10-2 14.9 2.9 4.9 5 6.4 11.7 3 15z" fill="#fff"/>
                                    <path d="M242.8 222.3c-5.3 62.8-52 113.9-104.8 113.9-52.3 0-90.8-51.1-85.6-113.9 2-25 10.8-47.9 23.7-66.7 4.1-6.1 12.2-8 18.5-4.2 16.2 10.1 36.2 16.2 60.1 16.2 22.8 0 42.1-5.6 57.8-14.8 6.8-4 15.4-1.5 18.9 5.4 9 18.2 13.2 40.3 11.4 64.1z" fill="#f4c534"/>
                                    <path d="M155 189.5c-25.8 0-47-7.1-63.7-18.7-10 14.6-17 32.1-18.7 51.6-4 49.6 26.1 89.7 67.5 89.7 41.6 0 78.4-40.1 82.5-89.7A95 95 0 0 0 214 174c-16 9.7-35.6 15.5-59 15.5z" fill="#fff"/>
                                    <path d="M115.8 246.1a38.5 38.5 0 0 0 38.7 38.6 38.5 38.5 0 0 0 38.6-38.6 38.6 38.6 0 1 0-77.3 0z" fill="#3e4347"/>
                                    <path d="M131.6 241.1c3.2 3.2 9.9 1.7 14.9-3.2 4.8-4.8 6.2-11.5 3-14.7-3.3-3.4-10-2-14.9 2.9-4.9 5-6.4 11.7-3 15z" fill="#fff"/>
                                    </svg>
                                    <svg class="rating-2" v-if="rating == 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
                                    <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/>
                                    <path d="M336.6 403.2c-6.5 8-16 10-25.5 5.2a117.6 117.6 0 0 0-110.2 0c-9.4 4.9-19 3.3-25.6-4.6-6.5-7.7-4.7-21.1 8.4-28 45.1-24 99.5-24 144.6 0 13 7 14.8 19.7 8.3 27.4z" fill="#3e4347"/>
                                    <path d="M276.6 244.3a79.3 79.3 0 1 1 158.8 0 79.5 79.5 0 1 1-158.8 0z" fill="#fff"/>
                                    <circle cx="340" cy="260.4" r="36.2" fill="#3e4347"/>
                                    <g fill="#fff">
                                        <ellipse transform="rotate(-135 326.4 246.6)" cx="326.4" cy="246.6" rx="6.5" ry="10"/>
                                        <path d="M231.9 244.3a79.3 79.3 0 1 0-158.8 0 79.5 79.5 0 1 0 158.8 0z"/>
                                    </g>
                                    <circle cx="168.5" cy="260.4" r="36.2" fill="#3e4347"/>
                                    <ellipse transform="rotate(-135 182.1 246.7)" cx="182.1" cy="246.7" rx="10" ry="6.5" fill="#fff"/>
                                    </svg>
                                    <svg class="rating-3" v-if="rating == 3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
                                <path d="M407.7 352.8a163.9 163.9 0 0 1-303.5 0c-2.3-5.5 1.5-12 7.5-13.2a780.8 780.8 0 0 1 288.4 0c6 1.2 9.9 7.7 7.6 13.2z" fill="#3e4347"/>
                                <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/>
                                <g fill="#fff">
                                <path d="M115.3 339c18.2 29.6 75.1 32.8 143.1 32.8 67.1 0 124.2-3.2 143.2-31.6l-1.5-.6a780.6 780.6 0 0 0-284.8-.6z"/>
                                <ellipse cx="356.4" cy="205.3" rx="81.1" ry="81"/>
                                </g>
                                <ellipse cx="356.4" cy="205.3" rx="44.2" ry="44.2" fill="#3e4347"/>
                                <g fill="#fff">
                                <ellipse transform="scale(-1) rotate(45 454 -906)" cx="375.3" cy="188.1" rx="12" ry="8.1"/>
                                <ellipse cx="155.6" cy="205.3" rx="81.1" ry="81"/>
                                </g>
                                <ellipse cx="155.6" cy="205.3" rx="44.2" ry="44.2" fill="#3e4347"/>
                                <ellipse transform="scale(-1) rotate(45 454 -421.3)" cx="174.5" cy="188" rx="12" ry="8.1" fill="#fff"/>
                                    </svg>
                                    <svg class="rating-4" v-if="rating == 4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <circle cx="256" cy="256" r="256" fill="#ffd93b"/>
                                    <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534"/>
                                    <path d="M232.3 201.3c0 49.2-74.3 94.2-74.3 94.2s-74.4-45-74.4-94.2a38 38 0 0 1 74.4-11.1 38 38 0 0 1 74.3 11.1z" fill="#e24b4b"/>
                                    <path d="M96.1 173.3a37.7 37.7 0 0 0-12.4 28c0 49.2 74.3 94.2 74.3 94.2C80.2 229.8 95.6 175.2 96 173.3z" fill="#d03f3f"/>
                                    <path d="M215.2 200c-3.6 3-9.8 1-13.8-4.1-4.2-5.2-4.6-11.5-1.2-14.1 3.6-2.8 9.7-.7 13.9 4.4 4 5.2 4.6 11.4 1.1 13.8z" fill="#fff"/>
                                    <path d="M428.4 201.3c0 49.2-74.4 94.2-74.4 94.2s-74.3-45-74.3-94.2a38 38 0 0 1 74.4-11.1 38 38 0 0 1 74.3 11.1z" fill="#e24b4b"/>
                                    <path d="M292.2 173.3a37.7 37.7 0 0 0-12.4 28c0 49.2 74.3 94.2 74.3 94.2-77.8-65.7-62.4-120.3-61.9-122.2z" fill="#d03f3f"/>
                                    <path d="M411.3 200c-3.6 3-9.8 1-13.8-4.1-4.2-5.2-4.6-11.5-1.2-14.1 3.6-2.8 9.7-.7 13.9 4.4 4 5.2 4.6 11.4 1.1 13.8z" fill="#fff"/>
                                    <path d="M381.7 374.1c-30.2 35.9-75.3 64.4-125.7 64.4s-95.4-28.5-125.8-64.2a17.6 17.6 0 0 1 16.5-28.7 627.7 627.7 0 0 0 218.7-.1c16.2-2.7 27 16.1 16.3 28.6z" fill="#3e4347"/>
                                    <path d="M256 438.5c25.7 0 50-7.5 71.7-19.5-9-33.7-40.7-43.3-62.6-31.7-29.7 15.8-62.8-4.7-75.6 34.3 20.3 10.4 42.8 17 66.5 17z" fill="#e24b4b"/>
                                    </svg>
                                    <svg class="rating-5" v-if="rating == 5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <g fill="#ffd93b">
                                        <circle cx="256" cy="256" r="256"/>
                                        <path d="M512 256A256 256 0 0 1 56.8 416.7a256 256 0 0 0 360-360c58 47 95.2 118.8 95.2 199.3z"/>
                                    </g>
                                    <path d="M512 99.4v165.1c0 11-8.9 19.9-19.7 19.9h-187c-13 0-23.5-10.5-23.5-23.5v-21.3c0-12.9-8.9-24.8-21.6-26.7-16.2-2.5-30 10-30 25.5V261c0 13-10.5 23.5-23.5 23.5h-187A19.7 19.7 0 0 1 0 264.7V99.4c0-10.9 8.8-19.7 19.7-19.7h472.6c10.8 0 19.7 8.7 19.7 19.7z" fill="#e9eff4"/>
                                    <path d="M204.6 138v88.2a23 23 0 0 1-23 23H58.2a23 23 0 0 1-23-23v-88.3a23 23 0 0 1 23-23h123.4a23 23 0 0 1 23 23z" fill="#45cbea"/>
                                    <path d="M476.9 138v88.2a23 23 0 0 1-23 23H330.3a23 23 0 0 1-23-23v-88.3a23 23 0 0 1 23-23h123.4a23 23 0 0 1 23 23z" fill="#e84d88"/>
                                    <g fill="#38c0dc">
                                        <path d="M95.2 114.9l-60 60v15.2l75.2-75.2zM123.3 114.9L35.1 203v23.2c0 1.8.3 3.7.7 5.4l116.8-116.7h-29.3z"/>
                                    </g>
                                    <g fill="#d23f77">
                                        <path d="M373.3 114.9l-66 66V196l81.3-81.2zM401.5 114.9l-94.1 94v17.3c0 3.5.8 6.8 2.2 9.8l121.1-121.1h-29.2z"/>
                                    </g>
                                    <path d="M329.5 395.2c0 44.7-33 81-73.4 81-40.7 0-73.5-36.3-73.5-81s32.8-81 73.5-81c40.5 0 73.4 36.3 73.4 81z" fill="#3e4347"/>
                                    <path d="M256 476.2a70 70 0 0 0 53.3-25.5 34.6 34.6 0 0 0-58-25 34.4 34.4 0 0 0-47.8 26 69.9 69.9 0 0 0 52.6 24.5z" fill="#e24b4b"/>
                                    <path d="M290.3 434.8c-1 3.4-5.8 5.2-11 3.9s-8.4-5.1-7.4-8.7c.8-3.3 5.7-5 10.7-3.8 5.1 1.4 8.5 5.3 7.7 8.6z" fill="#fff" opacity=".2"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="allCommentContainerGet">
            <div class="allCommentContainerGetTitle">
                <i>
                    <svg-icon :icon="'#down'"></svg-icon>
                </i>
                <span>نظرات کاربران</span>
            </div>
            <div class="allCommentContainerGetItems">
                <div class="showGetLoader" v-if="showGetLoader">
                    <img src="/img/loading.gif" alt="loading">
                </div>
                <div class="paginate" v-if="comments.links">
                    <div class="allPaginatePanel" v-if="comments.links.length != 3">
                        <div class="pageItem" v-for="(item,index) in comments.links" :key="index">
                            <div class="pageItemLabel" v-if="item.label == 'Previous' || item.label == 'Next'">
                                <div v-if="item.label == 'Previous' && item.url != null" @click="sendPage(item.url)"><svg-icon :icon="'#right'"></svg-icon></div>
                                <div v-if="item.label == 'Next' && item.url != null" @click="sendPage(item.url)"><svg-icon :icon="'#left'"></svg-icon></div>
                            </div>
                            <div class="pageItemLabel" v-else>
                                <div v-if="item.active == true" class="active" @click="sendPage(item.url)">{{item.label}}</div>
                                <div v-else @click="sendPage(item.url)">{{item.label}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="allCommentContainerGetItem" v-for="(item , index) in comments.data" :key="index">
                    <div class="allCommentContainerGetUser">
                        <div class="allCommentContainerUser">
                            <div class="allCommentContainerUserPic" v-if="showUser == 0 || showUser== 2">
                                <img v-if="item.user.profile == null" src="/img/user.png" :alt="item.user.name">
                                <img v-else :src="item.user.profile" :alt="item.user.name">
                            </div>
                            <div class="allCommentContainerUserName" v-if="showUser == 0 || showUser== 1">
                                {{item.user.name}}
                            </div>
                            <div class="allCommentContainerUserOnline" v-if="checkOnline == 1">
                                <span>زمان آنلاین بودن :</span>
                                <span>{{item.user.activity}}</span>
                            </div>
                        </div>
                        <div class="allCommentContainerCreated">
                            <span>{{item.created_at}}</span>
                        </div>
                        <div class="allCommentContainerStatusUnknown" v-if="item.status == 0">
                            <span>در مورد خرید این محصول مطمئن نیستم</span>
                        </div>
                        <div class="allCommentContainerStatusBad" v-if="item.status == 1">
                            <i>
                                <svg-icon :icon="'#likeDown'"></svg-icon>
                            </i>
                            <span>خرید این محصول را توصیه نمی‌کنم</span>
                        </div>
                        <div class="allCommentContainerStatusGood" v-if="item.status == 2">
                            <i>
                                <svg-icon :icon="'#likeUp'"></svg-icon>
                            </i>
                            <span>خرید این محصول را توصیه می‌کنم</span>
                        </div>
                        <div class="allCommentContainerRate" v-if="JSON.parse(item.rate).length">
                            <label>امتیاز کاربر</label>
                            <div class="allCommentContainerRateContainer">
                                <div class="allCommentContainerRateContainerItem" v-for="(value,index2) in JSON.parse(item.rate)" :key="index2">
                                    <span>{{value.name}}</span>
                                    <div class="allSingleHomeDetailBodyItemRate">
                                        <div class="allSingleHomeDetailBodyItemRateValue" :style="{'width' : value.rate * '25' +'%'}"></div>
                                    </div>
                                    <span v-if="value.rate == 0">خیلی بد</span>
                                    <span v-if="value.rate == 1">بد</span>
                                    <span v-if="value.rate == 2">متوسط</span>
                                    <span v-if="value.rate == 3">خوب</span>
                                    <span v-if="value.rate == 4">عالی</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="allCommentContainerGetBody">
                        <div class="allCommentTitle">
                            {{item.title}}
                        </div>
                        <div class="allCommentBody">
                            <p>{{item.body}}</p>
                        </div>
                        <div class="allCommentGoodItemsContainer">
                            <label>نقاط قوت</label>
                            <div class="allCommentGoodItems">
                                <div class="allCommentGoodItem" v-for="(value,index3) in JSON.parse(item.good)" :key="index3">
                                    <i>
                                        <svg-icon :icon="'#circle'"></svg-icon>
                                    </i>
                                    {{value}}
                                </div>
                            </div>
                        </div>
                        <div class="allCommentBadItemsContainer">
                            <label>نقاط ضعف</label>
                            <div class="allCommentBadItems">
                                <div class="allCommentBadItem" v-for="(value,index3) in JSON.parse(item.bad)" :key="index3">
                                    <i>
                                        <svg-icon :icon="'#circle'"></svg-icon>
                                    </i>
                                    {{value}}
                                </div>
                            </div>
                        </div>
                        <div class="allCommentContainerAnswer" v-if="replyAllow == 1">
                            <div class="allCommentContainerAnswerTitle" v-if="showReply != index" @click.prevent="showReply = index">
                                <i>
                                    <svg-icon :icon="'#reply'"></svg-icon>
                                </i>
                                <span>پاسخ</span>
                            </div>
                            <div class="allCommentContainerAnswerBody" v-if="showReply == index">
                                <div class="allCommentContainerAnswerBodyBtn">
                                    <div class="allCommentContainerAnswerBodyBtnItem">
                                        <i>
                                            <svg-icon :icon="'#reply'"></svg-icon>
                                        </i>
                                        <span>پاسخ</span>
                                    </div>
                                    <div class="allCommentContainerAnswerBodyBtnItem">
                                        <button @click.prevent="sendReply(item.id)">ارسال</button>
                                        <button @click.prevent="showReply = -1">انصراف</button>
                                    </div>
                                </div>
                                <label>
                                    <textarea placeholder="پاسخ را وارد کنید" v-model="reply"></textarea>
                                </label>
                            </div>
                        </div>
                        <div class="allCommentContainerReply">
                            <div class="allCommentContainerReplyItem" v-for="(child,index4) in item.comments" :key="index4">
                                <div class="allCommentContainerReplyItemUser">
                                    <div class="allCommentContainerReplyItemUserPic" v-if="showUser == 0 || showUser== 2">
                                        <img v-if="child.user.profile == null" :src="child.user.profile_photo_url" :alt="child.user.name">
                                        <img v-else :src="child.user.profile" :alt="child.user.name">
                                    </div>
                                    <div class="allCommentContainerReplyItemUserName" v-if="showUser == 0 || showUser== 1">
                                        {{child.user.name}}
                                    </div>
                                    <div class="allCommentContainerReplyItemUserOnline" v-if="checkOnline == 1">
                                        <span>زمان آنلاین بودن :</span>
                                        <span>{{child.user.activity}}</span>
                                    </div>
                                </div>
                                <div class="allCommentContainerReplyItemP">
                                    <p>
                                        {{child.body}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="paginate" v-if="comments.links">
                    <div class="allPaginatePanel" v-if="comments.links.length != 3">
                        <div class="pageItem" v-for="(item,index) in comments.links" :key="index">
                            <div class="pageItemLabel" v-if="item.label == 'Previous' || item.label == 'Next'">
                                <div v-if="item.label == 'Previous' && item.url != null" @click="sendPage(item.url)"><svg-icon :icon="'#right'"></svg-icon></div>
                                <div v-if="item.label == 'Next' && item.url != null" @click="sendPage(item.url)"><svg-icon :icon="'#left'"></svg-icon></div>
                            </div>
                            <div class="pageItemLabel" v-else>
                                <div v-if="item.active == true" class="active" @click="sendPage(item.url)">{{item.label}}</div>
                                <div v-else @click="sendPage(item.url)">{{item.label}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SvgIcon from "../../Svg/SvgIcon";
export default {
    name: "AllComment",
    props: ['rate','posts','errors' , 'replyAllow' , 'showUser' , 'coercion' , 'checkOnline'],
    components:{
        SvgIcon,
    },
    data(){
        return{
            rates : [],
            comments : [],
            i : 0,
            status : 0,
            showLoader : false,
            showStatus : false,
            showReply : -1,
            showGetLoader : false,
            showSendLoader : false,
            good : '',
            title : '',
            UserName : '',
            emailUser : '',
            body : '',
            reply : '',
            goods : [],
            bad : '',
            bads : [],
            rating: 0,
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
        }
    },
    methods:{
        btnRating(number){
            if(this.rating == 0){
                this.rating = number;
                const url = `/rate`;
                axios.post(url ,{
                    post_id : this.posts.id,
                    rate_post : number,
                })
                    .then(response=>{
                        if (response.data == 'noUser'){
                            this.$toast.error('عضو نیستید', 'ابتدا عضو شوید', this.notificationSystem.options.error);
                            this.rating = 0;
                        }
                        if (response.data == 'found'){

                        }
                        if (response.data != 'found' && response.data != 'noUser'){
                            this.$toast.success('ارسال شد', 'ممنون از نظر دادن شما', this.notificationSystem.options.success);
                            this.rating = response.data[0];
                            this.$emit('allRate' , response.data[1]);
                        }
                    })
            }
        },
        sendComment(){
            if (this.body != ''){
                if (this.coercion == 1){
                    if (this.emailUser != '' || this.UserName != ''){
                        this.showLoader =true;
                        let rate = JSON.stringify(this.rates);
                        let bads = JSON.stringify(this.bads);
                        let goods = JSON.stringify(this.goods);
                        const url = `/send-comment`;
                        axios.post(url , {
                            rate : rate,
                            bads : bads,
                            goods : goods,
                            status : this.status,
                            title : this.title,
                            post : this.posts,
                            emailUser : this.emailUser,
                            UserName : this.UserName,
                            body : this.body,
                        })
                            .then(response =>{
                                if (response.data == 'noUser'){
                                    this.$toast.error('عضو نیستید', 'ابتدا عضو شوید', this.notificationSystem.options.error);
                                }
                                if (response.data == 'limit'){
                                    this.$toast.error('انجام نشد', 'بیش از حد دیدگاه ارسال کردید', this.notificationSystem.options.error);
                                }
                                if (response.data == 'badWord'){
                                    this.$toast.error('انجام نشد', 'از الفاظ توهین آمیز استفاده نکنید', this.notificationSystem.options.error);
                                }
                                if (response.data == 'success'){
                                    this.$toast.success('ارسال شد', 'دیدگاه بعد تایید نمایش داده میشود', this.notificationSystem.options.success);
                                    this.bads = [];
                                    this.goods = [];
                                    this.title = '';
                                    this.body = '';
                                    this.emailUser = '';
                                    this.UserName = '';
                                    this.good = '';
                                    this.bad = '';
                                    this.getComment();
                                }
                                this.showLoader = false
                            })
                    }
                }else{
                    this.showLoader =true;
                    let rate = JSON.stringify(this.rates);
                    let bads = JSON.stringify(this.bads);
                    let goods = JSON.stringify(this.goods);
                    const url = `/send-comment`;
                    axios.post(url , {
                        rate : rate,
                        bads : bads,
                        goods : goods,
                        status : this.status,
                        title : this.title,
                        post : this.posts,
                        emailUser : null,
                        UserName : null,
                        body : this.body,
                    })
                        .then(response =>{
                            if (response.data == 'noUser'){
                                this.$toast.error('عضو نیستید', 'ابتدا عضو شوید', this.notificationSystem.options.error);
                            }
                            if (response.data == 'limit'){
                                this.$toast.error('انجام نشد', 'بیش از حد دیدگاه ارسال کردید', this.notificationSystem.options.error);
                            }
                            if (response.data == 'badWord'){
                                this.$toast.error('انجام نشد', 'از الفاظ توهین آمیز استفاده نکنید', this.notificationSystem.options.error);
                            }
                            if (response.data == 'success'){
                                this.$toast.success('ارسال شد', 'دیدگاه بعد تایید نمایش داده میشود', this.notificationSystem.options.success);
                                this.bads = [];
                                this.goods = [];
                                this.title = '';
                                this.body = '';
                                this.good = '';
                                this.emailUser = '';
                                this.UserName = '';
                                this.bad = '';
                                this.getComment();
                            }
                            this.showLoader = false
                        })
                }
            }
        },
        sendReply(id){
            if (this.reply != ''){
                this.showReplyLoader =true;
                const url = `/send-reply`;
                axios.post(url , {
                    reply : this.reply,
                    post : this.posts,
                    commentId : id,
                })
                    .then(response =>{
                        if (response.data == 'noUser'){
                            this.$toast.error('عضو نیستید', 'ابتدا عضو شوید', this.notificationSystem.options.error);
                        }
                        if (response.data == 'limit'){
                            this.$toast.error('انجام نشد', 'بیش از حد دیدگاه ارسال کردید', this.notificationSystem.options.error);
                        }
                        else{
                            this.$toast.success('ارسال شد', 'دیدگاه بعد تایید نمایش داده میشود', this.notificationSystem.options.success);
                            this.reply = '';
                            this.getComment();
                            this.showReplyLoader = false
                        }
                    })
            }
        },
        getComment(){
            this.showGetLoader =true;
            const url = `/get-comment/${this.posts.id}`;
            axios.get(url ,{
                postID : this.posts.id
            })
                .then(response=>{
                    this.showGetLoader =false;
                    this.comments = response.data;
                })
        },
        removeGood(index){
            this.goods.splice(index , 1);
        },
        addGood(){
            if (this.good != ''){
                this.goods.push(this.good);
                this.good = '';
            }
        },
        removeBad(index){
            this.bads.splice(index , 1);
        },
        addBad(){
            if (this.bad != ''){
                this.bads.push(this.bad);
                this.bad = '';
            }
        },
        getData(){
            for ( this.i ; this.i <  this.rate.length; this.i++) {
                this.rates.push({rate : '',name : '',});
                this.rates[this.i].name = this.rate[this.i].name;
                this.rates[this.i].rate = this.rate[this.i].rate;
            }
        },
        sendPage(url){
            axios.get(url)
            .then(response=>{
                this.showGetLoader = false;
                this.comments = response.data;
            })
        },
        getRate(){
            const url = '/get-rate';
            axios.post(url ,{
                post_id : this.posts.id,
            })
                .then(response=>{
                    this.rating = response.data[0];
                })
        },
    },
    mounted() {
        this.getComment();
        this.getData();
        this.getRate();
    }
}
</script>

<style scoped>

</style>

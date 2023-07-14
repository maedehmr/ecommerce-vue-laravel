<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $array = [
            'forbiddensComment',
            'showUserComment',
            'limitedComment',
            'approvedComment',
            'coercionComment',
            'replyComment',
            'checkUserComment',
            'checkOnlineComment',
            'pagesComment',
            'siteLogo',
            'captcha',
            'emailAddress',
            'verifyEmail',
            'verifyLogin',
            'showPostCategory',
            'showPostPage',
            'siteName',
            'siteRole',
            'siteAbout',
            'siteGM',
            'siteTelegram',
            'siteTwitter',
            'siteInstagram',
            'siteFacebook',
            'vidgetCat',
            'footerCat',
            'specialCatPic',
            'categorySpecial',
            'siteNumber',
            'siteTitle',
            'siteAddress',
            'titleSeo',
            'keywords',
            'descriptionSeo',
            'catHeader',
            'catSite2',
            'catSite',
            'payDeliver',
            'merchantID',
            'productId',
            'etemad',
            'samandehi',
        ];
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->text('value')->nullable();
            $table->timestamps();
        });
        foreach ($array as $item) {
            DB::table('settings')->insert(
                array(
                    'key' => $item,
                    'value' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                )
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}

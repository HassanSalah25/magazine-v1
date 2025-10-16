<?php

use App\Http\Controllers\Admin\ApproachController;
use App\Http\Controllers\Admin\ArchiveController;
use App\Http\Controllers\Admin\ArticleCategoryController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\BasicController;
use App\Http\Controllers\Admin\BcategoryController;
use App\Http\Controllers\Admin\BlogsectionController;
use App\Http\Controllers\Admin\CacheController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\ComparisonController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CtaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\EmailController;
use App\Http\Controllers\Admin\EventCategoryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\FAQCategoryController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FaqsectionController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\ForgetController;
use App\Http\Controllers\Admin\FreeAnalysisController;
use App\Http\Controllers\Admin\GalleryCategoryController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GatewayController;
use App\Http\Controllers\Admin\HerosectionController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\HomepageSectionsController;
use App\Http\Controllers\Admin\IntrosectionController;
use App\Http\Controllers\Admin\JcategoryController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\LandingpageSectionsController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\MenuBuilderController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\NavtabController;
use App\Http\Controllers\Admin\OurstoryController;
use App\Http\Controllers\Admin\PackageCategoryController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PageBuilderController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PopupController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\PortfoliosectionController;
use App\Http\Controllers\Admin\PricingsectionController;
use App\Http\Controllers\Admin\ProductCategory;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductOrderController;
use App\Http\Controllers\Admin\PushController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\Admin\RegisterUserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RssFeedsController;
use App\Http\Controllers\Admin\ScategoryController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ServicesectionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ShopSettingController;
use App\Http\Controllers\Admin\SitemapController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SocialController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\SummernoteController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\TranslationController;
use App\Http\Controllers\Admin\UlinkController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BlogFaqController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Front\FrontendController;
use App\Models\Permalink;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;
use App\Http\Controllers\Admin\HowWeDoItController;

/*=======================================================
******************** Admin Routes **********************
=======================================================*/

Route::group(['prefix' => 'admins', 'middleware' => 'guest:admin'], function () {
    Route::post('/login', [\App\Http\Controllers\Admin\LoginController::class, 'authenticate'])->name('admin.auth');

    Route::get('/mail-form', [ForgetController::class, 'mailForm'])->name('admin.forget.form');
    Route::post('/sendmail', [ForgetController::class, 'sendmail'])->name('admin.forget.mail');
});


Route::group(['prefix' => 'admins', 'middleware' => ['auth:admin', 'checkstatus', 'setLfmPath']], function () {

    // RTL check
    Route::get('/rtlcheck/{langid}', [LanguageController::class, 'rtlcheck'])->name('admin.rtlcheck');

    // Summernote image upload
    Route::post('/summernote/upload', [SummernoteController::class, 'upload'])->name('admin.summernote.upload');

    // Admin logout Route
    Route::get('/logout', [\App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('admin.logout');

    Route::group(['middleware' => 'checkpermission:Dashboard'], function () {
        // Admin Dashboard Routes
        Route::get('/dashboard', [DashboardController::class,'dashboard'])->name('admin.dashboard');
    });


    // Admin Profile Routes
    Route::get('/changePassword', [ProfileController::class, 'changePass'])->name('admin.changePass');
    Route::post('/profile/updatePassword', [ProfileController::class, 'updatePassword'])->name('admin.updatePassword');
    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('admin.editProfile');
    Route::post('/profile/update', [ProfileController::class, 'updatePropic'])->name('admin.propic.update');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('admin.updateProfile');


    Route::group(['middleware' => 'checkpermission:Theme & Home'], function () {
        // Admin Home Version Setting Routes
        Route::get('/home-settings', [BasicController::class, 'homeSettings'])->name('admin.homeSettings');
        Route::post('/homeSettings/post', [BasicController::class, 'updateHomeSettings'])->name('admin.homeSettings.update');
    });


    Route::group(['middleware' => 'checkpermission:Basic Settings'], function () {

        // Admin File Manager Routes
        Route::get('/file-manager', [BasicController::class, 'fileManager'])->name('admin.file-manager');

        // Admin Logo Routes
        Route::get('/logo', [BasicController::class, 'logo'])->name('admin.logo');
        Route::post('/logo/post', [BasicController::class, 'updatelogo'])->name('admin.logo.update');


        // Admin preloader Routes
        Route::get('/preloader', [BasicController::class, 'preloader'])->name('admin.preloader');
        Route::post('/preloader/post', [BasicController::class, 'updatepreloader'])->name('admin.preloader.update');


        // Admin Scripts Routes
        Route::get('/feature/settings', [BasicController::class, 'featuresettings'])->name('admin.featuresettings');
        Route::post('/feature/settings/update', [BasicController::class, 'updatefeatrue'])->name('admin.featuresettings.update');


        // Admin Basic Information Routes
        Route::get('/basicinfo', [BasicController::class, 'basicinfo'])->name('admin.basicinfo');
        Route::post('/basicinfo/{langid}/post', [BasicController::class, 'updatebasicinfo'])->name('admin.basicinfo.update');

        // Admin Basic Information Routes
        Route::get('/basicinfo', [BasicController::class, 'basicinfo'])->name('admin.basicinfo');
        Route::post('/basicinfo/post', [BasicController::class, 'updatebasicinfo'])->name('admin.basicinfo.update');

        // Admin Email Settings Routes
        Route::get('/mail-from-admin', [EmailController::class, 'mailFromAdmin'])->name('admin.mailFromAdmin');
        Route::post('/mail-from-admin/update', [EmailController::class, 'updateMailFromAdmin'])->name('admin.mailfromadmin.update');
        Route::get('/mail-to-admin', [EmailController::class, 'mailToAdmin'])->name('admin.mailToAdmin');
        Route::post('/mail-to-admin/update', [EmailController::class, 'updateMailToAdmin'])->name('admin.mailtoadmin.update');
        Route::get('/email-templates', [EmailController::class, 'templates'])->name('admin.email.templates');
        Route::get('/email-template/{id}/edit', [EmailController::class, 'editTemplate'])->name('admin.email.editTemplate');
        Route::post('/emailtemplate/{id}/update', [EmailController::class, 'templateUpdate'])->name('admin.email.templateUpdate');

        // Admin Email Settings Routes
        Route::get('/mail-from-admin', [EmailController::class, 'mailFromAdmin'])->name('admin.mailFromAdmin');
        Route::post('/mail-from-admin/update', [EmailController::class, 'updateMailFromAdmin'])->name('admin.mailfromadmin.update');
        Route::get('/mail-to-admin', [EmailController::class, 'mailToAdmin'])->name('admin.mailToAdmin');
        Route::post('/mail-to-admin/update', [EmailController::class, 'updateMailToAdmin'])->name('admin.mailtoadmin.update');


        // Admin Support Routes
        Route::get('/support', [BasicController::class, 'support'])->name('admin.support');
        Route::post('/support/{langid}/post', [BasicController::class, 'updatesupport'])->name('admin.support.update');


        // Admin Page Heading Routes
        Route::get('/heading', [BasicController::class, 'heading'])->name('admin.heading');
        Route::post('/heading/{langid}/update', [BasicController::class, 'updateheading'])->name('admin.heading.update');


        // Admin Scripts Routes
        Route::get('/script', [BasicController::class, 'script'])->name('admin.script');
        Route::post('/script/update', [BasicController::class, 'updatescript'])->name('admin.script.update');

        // Admin Social Routes
        Route::get('/social', [SocialController::class, 'index'])->name('admin.social.index');
        Route::post('/social/store', [SocialController::class, 'store'])->name('admin.social.store');
        Route::get('/social/{id}/edit', [SocialController::class, 'edit'])->name('admin.social.edit');
        Route::post('/social/update', [SocialController::class, 'update'])->name('admin.social.update');
        Route::post('/social/delete', [SocialController::class, 'delete'])->name('admin.social.delete');

        // Admin SEO Information Routes
        Route::get('/seo', [BasicController::class, 'seo'])->name('admin.seo');
        Route::post('/seo/{langid}/update', [BasicController::class, 'updateseo'])->name('admin.seo.update');


        // Admin Maintanance Mode Routes
        Route::get('/maintainance', [BasicController::class, 'maintainance'])->name('admin.maintainance');
        Route::post('/maintainance/update', [BasicController::class, 'updatemaintainance'])->name('admin.maintainance.update');

        // Admin Section Customization Routes
        Route::get('/sections', [BasicController::class, 'sections'])->name('admin.sections.index');
        Route::post('/sections/update', [BasicController::class, 'updatesections'])->name('admin.sections.update');

        // Admin Offer Banner Routes
        Route::get('/announcement', [BasicController::class, 'announcement'])->name('admin.announcement');
        Route::post('/announcement/{langid}/update', [BasicController::class, 'updateannouncement'])->name('admin.announcement.update');


        // Admin Section Customization Routes
        Route::get('/sections', [BasicController::class, 'sections'])->name('admin.sections.index');
        Route::post('/sections/update', [BasicController::class, 'updatesections'])->name('admin.sections.update');


        // Admin Section Customization Routes
        Route::get('/sections', [BasicController::class, 'sections'])->name('admin.sections.index');
        Route::post('/sections/update', [BasicController::class, 'updatesections'])->name('admin.sections.update');

        // Admin Cookie Alert Routes
        Route::get('/cookie-alert', [BasicController::class, 'cookiealert'])->name('admin.cookie.alert');
        Route::post('/cookie-alert/{langid}/update', [BasicController::class, 'updatecookie'])->name('admin.cookie.update');

        // Admin Free Analysis Routes
        Route::get('/free-analysis', [FreeAnalysisController::class, 'index'])->name('admin.free-analysis.index');
        Route::post('/free-analysis/{langid}/update', [FreeAnalysisController::class, 'update'])->name('admin.free-analysis.update');


        // Admin Payment Gateways
        Route::get('/gateways', [GatewayController::class, 'index'])->name('admin.gateway.index');
        Route::post('/stripe/update', [GatewayController::class, 'stripeUpdate'])->name('admin.stripe.update');
        Route::post('/paypal/update', [GatewayController::class, 'paypalUpdate'])->name('admin.paypal.update');
        Route::post('/paystack/update', [GatewayController::class, 'paystackUpdate'])->name('admin.paystack.update');
        Route::post('/paytm/update', [GatewayController::class, 'paytmUpdate'])->name('admin.paytm.update');
        Route::post('/flutterwave/update', [GatewayController::class, 'flutterwaveUpdate'])->name('admin.flutterwave.update');
        Route::post('/instamojo/update', [GatewayController::class, 'instamojoUpdate'])->name('admin.instamojo.update');
        Route::post('/mollie/update', [GatewayController::class, 'mollieUpdate'])->name('admin.mollie.update');
        Route::post('/razorpay/update', [GatewayController::class, 'razorpayUpdate'])->name('admin.razorpay.update');
        Route::post('/mercadopago/update', [GatewayController::class, 'mercadopagoUpdate'])->name('admin.mercadopago.update');
        Route::post('/payumoney/update', [GatewayController::class, 'payumoneyUpdate'])->name('admin.payumoney.update');
        Route::get('/offline/gateways', [GatewayController::class, 'offline'])->name('admin.gateway.offline');
        Route::post('/offline/gateway/store', [GatewayController::class, 'store'])->name('admin.gateway.offline.store');
        Route::post('/offline/gateway/update', [GatewayController::class, 'update'])->name('admin.gateway.offline.update');
        Route::post('/offline/status', [GatewayController::class, 'status'])->name('admin.offline.status');
        Route::post('/offline/gateway/delete', [GatewayController::class, 'delete'])->name('admin.offline.gateway.delete');


        // Admin Language Routes
        Route::get('/languages', [LanguageController::class, 'index'])->name('admin.language.index');
        Route::get('/language/{id}/edit', [LanguageController::class, 'edit'])->name('admin.language.edit');
        Route::get('/language/{id}/edit/keyword', [LanguageController::class, 'editKeyword'])->name('admin.language.editKeyword');
        Route::post('/language/store', [LanguageController::class, 'store'])->name('admin.language.store');
        Route::post('/language/upload', [LanguageController::class, 'upload'])->name('admin.language.upload');
        Route::post('/language/{id}/uploadUpdate', [LanguageController::class, 'uploadUpdate'])->name('admin.language.uploadUpdate');
        Route::post('/language/{id}/default', [LanguageController::class, 'default'])->name('admin.language.default');
        Route::post('/language/{id}/delete', [LanguageController::class, 'delete'])->name('admin.language.delete');
        Route::post('/language/update', [LanguageController::class, 'update'])->name('admin.language.update');
        Route::post('/language/{id}/update/keyword', [LanguageController::class, 'updateKeyword'])->name('admin.language.updateKeyword');


        // Admin Sitemap Routes
        Route::get('/sitemap', [SitemapController::class, 'index'])->name('admin.sitemap.index');
        Route::post('/sitemap/store', [SitemapController::class, 'store'])->name('admin.sitemap.store');
        Route::get('/sitemap/{id}/update', [SitemapController::class, 'update'])->name('admin.sitemap.update');
        Route::post('/sitemap/{id}/delete', [SitemapController::class, 'delete'])->name('admin.sitemap.delete');
        Route::post('/sitemap/download', [SitemapController::class, 'download'])->name('admin.sitemap.download');

        // Admin Database Backup
        Route::get('/backup', [BackupController::class, 'index'])->name('admin.backup.index');
        Route::post('/backup/store', [BackupController::class, 'store'])->name('admin.backup.store');
        Route::post('/backup/{id}/delete', [BackupController::class, 'delete'])->name('admin.backup.delete');
        Route::post('/backup/download', [BackupController::class, 'download'])->name('admin.backup.download');


        // Admin Cache Clear Routes
        Route::get('/cache-clear', [CacheController::class, 'clear'])->name('admin.cache.clear');
    });


    Route::group(['middleware' => 'checkpermission:Content Management'], function () {
        Route::get('/homepagesection', [HomepageSectionsController::class, 'index'])->name('admin.homepagesection.index');
        Route::get('/homepagesection/herosection', [HomepageSectionsController::class, 'herosection'])->name('admin.homepagesection.herosection');
        Route::get('/landingpagesection/{id}', [LandingpageSectionsController::class, 'index'])->name('admin.landingpagesection.index');
        Route::get('/landingpagesection/herosection/{id}', [LandingpageSectionsController::class, 'herosection'])->name('admin.landingpagesection.herosection');
        // Admin Hero Section (Static Version) Routes
        Route::get('/herosection/static', [HerosectionController::class, 'static'])->name('admin.herosection.static');
        Route::post('/herosection/{langid}/update', [HerosectionController::class, 'update'])->name('admin.herosection.update');


        // Admin Hero Section (Slider Version) Routes
        Route::get('/herosection/sliders', [SliderController::class, 'index'])->name('admin.slider.index');
        Route::post('/herosection/slider/store', [SliderController::class, 'store'])->name('admin.slider.store');
        Route::get('/herosection/slider/{id}/edit', [SliderController::class, 'edit'])->name('admin.slider.edit');
        Route::post('/herosection/sliderupdate', [SliderController::class, 'update'])->name('admin.slider.update');
        Route::post('/herosection/slider/delete', [SliderController::class, 'delete'])->name('admin.slider.delete');


        // Admin Hero Section (Video Version) Routes
        Route::get('/herosection/video', [HerosectionController::class, 'video'])->name('admin.herosection.video');
        Route::post('/herosection/video/{langid}/update', [HerosectionController::class, 'videoupdate'])->name('admin.herosection.video.update');


        // Admin Hero Section (Parallax Version) Routes
        Route::get('/herosection/parallax', [HerosectionController::class, 'parallax'])->name('admin.herosection.parallax');
        Route::post('/herosection/parallax/update', [HerosectionController::class, 'parallaxupdate'])->name('admin.herosection.parallax.update');


        // Admin Feature Routes
        Route::get('/features', [FeatureController::class, 'index'])->name('admin.feature.index');
        Route::post('/feature/store', [FeatureController::class, 'store'])->name('admin.feature.store');
        Route::get('/feature/{id}/edit', [FeatureController::class, 'edit'])->name('admin.feature.edit');
        Route::post('/feature/update', [FeatureController::class, 'update'])->name('admin.feature.update');
        Route::post('/feature/delete', [FeatureController::class, 'delete'])->name('admin.feature.delete');

        // Admin Intro Section Routes
        Route::get('/introsection', [IntrosectionController::class, 'index'])->name('admin.introsection.index');
        Route::post('/introsection/{langid}/update', [IntrosectionController::class, 'update'])->name('admin.introsection.update');

        // Admin Intro Section Routes
        Route::get('/comparison', [ComparisonController::class, 'index'])->name('admin.comparison.index');
        Route::post('/comparison/{langid}/update', [ComparisonController::class, 'update'])->name('admin.comparison.update');

        // Admin Intro Section Routes
        Route::get('/nav_tab', [NavtabController::class, 'index'])->name('admin.nav_tab.index');
        Route::post('/nav_tab/{langid}/update', [NavtabController::class, 'update'])->name('admin.nav_tab.update');

        // Admin Faq Section Routes
        Route::get('/faqsection', [FaqsectionController::class, 'index'])->name('admin.faqsection.index');
        Route::post('/faqsection/{langid}/update', [FaqsectionController::class, 'update'])->name('admin.faqsection.update');

        // Admin Service Section Routes
        Route::get('/servicesection', [ServicesectionController::class, 'index'])->name('admin.servicesection.index');
        Route::post('/servicesection/{langid}/update', [ServicesectionController::class, 'update'])->name('admin.servicesection.update');

        // Admin Pricing Section Routes
        Route::get('/pricingsection', [PricingsectionController::class, 'index'])->name('admin.pricingsection.index');
        Route::post('/pricingsection/{langid}/update', [PricingsectionController::class, 'update'])->name('admin.pricingsection.update');

        // Admin Approach Section Routes
        Route::get('/approach', [ApproachController::class, 'index'])->name('admin.approach.index');
        Route::post('/approach/store', [ApproachController::class, 'store'])->name('admin.approach.point.store');
        Route::get('/approach/{id}/pointedit', [ApproachController::class, 'pointedit'])->name('admin.approach.point.edit');
        Route::post('/approach/{langid}/update', [ApproachController::class, 'update'])->name('admin.approach.update');
        Route::post('/approach/pointupdate', [ApproachController::class, 'pointupdate'])->name('admin.approach.point.update');
        Route::post('/approach/pointdelete', [ApproachController::class, 'pointdelete'])->name('admin.approach.pointdelete');

        // Admin How We Do It Section Routes
        Route::get('/howwedoit', [HowWeDoItController::class, 'index'])->name('admin.howwedoit.index');
        Route::post('/howwedoit/{langid}/update', [HowWeDoItController::class, 'update'])->name('admin.howwedoit.update');
        Route::post('/howwedoit/tab/store', [HowWeDoItController::class, 'storeTab'])->name('admin.howwedoit.tab.store');
        Route::post('/howwedoit/tab/update', [HowWeDoItController::class, 'updateTab'])->name('admin.howwedoit.tab.update');
        Route::post('/howwedoit/tab/delete', [HowWeDoItController::class, 'deleteTab'])->name('admin.howwedoit.tab.delete');


        // Admin Statistic Section Routes
        Route::get('/statistics', [StatisticsController::class, 'index'])->name('admin.statistics.index');
        Route::post('/statistics/{langid}/upload', [StatisticsController::class, 'upload'])->name('admin.statistics.upload');
        Route::post('/statistics/store', [StatisticsController::class, 'store'])->name('admin.statistics.store');
        Route::get('/statistics/{id}/edit', [StatisticsController::class, 'edit'])->name('admin.statistics.edit');
        Route::post('/statistics/update', [StatisticsController::class, 'update'])->name('admin.statistics.update');
        Route::post('/statistics/delete', [StatisticsController::class, 'delete'])->name('admin.statistics.delete');


        // Admin Call to Action Section Routes
        Route::get('/cta', [CtaController::class, 'index'])->name('admin.cta.index');
        Route::post('/cta/{langid}/update', [CtaController::class, 'update'])->name('admin.cta.update');

        // Admin Portfolio Section Routes
        Route::get('/portfoliosection', [PortfoliosectionController::class, 'index'])->name('admin.portfoliosection.index');
        Route::post('/portfoliosection/{langid}/update', [PortfoliosectionController::class, 'update'])->name('admin.portfoliosection.update');

        // Admin Testimonial Routes
        Route::get('/testimonials', [TestimonialController::class, 'index'])->name('admin.testimonial.index');
        Route::get('/testimonial/create', [TestimonialController::class, 'create'])->name('admin.testimonial.create');
        Route::post('/testimonial/store', [TestimonialController::class, 'store'])->name('admin.testimonial.store');
        Route::get('/testimonial/{id}/edit', [TestimonialController::class, 'edit'])->name('admin.testimonial.edit');
        Route::post('/testimonial/update', [TestimonialController::class, 'update'])->name('admin.testimonial.update');
        Route::post('/testimonial/delete', [TestimonialController::class, 'delete'])->name('admin.testimonial.delete');
        Route::post('/testimonialtext/{langid}/update', [TestimonialController::class, 'textupdate'])->name('admin.testimonialtext.update');

        // Admin Blog Section Routes
        Route::get('/blogsection', [BlogsectionController::class, 'index'])->name('admin.blogsection.index');
        Route::post('/blogsection/{langid}/update', [BlogsectionController::class, 'update'])->name('admin.blogsection.update');

        // Admin Partner Routes
        Route::get('/partners', [PartnerController::class, 'index'])->name('admin.partner.index');
        Route::post('/partner/store', [PartnerController::class, 'store'])->name('admin.partner.store');
        Route::get('/partner/{id}/edit', [PartnerController::class, 'edit'])->name('admin.partner.edit');
        Route::post('/partner/update', [PartnerController::class, 'update'])->name('admin.partner.update');
        Route::post('/partner/delete', [PartnerController::class, 'delete'])->name('admin.partner.delete');

        // Admin Member Routes
        Route::get('/members', [MemberController::class, 'index'])->name('admin.member.index');
        Route::get('/member/create', [MemberController::class, 'create'])->name('admin.member.create');
        Route::post('/member/store', [MemberController::class, 'store'])->name('admin.member.store');
        Route::get('/member/{id}/edit', [MemberController::class, 'edit'])->name('admin.member.edit');
        Route::post('/member/update', [MemberController::class, 'update'])->name('admin.member.update');
        Route::post('/member/delete', [MemberController::class, 'delete'])->name('admin.member.delete');
        Route::post('/teamtext/{langid}/update', [MemberController::class, 'textupdate'])->name('admin.teamtext.update');
        Route::post('/member/feature', [MemberController::class, 'feature'])->name('admin.member.feature');


        // Admin Package Background Routes
        Route::get('/package/background', [PackageController::class, 'background'])->name('admin.package.background');
        Route::post('/package/{langid}/background-upload', [PackageController::class, 'uploadBackground'])->name('admin.package.background.upload');


        // Admin Footer Logo Text Routes
        Route::get('/footers', [FooterController::class, 'index'])->name('admin.footer.index');
        Route::post('/footer/{langid}/update', [FooterController::class, 'update'])->name('admin.footer.update');


        // Admin Ulink Routes
        Route::get('/ulinks', [UlinkController::class, 'index'])->name('admin.ulink.index');
        Route::get('/ulink/create', [UlinkController::class, 'create'])->name('admin.ulink.create');
        Route::post('/ulink/store', [UlinkController::class, 'store'])->name('admin.ulink.store');
        Route::get('/ulink/{id}/edit', 'Adadmin\UlinkController@edit')->name('admin.ulink.edit');
        Route::post('/ulink/update', [UlinkController::class, 'update'])->name('admin.ulink.update');
        Route::post('/ulink/delete', [UlinkController::class, 'delete'])->name('admin.ulink.delete');


        // Service Settings Route
        Route::get('/service/settings', [ServiceController::class, 'settings'])->name('admin.service.settings');
        Route::post('/service/updateSettings', [ServiceController::class, 'updateSettings'])->name('admin.service.updateSettings');

        // Admin Service Category Routes
        Route::get('/scategorys', [ScategoryController::class, 'index'])->name('admin.scategory.index');
        Route::post('/scategory/store', [ScategoryController::class, 'store'])->name('admin.scategory.store');
        Route::get('/scategory/{id}/edit', [ScategoryController::class, 'edit'])->name('admin.scategory.edit');
        Route::post('/scategory/update', [ScategoryController::class, 'update'])->name('admin.scategory.update');
        Route::post('/scategory/delete', [ScategoryController::class, 'delete'])->name('admin.scategory.delete');
        Route::post('/scategory/bulk-delete', [ScategoryController::class, 'bulkDelete'])->name('admin.scategory.bulk.delete');
        Route::post('/scategory/feature', [ScategoryController::class, 'feature'])->name('admin.scategory.feature');

        // Admin Services Routes
        Route::get('/services', [ServiceController::class, 'index'])->name('admin.service.index');
        Route::post('/service/store', [ServiceController::class, 'store'])->name('admin.service.store');
        Route::get('/service/{id}/edit', [ServiceController::class, 'edit'])->name('admin.service.edit');
        Route::post('/service/update', [ServiceController::class, 'update'])->name('admin.service.update');
        Route::post('/service/delete', [ServiceController::class, 'delete'])->name('admin.service.delete');
        Route::post('/service/bulk-delete', [ServiceController::class, 'bulkDelete'])->name('admin.service.bulk.delete');
        Route::get('/service/{langid}/getcats', [ServiceController::class, 'getcats'])->name('admin.service.getcats');
        Route::post('/service/feature', [ServiceController::class, 'feature'])->name('admin.service.feature');
        Route::post('/service/sidebar', [ServiceController::class, 'sidebar'])->name('admin.service.sidebar');
        Route::get('/service/{langId}/get_services', [ServiceController::class, 'getServices'])->name('admin.service.get_services');
        Route::get('/scategory/{langId}/get_scategories', [ScategoryController::class, 'getScategories'])->name('admin.scategory.get_scategories');


        // Admin Portfolio Routes
        Route::get('/portfolios', [PortfolioController::class, 'index'])->name('admin.portfolio.index');
        Route::get('/portfolio/create', [PortfolioController::class, 'create'])->name('admin.portfolio.create');
        Route::post('/portfolio/sliderstore', [PortfolioController::class, 'sliderstore'])->name('admin.portfolio.sliderstore');
        Route::post('/portfolio/sliderrmv', [PortfolioController::class, 'sliderrmv'])->name('admin.portfolio.sliderrmv');
        Route::post('/portfolio/store', [PortfolioController::class, 'store'])->name('admin.portfolio.store');
        Route::get('/portfolio/{id}/edit', [PortfolioController::class, 'edit'])->name('admin.portfolio.edit');
        Route::get('/portfolio/{id}/images', [PortfolioController::class, 'images'])->name('admin.portfolio.images');
        Route::post('/portfolio/sliderupdate', [PortfolioController::class, 'sliderupdate'])->name('admin.portfolio.sliderupdate');
        Route::post('/portfolio/update', [PortfolioController::class, 'update'])->name('admin.portfolio.update');
        Route::post('/portfolio/delete', [PortfolioController::class, 'delete'])->name('admin.portfolio.delete');
        Route::post('/portfolio/bulk-delete', [PortfolioController::class, 'bulkDelete'])->name('admin.portfolio.bulk.delete');
        Route::get('portfolio/{id}/getservices', [PortfolioController::class, 'getservices'])->name('admin.portfolio.getservices');
        Route::post('/portfolio/feature', [PortfolioController::class, 'feature'])->name('admin.portfolio.feature');

        // Admin Tag Routes
        Route::get('/tags', [TagController::class, 'index'])->name('admin.tag.index');
        Route::get('/tag/create', [TagController::class, 'create'])->name('admin.tag.create');
        Route::post('/tag/sliderstore', [TagController::class, 'sliderstore'])->name('admin.tag.sliderstore');
        Route::post('/tag/sliderrmv', [TagController::class, 'sliderrmv'])->name('admin.tag.sliderrmv');
        Route::post('/tag/store', [TagController::class, 'store'])->name('admin.tag.store');
        Route::get('/tag/{id}/edit', [TagController::class, 'edit'])->name('admin.tag.edit');
        Route::get('/tag/{id}/images', [TagController::class, 'images'])->name('admin.tag.images');
        Route::post('/tag/sliderupdate', [TagController::class, 'sliderupdate'])->name('admin.tag.sliderupdate');
        Route::post('/tag/update', [TagController::class, 'update'])->name('admin.tag.update');
        Route::post('/tag/delete', [TagController::class, 'delete'])->name('admin.tag.delete');
        Route::post('/tag/bulk-delete', [TagController::class, 'bulkDelete'])->name('admin.tag.bulk.delete');
        Route::get('tag/{id}/getservices', [TagController::class, 'getservices'])->name('admin.tag.getservices');
        Route::post('/tag/feature', [TagController::class, 'feature'])->name('admin.tag.feature');


        // Admin Blog Category Routes
        Route::get('/bcategorys', [BcategoryController::class, 'index'])->name('admin.bcategory.index');
        Route::get('/bcategory/edit/{id}', [BcategoryController::class, 'edit'])->name('admin.bcategory.edit');
        Route::post('/bcategory/store', [BcategoryController::class, 'store'])->name('admin.bcategory.store');
        Route::post('/bcategory/update', [BcategoryController::class, 'update'])->name('admin.bcategory.update');
        Route::post('/bcategory/delete', [BcategoryController::class, 'delete'])->name('admin.bcategory.delete');
        Route::post('/bcategory/bulk-delete', [BcategoryController::class, 'bulkDelete'])->name('admin.bcategory.bulk.delete');


        // Admin Blog Routes
        Route::get('/blogs', [BlogController::class, 'index'])->name('admin.blog.index');
        Route::post('/blog/store', [BlogController::class, 'store'])->name('admin.blog.store');
        Route::get('/blog/{id}/edit', [BlogController::class, 'edit'])->name('admin.blog.edit');
        Route::post('/blog/update', [BlogController::class, 'update'])->name('admin.blog.update');
        Route::post('/blog/delete', [BlogController::class, 'delete'])->name('admin.blog.delete');
        Route::post('/blog/bulk-delete', [BlogController::class, 'bulkDelete'])->name('admin.blog.bulk.delete');
        Route::get('/blog/{langid}/getcats', [BlogController::class, 'getcats'])->name('admin.blog.getcats');
        Route::post('/blog/sidebar', [BlogController::class, 'sidebar'])->name('admin.blog.sidebar');

        // Admin Blog FAQ Routes
        Route::get('/blog/{blogId}/faqs', [BlogFaqController::class, 'index'])->name('admin.blog.faq.index');
        Route::post('/blog/faq/store', [BlogFaqController::class, 'store'])->name('admin.blog.faq.store');
        Route::post('/blog/faq/update', [BlogFaqController::class, 'update'])->name('admin.blog.faq.update');
        Route::post('/blog/faq/delete', [BlogFaqController::class, 'delete'])->name('admin.blog.faq.delete');


        // Admin Blog Archive Routes
        Route::get('/archives', [ArchiveController::class, 'index'])->name('admin.archive.index');
        Route::post('/archive/store', [ArchiveController::class, 'store'])->name('admin.archive.store');
        Route::post('/archive/update', [ArchiveController::class, 'update'])->name('admin.archive.update');
        Route::post('/archive/delete', [ArchiveController::class, 'delete'])->name('admin.archive.delete');


        // Admin Gallery Settings Routes
        Route::get('/gallery/settings', [GalleryCategoryController::class, 'settings'])->name('admin.gallery.settings');
        Route::post('/gallery/update_settings', [GalleryCategoryController::class, 'updateSettings'])->name('admin.gallery.update_settings');

        // Admin Gallery Category Routes
        Route::get('/gallery/categories', [GalleryCategoryController::class, 'index'])->name('admin.gallery.categories');
        Route::post('/gallery/store_category', [GalleryCategoryController::class, 'store'])->name('admin.gallery.store_category');
        Route::post('/gallery/update_category', [GalleryCategoryController::class, 'update'])->name('admin.gallery.update_category');
        Route::post('/gallery/delete_category', [GalleryCategoryController::class, 'delete'])->name('admin.gallery.delete_category');
        Route::post('/gallery/bulk_delete_category', [GalleryCategoryController::class, 'bulkDelete'])->name('admin.gallery.bulk_delete_category');

        // Admin Gallery Routes
        Route::get('/gallery', [GalleryController::class, 'index'])->name('admin.gallery.index');
        Route::get('/gallery/{langId}/get_categories', [GalleryController::class, 'getCategories']);
        Route::post('/gallery/store', [GalleryController::class, 'store'])->name('admin.gallery.store');
        Route::get('/gallery/{id}/edit', [GalleryController::class, 'edit'])->name('admin.gallery.edit');
        Route::post('/gallery/update', [GalleryController::class, 'update'])->name('admin.gallery.update');
        Route::post('/gallery/delete', [GalleryController::class, 'delete'])->name('admin.gallery.delete');
        Route::post('/gallery/bulk-delete', [GalleryController::class, 'bulkDelete'])->name('admin.gallery.bulk.delete');


        // Admin FAQ Settings Routes
        Route::get('/faq/settings', [FAQCategoryController::class, 'settings'])->name('admin.faq.settings');
        Route::post('/faq/update_settings', [FAQCategoryController::class, 'updateSettings'])->name('admin.faq.update_settings');

        // Admin FAQ Category Routes
        Route::get('/faq/categories', [FAQCategoryController::class, 'index'])->name('admin.faq.categories');
        Route::post('/faq/categories/showin', [FAQCategoryController::class, 'showin'])->name('admin.faq.categories.showin');
        Route::post('/faq/store_category', [FAQCategoryController::class, 'store'])->name('admin.faq.store_category');
        Route::post('/faq/update_category', [FAQCategoryController::class, 'update'])->name('admin.faq.update_category');
        Route::post('/faq/delete_category', [FAQCategoryController::class, 'delete'])->name('admin.faq.delete_category');
        Route::post('/faq/bulk_delete_category', [FAQCategoryController::class, 'bulkDelete'])->name('admin.faq.bulk_delete_category');

        // Admin FAQ Routes
        Route::get('/faqs', [FaqController::class, 'index'])->name('admin.faq.index');
        Route::get('/faq/create', [FaqController::class, 'create'])->name('admin.faq.create');
        Route::get('/faq/{langId}/get_categories', [FaqController::class, 'getCategories']);
        Route::get('/faq/{langId}/get_services', [FaqController::class, 'getServices']);
        Route::post('/faq/store', [FaqController::class, 'store'])->name('admin.faq.store');
        Route::get('/faq/{id}/edit', [FaqController::class, 'edit'])->name('admin.faq.edit');
        Route::post('/faq/update', [FaqController::class, 'update'])->name('admin.faq.update');
        Route::post('/faq/delete', [FaqController::class, 'delete'])->name('admin.faq.delete');
        Route::post('/faq/bulk-delete', [FaqController::class, 'bulkDelete'])->name('admin.faq.bulk.delete');

        // Admin Job Category Routes
        Route::get('/jcategorys', [JcategoryController::class, 'index'])->name('admin.jcategory.index');
        Route::post('/jcategory/store', [JcategoryController::class, 'store'])->name('admin.jcategory.store');
        Route::get('/jcategory/{id}/edit', [JcategoryController::class, 'edit'])->name('admin.jcategory.edit');
        Route::post('/jcategory/update', [JcategoryController::class, 'update'])->name('admin.jcategory.update');
        Route::post('/jcategory/delete', [JcategoryController::class, 'delete'])->name('admin.jcategory.delete');
        Route::post('/jcategory/bulk-delete', [JcategoryController::class, 'bulkDelete'])->name('admin.jcategory.bulk.delete');

        // Admin Jobs Routes
        Route::get('/jobs', [JobController::class, 'index'])->name('admin.job.index');
        Route::get('/job/create', [JobController::class, 'create'])->name('admin.job.create');
        Route::post('/job/store', [JobController::class, 'store'])->name('admin.job.store');
        Route::get('/job/{id}/edit', [JobController::class, 'edit'])->name('admin.job.edit');
        Route::post('/job/update', [JobController::class, 'update'])->name('admin.job.update');
        Route::post('/job/delete', [JobController::class, 'delete'])->name('admin.job.delete');
        Route::post('/job/bulk-delete', [JobController::class, 'bulkDelete'])->name('admin.job.bulk.delete');
        Route::get('/job/{langid}/getcats', [JobController::class, 'getcats'])->name('admin.job.getcats');


        // Admin Contact Routes
        Route::get('/contact', [ContactController::class, 'index'])->name('admin.contact.index');
        Route::post('/contact/{langid}/post', [ContactController::class, 'update'])->name('admin.contact.update');
        // Admin Our Story Routes
        Route::get('/our_story', [OurstoryController::class, 'index'])->name('admin.our_story.index');
        Route::post('/our_story/{langid}/post', [OurstoryController::class, 'update'])->name('admin.our_story.update');
    });



    Route::group(['middleware' => 'checkpermission:Menu Builder'], function () {
        // Mega Menus Management Routes
        Route::get('/megamenus', [MenuBuilderController::class, 'megamenus'])->name('admin.megamenus');
        Route::get('/megamenus/edit', [MenuBuilderController::class, 'megaMenuEdit'])->name('admin.megamenu.edit');
        Route::post('/megamenus/update', [MenuBuilderController::class, 'megaMenuUpdate'])->name('admin.megamenu.update');

        // Menus Builder Management Routes
        Route::get('/menu-builder', [MenuBuilderController::class, 'index'])->name('admin.menu_builder.index');
        Route::post('/menu-builder/update', [MenuBuilderController::class, 'update'])->name('admin.menu_builder.update');

        // Permalinks Routes
        Route::get('/permalinks', [MenuBuilderController::class, 'permalinks'])->name('admin.permalinks.index');
        Route::post('/permalinks/update', [MenuBuilderController::class, 'permalinksUpdate'])->name('admin.permalinks.update');
    });


    Route::group(['middleware' => 'checkpermission:Announcement Popup'], function () {
        Route::get('popups', [PopupController::class, 'index'])->name('admin.popup.index');
        Route::get('popup/types', [PopupController::class, 'types'])->name('admin.popup.types');
        Route::get('popup/{id}/edit', [PopupController::class, 'edit'])->name('admin.popup.edit');
        Route::get('popup/create', [PopupController::class, 'create'])->name('admin.popup.create');
        Route::post('popup/store', [PopupController::class, 'store'])->name('admin.popup.store');
        Route::post('popup/delete', [PopupController::class, 'delete'])->name('admin.popup.delete');
        Route::post('popup/bulk-delete', [PopupController::class, 'bulkDelete'])->name('admin.popup.bulk.delete');
        Route::post('popup/status', [PopupController::class, 'status'])->name('admin.popup.status');
        Route::post('popup/update', [PopupController::class, 'update'])->name('admin.popup.update');
    });







    Route::group(['middleware' => 'checkpermission:Pages'], function () {
        // Menu Manager Routes
        Route::get('/pages', [PageController::class, 'index'])->name('admin.page.index');
        Route::get('/page/settings', [PageController::class, 'settings'])->name('admin.page.settings');
        Route::post('/page/update-settings', [PageController::class, 'updateSettings'])->name('admin.page.updateSettings');
        Route::get('/page/create', [PageController::class, 'create'])->name('admin.page.create');
        Route::post('/page/store', [PageController::class, 'store'])->name('admin.page.store');
        Route::get('/page/{menuID}/edit', [PageController::class, 'edit'])->name('admin.page.edit');
        Route::post('/page/update', [PageController::class, 'update'])->name('admin.page.update');
        Route::post('/page/delete', [PageController::class, 'delete'])->name('admin.page.delete');
        Route::post('/page/bulk-delete', [PageController::class, 'bulkDelete'])->name('admin.page.bulk.delete');
        Route::post('/upload/pagebuilder', [PageController::class, 'uploadPbImage'])->name('admin.pb.upload');
        Route::post('/remove/img/pagebuilder', [PageController::class, 'removePbImage'])->name('admin.pb.remove');
        Route::post('/upload/tui/pagebuilder', [PageController::class, 'uploadPbTui'])->name('admin.pb.tui.upload');
    });


    // Page Builder Routes
    Route::get('/pagebuilder/content', [PageBuilderController::class, 'content'])->name('admin.pagebuilder.content');
    Route::post('/pagebuilder/save', [PageBuilderController::class, 'save'])->name('admin.pagebuilder.save');



    Route::group(['middleware' => 'checkpermission:Shop Management'], function () {
        Route::get('/category', [ProductCategory::class, 'index'])->name('admin.category.index');
        Route::post('/category/store', [ProductCategory::class, 'store'])->name('admin.category.store');
        Route::get('/category/{id}/edit', [ProductCategory::class, 'edit'])->name('admin.category.edit');
        Route::post('/category/update', [ProductCategory::class, 'update'])->name('admin.category.update');
        Route::post('/category/feature', [ProductCategory::class, 'feature'])->name('admin.category.feature');
        Route::post('/category/home', [ProductCategory::class, 'home'])->name('admin.category.home');
        Route::post('/category/delete', [ProductCategory::class, 'delete'])->name('admin.category.delete');
        Route::post('/category/bulk-delete', [ProductCategory::class, 'bulkDelete'])->name('admin.pcategory.bulk.delete');

        Route::get('/shipping', [ShopSettingController::class, 'index'])->name('admin.shipping.index');
        Route::post('/shipping/store', [ShopSettingController::class, 'store'])->name('admin.shipping.store');
        Route::get('/shipping/{id}/edit', [ShopSettingController::class, 'edit'])->name('admin.shipping.edit');
        Route::post('/shipping/update', [ShopSettingController::class, 'update'])->name('admin.shipping.update');
        Route::post('/shipping/delete', [ShopSettingController::class, 'delete'])->name('admin.shipping.delete');


        Route::get('/product', [ProductController::class, 'index'])->name('admin.product.index');
        Route::get('/product/type', [ProductController::class, 'type'])->name('admin.product.type');
        Route::get('/product/create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('/product/store', [ProductController::class, 'store'])->name('admin.product.store');
        Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::post('/product/update', [ProductController::class, 'update'])->name('admin.product.update');
        Route::post('/product/feature', [ProductController::class, 'feature'])->name('admin.product.feature');
        Route::post('/product/delete', [ProductController::class, 'delete'])->name('admin.product.delete');
        Route::get('/product/populer/tags/', [ProductController::class, 'populerTag'])->name('admin.product.tags');
        Route::post('/product/populer/tags/update', [ProductController::class, 'populerTagupdate'])->name('admin.popular-tag.update');
        Route::post('/product/paymentStatus', [ProductController::class, 'paymentStatus'])->name('admin.product.paymentStatus');

        Route::get('product/{id}/getcategory', [ProductController::class, 'getCategory'])->name('admin.product.getcategory');
        Route::post('/product/delete', [ProductController::class, 'delete'])->name('admin.product.delete');
        Route::post('/product/bulk-delete', [ProductController::class, 'bulkDelete'])->name('admin.product.bulk.delete');
        Route::post('/product/sliderupdate', [ProductController::class, 'sliderupdate'])->name('admin.product.sliderupdate');
        Route::post('/product/{id}/uploadUpdate', [ProductController::class, 'uploadUpdate'])->name('admin.product.uploadUpdate');
        Route::post('/product/update', [ProductController::class, 'update'])->name('admin.product.update');
        Route::get('/product/{id}/images', [ProductController::class, 'images'])->name('admin.product.images');


        Route::get('/product/settings', [ProductController::class, 'settings'])->name('admin.product.settings');
        Route::post('/product/settings', [ProductController::class, 'updateSettings'])->name('admin.product.settings');


        // Admin Coupon Routes
        Route::get('/coupon', [CouponController::class, 'index'])->name('admin.coupon.index');
        Route::post('/coupon/store', [CouponController::class, 'store'])->name('admin.coupon.store');
        Route::get('/coupon/{id}/edit', [CouponController::class, 'edit'])->name('admin.coupon.edit');
        Route::post('/coupon/update', [CouponController::class, 'update'])->name('admin.coupon.update');
        Route::post('/coupon/delete', [CouponController::class, 'delete'])->name('admin.coupon.delete');
        // Admin Coupon Routes End


        // Product Order
        Route::get('/product/all/orders', [ProductOrderController::class, 'all'])->name('admin.all.product.orders');
        Route::get('/product/pending/orders', [ProductOrderController::class, 'pending'])->name('admin.pending.product.orders');
        Route::get('/product/processing/orders', [ProductOrderController::class, 'processing'])->name('admin.processing.product.orders');
        Route::get('/product/completed/orders', [ProductOrderController::class, 'completed'])->name('admin.completed.product.orders');
        Route::get('/product/rejected/orders', [ProductOrderController::class, 'rejected'])->name('admin.rejected.product.orders');
        Route::post('/product/orders/status', [ProductOrderController::class, 'status'])->name('admin.product.orders.status');
        Route::get('/product/orders/detais/{id}', [ProductOrderController::class, 'details'])->name('admin.product.details');
        Route::post('/product/order/delete', [ProductOrderController::class, 'orderDelete'])->name('admin.product.order.delete');
        Route::post('/product/order/bulk-delete', [ProductOrderController::class, 'bulkOrderDelete'])->name('admin.product.order.bulk.delete');
        Route::get('/product/orders/report', [ProductOrderController::class, 'report'])->name('admin.orders.report');
        Route::get('/product/export/report', [ProductOrderController::class, 'exportReport'])->name('admin.orders.export');
        // Product Order end
    });


    //Event Manage Routes
    Route::group(['middleware' => 'checkpermission:Events Management'], function () {
        Route::get('/event/categories', [EventCategoryController::class, 'index'])->name('admin.event.category.index');
        Route::post('/event/category/store', [EventCategoryController::class, 'store'])->name('admin.event.category.store');
        Route::post('/event/category/update', [EventCategoryController::class, 'update'])->name('admin.event.category.update');
        Route::post('/event/category/delete', [EventCategoryController::class, 'delete'])->name('admin.event.category.delete');
        Route::post('/event/categories/bulk-delete', [EventCategoryController::class, 'bulkDelete'])->name('admin.event.category.bulk.delete');


        // Admin Event Routes
        Route::get('/event/settings', [EventController::class, 'settings'])->name('admin.event.settings');
        Route::post('/event/settings', [EventController::class, 'updateSettings'])->name('admin.event.settings');
        Route::get('/events', [EventController::class, 'index'])->name('admin.event.index');
        Route::post('/event/upload', [EventController::class, 'upload'])->name('admin.event.upload');
        Route::post('/event/slider/remove', [EventController::class, 'sliderRemove'])->name('admin.event.slider-remove');
        Route::post('/event/store', [EventController::class, 'store'])->name('admin.event.store');
        Route::get('/event/{id}/edit', [EventController::class, 'edit'])->name('admin.event.edit');
        Route::get('/event/{id}/images', [EventController::class, 'images'])->name('admin.event.images');
        Route::post('/event/update', [EventController::class, 'update'])->name('admin.event.update');
        Route::post('/event/{id}/uploadUpdate', [EventController::class, 'uploadUpdate'])->name('admin.event.uploadUpdate');
        Route::post('/event/delete', [EventController::class, 'delete'])->name('admin.event.delete');
        Route::post('/event/bulk-delete', [EventController::class, 'bulkDelete'])->name('admin.event.bulk.delete');
        Route::get('/event/{lang_id}/get-categories', [EventController::class, 'getCategories'])->name('admin.event.get-categories');
        Route::get('/events/payment-log', [EventController::class, 'paymentLog'])->name('admin.event.payment.log');
        Route::post('/events/payment-log/delete', [EventController::class, 'paymentLogDelete'])->name('admin.event.payment.delete');
        Route::post('/events/payment/bulk-delete', [EventController::class, 'paymentLogBulkDelete'])->name('admin.event.payment.bulk.delete');
        Route::post('/events/payment-log-update', [EventController::class, 'paymentLogUpdate'])->name('admin.event.payment.log.update');
        Route::get('/events/report', [EventController::class, 'report'])->name('admin.event.report');
        Route::get('/events/export', [EventController::class, 'exportReport'])->name('admin.event.export');
    });
    //Donation Manage Routes
    Route::group(['middleware' => 'checkpermission:Donation Management'], function () {
        Route::get('/donations', [DonationController::class, 'index'])->name('admin.donation.index');
        Route::get('/donation/settings', [DonationController::class, 'settings'])->name('admin.donation.settings');
        Route::post('/donation/settings', [DonationController::class, 'updateSettings'])->name('admin.donation.settings');
        Route::post('/donation/store', [DonationController::class, 'store'])->name('admin.donation.store');
        Route::get('/donation/{id}/edit', [DonationController::class, 'edit'])->name('admin.donation.edit');
        Route::post('/donation/update', [DonationController::class, 'update'])->name('admin.donation.update');
        Route::post('/donation/{id}/uploadUpdate', [DonationController::class, 'uploadUpdate'])->name('admin.donation.uploadUpdate');
        Route::post('/donation/delete', [DonationController::class, 'delete'])->name('admin.donation.delete');
        Route::post('/donation/bulk-delete', [DonationController::class, 'bulkDelete'])->name('admin.donation.bulk.delete');
        Route::get('/donations/payment-log', [DonationController::class, 'paymentLog'])->name('admin.donation.payment.log');
        Route::post('/donations/payment/delete', [DonationController::class, 'paymentDelete'])->name('admin.donation.payment.delete');
        Route::post('/donations/bulk/delete', [DonationController::class, 'bulkPaymentDelete'])->name('admin.donation.payment.bulk.delete');
        Route::post('/donations/payment-log-update', [DonationController::class, 'paymentLogUpdate'])->name('admin.donation.payment.log.update');
        Route::get('/donation/report', [DonationController::class, 'report'])->name('admin.donation.report');
        Route::get('/donation/export', [DonationController::class, 'exportReport'])->name('admin.donation.export');
    });


    // Admin Event Calendar Routes
    Route::group(['middleware' => 'checkpermission:Event Calendar'], function () {
        Route::get('/calendars', [CalendarController::class, 'index'])->name('admin.calendar.index');
        Route::post('/calendar/store', [CalendarController::class, 'store'])->name('admin.calendar.store');
        Route::post('/calendar/update', [CalendarController::class, 'update'])->name('admin.calendar.update');
        Route::post('/calendar/delete', [CalendarController::class, 'delete'])->name('admin.calendar.delete');
        Route::post('/calendar/bulk-delete', [CalendarController::class, 'bulkDelete'])->name('admin.calendar.bulk.delete');
    });


    Route::group(['middleware' => 'checkpermission:Knowledgebase'], function () {
        // Admin Article Category Routes
        Route::get('/article_categories', [ArticleCategoryController::class, 'index'])->name('admin.article_category.index');
        Route::post('/article_category/store', [ArticleCategoryController::class, 'store'])->name('admin.article_category.store');
        Route::post('/article_category/update', [ArticleCategoryController::class, 'update'])->name('admin.article_category.update');
        Route::post('/article_category/delete', [ArticleCategoryController::class, 'delete'])->name('admin.article_category.delete');
        Route::post('/article_category/bulk_delete', [ArticleCategoryController::class, 'bulkDelete'])->name('admin.article_category.bulk_delete');

        // Admin Article Routes
        Route::get('/articles', [ArticleController::class, 'index'])->name('admin.article.index');
        Route::get('/article/{langId}/get_categories', [ArticleController::class, 'getCategories']);
        Route::post('/article/store', [ArticleController::class, 'store'])->name('admin.article.store');
        Route::get('/article/{id}/edit', [ArticleController::class, 'edit'])->name('admin.article.edit');
        Route::post('/article/update', [ArticleController::class, 'update'])->name('admin.article.update');
        Route::post('/article/delete', [ArticleController::class, 'delete'])->name('admin.article.delete');
        Route::post('/article/bulk_delete', [ArticleController::class, 'bulkDelete'])->name('admin.article.bulk_delete');
    });


    Route::group(['middleware' => 'checkpermission:Course Management'], function () {
        // Admin Course Category Routes
        Route::get('/course_categories', [CourseCategoryController::class, 'index'])->name('admin.course_category.index');
        Route::post('/course_category/store', [CourseCategoryController::class, 'store'])->name('admin.course_category.store');
        Route::post('/course_category/update', [CourseCategoryController::class, 'update'])->name('admin.course_category.update');
        Route::post('/course_category/delete', [CourseCategoryController::class, 'delete'])->name('admin.course_category.delete');
        Route::post('/course_category/bulk_delete', [CourseCategoryController::class, 'bulkDelete'])->name('admin.course_category.bulk_delete');

        // Admin Course Routes
        Route::get('/courses', [CourseController::class, 'index'])->name('admin.course.index');
        Route::get('/course/create', [CourseController::class, 'create'])->name('admin.course.create');
        Route::get('/course/{langId}/get_categories', [CourseController::class, 'getCategories']);
        Route::post('/course/store', [CourseController::class, 'store'])->name('admin.course.store');
        Route::get('/course/{id}/edit', [CourseController::class, 'edit'])->name('admin.course.edit');
        Route::post('/course/update', [CourseController::class, 'update'])->name('admin.course.update');
        Route::post('/course/delete', [CourseController::class, 'delete'])->name('admin.course.delete');
        Route::post('/course/bulk_delete', [CourseController::class, 'bulkDelete'])->name('admin.course.bulk_delete');
        Route::post('/course/featured', [CourseController::class, 'featured'])->name('admin.course.featured');
        Route::get('/course/purchase-log', [CourseController::class, 'purchaseLog'])->name('admin.course.purchaseLog');
        Route::post('/course/purchase/payment-status', [CourseController::class, 'purchasePaymentStatus'])->name('admin.course.purchasePaymentStatus');
        Route::post('/course/purchase/delete', [CourseController::class, 'purchaseDelete'])->name('admin.course.purchase.delete');
        Route::post('/course/purchase/delete', [CourseController::class, 'purchaseDelete'])->name('admin.course.purchaseDelete');
        Route::post('/course/purchase/bulk_delete', [CourseController::class, 'purchaseBulkOrderDelete'])->name('admin.course.purchaseBulkOrderDelete');

        // Admin Course Modules Routes
        Route::get('/course/{id?}/modules', [ModuleController::class, 'index'])->name('admin.course.module.index');
        Route::post('/course/module/store', [ModuleController::class, 'store'])->name('admin.course.module.store');
        Route::post('/course/module/update', [ModuleController::class, 'update'])->name('admin.course.module.update');
        Route::post('/course/module/delete', [ModuleController::class, 'delete'])->name('admin.course.module.delete');
        Route::post('/course/module/bulk_delete', [ModuleController::class, 'bulkDelete'])->name('admin.course.module.bulk_delete');

        // Admin Module Lessons Routes
        Route::get('/module/{id}/lessons', [LessonController::class, 'index'])->name('admin.module.lesson.index');
        Route::post('/module/lesson/store', [LessonController::class, 'store'])->name('admin.module.lesson.store');
        Route::post('module/lesson/update', [LessonController::class, 'update'])->name('admin.module.lesson.update');
        Route::post('/module/lesson/delete', [LessonController::class, 'delete'])->name('admin.module.lesson.delete');
        Route::post('/module/lesson/bulk_delete', [LessonController::class, 'bulkDelete'])->name('admin.module.lesson.bulk_delete');

        Route::get('/course/settings', [CourseController::class, 'settings'])->name('admin.course.settings');
        Route::post('/course/settings', [CourseController::class, 'updateSettings'])->name('admin.course.settings');

        // Admin Course Enroll Report Routes
        Route::get('/course/enrolls/report', [CourseController::class, 'report'])->name('admin.enrolls.report');
        Route::get('/course/export/report', [CourseController::class, 'exportReport'])->name('admin.enrolls.export');
    });


    Route::group(['middleware' => 'checkpermission:RSS Feeds'], function () {
        // Admin RSS feed Routes
        Route::get('/rss', [RssFeedsController::class, 'index'])->name('admin.rss.index');
        Route::get('/rss/feeds', [RssFeedsController::class, 'feed'])->name('admin.rss.feed');
        Route::get('/rss/create', [RssFeedsController::class, 'create'])->name('admin.rss.create');
        Route::post('/rss', [RssFeedsController::class, 'store'])->name('admin.rss.store');
        Route::get('/rss/edit/{id}', [RssFeedsController::class, 'edit'])->name('admin.rss.edit');
        Route::post('/rss/update', [RssFeedsController::class, 'update'])->name('admin.rss.update');
        Route::post('/rss/delete', [RssFeedsController::class, 'rssdelete'])->name('admin.rssfeed.delete');
        Route::post('/rss/feed/delete', [RssFeedsController::class, 'delete'])->name('admin.rss.delete');
        Route::post('/rss-posts/bulk/delete', [RssFeedsController::class, 'bulkDelete'])->name('admin.rss.bulk.delete');

        Route::get('rss-feed/update/{id}', [RssFeedsController::class, 'feedUpdate'])->name('admin.rss.feedUpdate');
        Route::get('rss-feed/cronJobUpdate', [RssFeedsController::class, 'cronJobUpdate'])->name('rss.cronJobUpdate');
    });


    Route::group(['middleware' => 'checkpermission:Users Management'], function () {
        // Register User start
        Route::get('register/users', [RegisterUserController::class, 'index'])->name('admin.register.user');
        Route::post('register/users/ban', [RegisterUserController::class, 'userban'])->name('register.user.ban');
        Route::post('register/users/email', [RegisterUserController::class, 'emailStatus'])->name('register.user.email');
        Route::get('register/user/details/{id}', [RegisterUserController::class, 'view'])->name('register.user.view');
        Route::post('register/user/delete', [RegisterUserController::class, 'delete'])->name('register.user.delete');
        Route::post('register/user/bulk-delete', [RegisterUserController::class, 'bulkDelete'])->name('register.user.bulk.delete');
        Route::get('register/user/{id}/changePassword', [RegisterUserController::class, 'changePass'])->name('register.user.changePass');
        Route::post('register/user/updatePassword', [RegisterUserController::class, 'updatePassword'])->name('register.user.updatePassword');
        //Register User end

        // Admin Push Notification Routes
        Route::get('/pushnotification/settings', [PushController::class, 'settings'])->name('admin.pushnotification.settings');
        Route::post('/pushnotification/update/settings', [PushController::class, 'updateSettings'])->name('admin.pushnotification.updateSettings');
        Route::get('/pushnotification/send', [PushController::class, 'send'])->name('admin.pushnotification.send');
        Route::post('/push', [PushController::class, 'push'])->name('admin.pushnotification.push');


        // Admin Subscriber Routes
        Route::get('/subscribers', [SubscriberController::class, 'index'])->name('admin.subscriber.index');
        Route::get('/mailsubscriber', [SubscriberController::class, 'mailsubscriber'])->name('admin.mailsubscriber');
        Route::post('/subscribers/sendmail', [SubscriberController::class, 'subscsendmail'])->name('admin.subscribers.sendmail');
        Route::post('/subscriber/delete', [SubscriberController::class, 'delete'])->name('admin.subscriber.delete');
        Route::post('/subscriber/bulk-delete', [SubscriberController::class, 'bulkDelete'])->name('admin.subscriber.bulk.delete');
    });


    Route::group(['middleware' => 'checkpermission:Tickets'], function () {
        // Admin Support Ticket Routes
        Route::get('/all/tickets', [TicketController::class, 'all'])->name('admin.tickets.all');
        Route::get('/pending/tickets', [TicketController::class, 'pending'])->name('admin.tickets.pending');
        Route::get('/open/tickets', [TicketController::class, 'open'])->name('admin.tickets.open');
        Route::get('/closed/tickets', [TicketController::class, 'closed'])->name('admin.tickets.closed');
        Route::get('/ticket/messages/{id}', [TicketController::class, 'messages'])->name('admin.ticket.messages');
        Route::post('/zip-file/upload/', [TicketController::class, 'zip_file_upload'])->name('admin.zip_file.upload');
        Route::post('/ticket/reply/{id}', [TicketController::class, 'ticketReply'])->name('admin.ticket.reply');
        Route::get('/ticket/close/{id}', [TicketController::class, 'ticketclose'])->name('admin.ticket.close');
        Route::post('/ticket/assign/staff', [TicketController::class, 'ticketAssign'])->name('ticket.assign.staff');
        Route::get('/ticket/settings', [TicketController::class, 'settings'])->name('admin.ticket.settings');
        Route::post('/ticket/settings', [TicketController::class, 'updateSettings'])->name('admin.ticket.settings');
    });


    Route::group(['middleware' => 'checkpermission:Package Management'], function () {

        // Admin Package Form Builder Routes
        Route::get('/package/settings', [PackageController::class, 'settings'])->name('admin.package.settings');
        Route::post('/package/settings', [PackageController::class, 'updateSettings'])->name('admin.package.settings');

        // Admin Package Category Routes
        Route::get('/package/categories', [PackageCategoryController::class, 'index'])->name('admin.package.categories');
        Route::post('/package/store_category', [PackageCategoryController::class, 'store'])->name('admin.package.store_category');
        Route::post('/package/update_category', [PackageCategoryController::class, 'update'])->name('admin.package.update_category');
        Route::post('/package/delete_category', [PackageCategoryController::class, 'delete'])->name('admin.package.delete_category');
        Route::post('/package/bulk_delete_category', [PackageCategoryController::class, 'bulkDelete'])->name('admin.package.bulk_delete_category');

        Route::get('/package/form', [PackageController::class, 'form'])->name('admin.package.form');
        Route::post('/package/form/store', [PackageController::class, 'formstore'])->name('admin.package.form.store');
        Route::post('/package/inputDelete', [PackageController::class, 'inputDelete'])->name('admin.package.inputDelete');
        Route::get('/package/{id}/inputEdit', [PackageController::class, 'inputEdit'])->name('admin.package.inputEdit');
        Route::get('/package/{id}/options', [PackageController::class, 'options'])->name('admin.package.options');
        Route::post('/package/inputUpdate', [PackageController::class, 'inputUpdate'])->name('admin.package.inputUpdate');
        Route::post('/package/feature', [PackageController::class, 'feature'])->name('admin.package.feature');



        // Admin Packages Routes
        Route::get('/packages', [PackageController::class, 'index'])->name('admin.package.index');
        Route::get('/package/{langId}/get_categories', [PackageController::class, 'getCategories']);
        Route::post('/package/store', [PackageController::class, 'store'])->name('admin.package.store');
        Route::get('/package/{id}/edit', [PackageController::class, 'edit'])->name('admin.package.edit');
        Route::post('/package/update', [PackageController::class, 'update'])->name('admin.package.update');
        Route::post('/package/delete', [PackageController::class, 'delete'])->name('admin.package.delete');
        Route::post('/package/bulk-delete', [PackageController::class, 'bulkDelete'])->name('admin.package.bulk.delete');
        Route::post('/package/payment-status', [PackageController::class, 'paymentStatus'])->name('admin.package.paymentStatus');

        // Admin Package Orders Routes
        Route::get('/all/orders', [PackageController::class, 'all'])->name('admin.all.orders');
        Route::get('/pending/orders', [PackageController::class, 'pending'])->name('admin.pending.orders');
        Route::get('/processing/orders', [PackageController::class, 'processing'])->name('admin.processing.orders');
        Route::get('/completed/orders', [PackageController::class, 'completed'])->name('admin.completed.orders');
        Route::get('/rejected/orders', [PackageController::class, 'rejected'])->name('admin.rejected.orders');
        Route::post('/orders/status', [PackageController::class, 'status'])->name('admin.orders.status');
        Route::post('/orders/mail', [PackageController::class, 'mail'])->name('admin.orders.mail');
        Route::post('/package/order/delete', [PackageController::class, 'orderDelete'])->name('admin.package.order.delete');
        Route::post('/order/bulk-delete', [PackageController::class, 'bulkOrderDelete'])->name('admin.order.bulk.delete');
        Route::get('/package/order/report', [PackageController::class, 'report'])->name('admin.package.report');
        Route::get('/package/order/export', [PackageController::class, 'exportReport'])->name('admin.package.export');

        // Admin Subscription Routes
        Route::get('/subscriptions', [SubscriptionController::class, 'subscriptions'])->name('admin.subscriptions');
        Route::get('/subscription/requests', [SubscriptionController::class, 'requests'])->name('admin.requests.subscriptions');
        Route::post('/subscription/mail', [SubscriptionController::class, 'mail'])->name('admin.subscription.mail');
        Route::post('/package/subscription/delete', [SubscriptionController::class, 'subDelete'])->name('admin.package.subDelete');
        Route::post('/package/subscription/status', [SubscriptionController::class, 'status'])->name('admin.subscription.status');
        Route::post('/sub/bulk-delete', [SubscriptionController::class, 'bulkSubDelete'])->name('admin.sub.bulk.delete');
    });



    Route::group(['middleware' => 'checkpermission:Quote Management'], function () {

        // Admin Quote Form Builder Routes
        Route::get('/quote/visibility', [QuoteController::class, 'visibility'])->name('admin.quote.visibility');
        Route::post('/quote/visibility/update', [QuoteController::class, 'updateVisibility'])->name('admin.quote.visibility.update');
        Route::get('/quote/form', [QuoteController::class, 'form'])->name('admin.quote.form');
        Route::post('/quote/form/store', [QuoteController::class, 'formstore'])->name('admin.quote.form.store');
        Route::post('/quote/inputDelete', [QuoteController::class, 'inputDelete'])->name('admin.quote.inputDelete');
        Route::get('/quote/{id}/inputEdit', [QuoteController::class, 'inputEdit'])->name('admin.quote.inputEdit');
        Route::get('/quote/{id}/options', [QuoteController::class, 'options'])->name('admin.quote.options');
        Route::post('/quote/inputUpdate', [QuoteController::class, 'inputUpdate'])->name('admin.quote.inputUpdate');
        Route::post('/quote/delete', [QuoteController::class, 'delete'])->name('admin.quote.delete');
        Route::post('/quote/bulk-delete', [QuoteController::class, 'bulkDelete'])->name('admin.quote.bulk.delete');


        // Admin Quote Routes
        Route::get('/all/quotes', [QuoteController::class, 'all'])->name('admin.all.quotes');
        Route::get('/pending/quotes', [QuoteController::class, 'pending'])->name('admin.pending.quotes');
        Route::get('/processing/quotes', [QuoteController::class, 'processing'])->name('admin.processing.quotes');
        Route::get('/completed/quotes', [QuoteController::class, 'completed'])->name('admin.completed.quotes');
        Route::get('/rejected/quotes', [QuoteController::class, 'rejected'])->name('admin.rejected.quotes');
        Route::post('/quotes/status', [QuoteController::class, 'status'])->name('admin.quotes.status');
        Route::post('/quote/mail', [QuoteController::class, 'mail'])->name('admin.quotes.mail');
    });

    Route::group(['middleware' => 'checkpermission:Quote Management'], function () {

        // Admin Quote Form Builder Routes
        Route::get('/quote/visibility', [QuoteController::class, 'visibility'])->name('admin.quote.visibility');
        Route::post('/quote/visibility/update', [QuoteController::class, 'updateVisibility'])->name('admin.quote.visibility.update');
        Route::get('/quote/form', [QuoteController::class, 'form'])->name('admin.quote.form');
        Route::post('/quote/form/store', [QuoteController::class, 'formstore'])->name('admin.quote.form.store');
        Route::post('/quote/inputDelete', [QuoteController::class, 'inputDelete'])->name('admin.quote.inputDelete');
        Route::get('/quote/{id}/inputEdit', [QuoteController::class, 'inputEdit'])->name('admin.quote.inputEdit');
        Route::get('/quote/{id}/options', [QuoteController::class, 'options'])->name('admin.quote.options');
        Route::post('/quote/inputUpdate', [QuoteController::class, 'inputUpdate'])->name('admin.quote.inputUpdate');
        Route::post('/quote/delete', [QuoteController::class, 'delete'])->name('admin.quote.delete');
        Route::post('/quote/bulk-delete', [QuoteController::class, 'bulkDelete'])->name('admin.quote.bulk.delete');


        // Admin Quote Routes
        Route::get('/all/quotes', [QuoteController::class, 'all'])->name('admin.all.quotes');
        Route::get('/pending/quotes', [QuoteController::class, 'pending'])->name('admin.pending.quotes');
        Route::get('/processing/quotes', [QuoteController::class, 'processing'])->name('admin.processing.quotes');
        Route::get('/completed/quotes', [QuoteController::class, 'completed'])->name('admin.completed.quotes');
        Route::get('/rejected/quotes', [QuoteController::class, 'rejected'])->name('admin.rejected.quotes');
        Route::post('/quotes/status', [QuoteController::class, 'status'])->name('admin.quotes.status');
        Route::post('/quote/mail', [QuoteController::class, 'mail'])->name('admin.quotes.mail');
    });


    Route::group(['middleware' => 'checkpermission:Role Management'], function () {
        // Admin Roles Routes
        Route::get('/roles', [RoleController::class, 'index'])->name('admin.role.index');
        Route::post('/role/store', [RoleController::class, 'store'])->name('admin.role.store');
        Route::post('/role/update', [RoleController::class, 'update'])->name('admin.role.update');
        Route::post('/role/delete', [RoleController::class, 'delete'])->name('admin.role.delete');
        Route::get('role/{id}/permissions/manage', [RoleController::class, 'managePermissions'])->name('admin.role.permissions.manage');
        Route::post('role/permissions/update', [RoleController::class, 'updatePermissions'])->name('admin.role.permissions.update');
    });

    Route::group(['middleware' => 'checkpermission:Users Management'], function () {
        // Admin Users Routes
        Route::get('/users', [UserController::class, 'index'])->name('admin.user.index');
        Route::post('/user/store', [UserController::class, 'store'])->name('admin.user.store');
        Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::post('/user/update', [UserController::class, 'update'])->name('admin.user.update');
        Route::post('/user/delete', [UserController::class, 'delete'])->name('admin.user.delete');
    });



    Route::group(['middleware' => 'checkpermission:Client Feedbacks'], function () {
        // Admin View Client Feedbacks Routes
        Route::get('/feedbacks', [FeedbackController::class, 'feedbacks'])->name('admin.client_feedbacks');
        Route::post('/delete_feedback', [FeedbackController::class, 'deleteFeedback'])->name('admin.delete_feedback');
        Route::post('/feedback/bulk-delete', [FeedbackController::class, 'bulkDelete'])->name('admin.feedback.bulk.delete');
    });

   
});





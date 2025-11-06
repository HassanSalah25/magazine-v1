<?php

// Include SaaS Admin routes
require __DIR__.'/saas-admin.php';

use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\FreeAnalysisController;
use App\Http\Controllers\Front\CourseController;
use App\Http\Controllers\Front\FreeCourseEnrollController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\PushController; 
use App\Http\Controllers\Payment\Course\FlutterwaveGatewayController;
use App\Http\Controllers\Payment\Course\InstamojoGatewayController;
use App\Http\Controllers\Payment\Course\MercadoPagoGatewayController;
use App\Http\Controllers\Payment\Course\MollieGatewayController;
use App\Http\Controllers\Payment\Course\OfflineController;
use App\Http\Controllers\Payment\Course\PayPalGatewayController;
use App\Http\Controllers\Payment\Course\PaystackGatewayController;
use App\Http\Controllers\Payment\Course\PaytmGatewayController;
use App\Http\Controllers\Payment\Course\PayuMoneyController;
use App\Http\Controllers\Payment\Course\RazorpayGatewayController;
use App\Http\Controllers\Payment\Course\StripeGatewayController;
use App\Http\Controllers\Payment\product\FlutterWaveController;
use App\Http\Controllers\Payment\product\InstamojoController;
use App\Http\Controllers\Payment\product\MercadopagoController;
use App\Http\Controllers\Payment\product\MollieController;
use App\Http\Controllers\Payment\product\PaymentController;
use App\Http\Controllers\Payment\product\PaypalController;
use App\Http\Controllers\Payment\product\PaystackController;
use App\Http\Controllers\Payment\product\PaytmController;
use App\Http\Controllers\Payment\product\StripeController;
use App\Http\Controllers\Payment\product\OfflineController as ProductOfflineController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\FrontendController;
use App\Http\Controllers\User\CourseOrderController;
use App\Http\Controllers\User\DonationController;
use App\Http\Controllers\User\EventController;
use App\Http\Controllers\User\ForgotController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\PackageController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\User\SummernoteController;
use App\Http\Controllers\User\TicketController;
use App\Http\Controllers\User\UserController;
use App\Models\Permalink;
use App\Models\Tenant;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;
use App\Http\Middleware\InitializeTenancyByPath;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth:admin', 'setLfmPath']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
    Route::post('summernote/upload', 'Admin\SummernoteController@uploadFileManager')->name('lfm.summernote.upload');
});
if (!app()->runningInConsole()) {
    // Dynamic Routes
    Route::group(['middleware' => ['setlang', 'forceLowercase']], function () {
        

        $wdPermalinks = Permalink::where('details', 1)->get();
        foreach ($wdPermalinks as $pl) {
            $type = $pl->type;
            $permalink = $pl->permalink;

            if ($type == 'package_order') {
                Route::get("$permalink/{id}", [FrontendController::class, 'packageorder'])->name('front.packageorder.index');
            } elseif ($type == 'service_details') {
                Route::get("$permalink/{slug}", [FrontendController::class, 'servicedetails'])->name('front.servicedetails');
            } elseif ($type == 'portfolio_details') {
                Route::get("$permalink/{slug}", [FrontendController::class, 'portfoliodetails'])->name('front.portfoliodetails');
            } elseif ($type == 'product_details') {
                Route::get("$permalink/{slug}", [ProductController::class, 'productDetails'])->name('front.product.details');
            } elseif ($type == 'course_details') {
                Route::get("$permalink/{slug}", [CourseController::class, 'courseDetails'])->name('course_details');
            } elseif ($type == 'cause_details') {
                Route::get("$permalink/{slug}", [FrontendController::class, 'causeDetails'])->name('front.cause_details');
            } elseif ($type == 'event_details') {
                Route::get("$permalink/{slug}", [FrontendController::class, 'eventDetails'])->name('front.event_details');
            } elseif ($type == 'career_details') {
                Route::get("$permalink/{slug}", [FrontendController::class, 'careerdetails'])->name('front.careerdetails');
            } elseif ($type == 'knowledgebase_details') {
                Route::get("$permalink/{slug}", [FrontendController::class, 'knowledgebase_details'])->name('front.knowledgebase_details');
            } elseif ($type == 'blog_details') {
                Route::get("$permalink/{slug}", [FrontendController::class, 'blogdetails'])->name('front.blogdetails');
            } elseif ($type == 'rss_details') {
                Route::get("$permalink/{slug}/{id}", [FrontendController::class, 'rssdetails'])->name('front.rssdetails');
            } elseif ($type == 'tags') {
                Route::get("$permalink/{slug}", [FrontendController::class, 'tag'])->name('front.tag');
            } elseif ($type == 'services') {
                Route::get("$permalink/{slug?}", [FrontendController::class, 'services'])->name('front.services');
            } elseif ($type == 'blogs') {
                Route::get("$permalink/{slug?}", [FrontendController::class, 'blogs'])->name('front.blogs');
            }
        }
    });

    // Dynamic Routes
    Route::group(['middleware' => ['setlang', 'forceLowercase']], function () {

        $wdPermalinks = Permalink::where('details', 0)->get();
        foreach ($wdPermalinks as $pl) {
            $type = $pl->type;
            $permalink = $pl->permalink;


            if ($type == 'packages') {
                $action = [FrontendController::class, 'packages'];
                $routeName = 'front.packages';
            } elseif ($type == 'services') {
                $action = [FrontendController::class, 'services'];
                $routeName = 'front.services';
            } elseif ($type == 'service_categories') {
                $action = [FrontendController::class, 'scategories'];
                $routeName = 'front.scategories';
            } elseif ($type == 'portfolios') {
                $action = [FrontendController::class, 'portfolios'];
                $routeName = 'front.portfolios';
            } elseif ($type == 'products') {
                $action = [ProductController::class, 'product'];
                $routeName = 'front.product';
            } elseif ($type == 'cart') {
                $action = [ProductController::class, 'cart'];
                $routeName = 'front.cart';
            } elseif ($type == 'product_checkout') {
                $action = [ProductController::class, 'checkout'];
                $routeName = 'front.checkout';
            } elseif ($type == 'team') {
                $action = [FrontendController::class, 'team'];
                $routeName = 'front.team';
            } elseif ($type == 'courses') {
                $action = [CourseController::class, 'courses'];
                $routeName = 'courses';
            } elseif ($type == 'causes') {
                $action = [FrontendController::class, 'causes'];
                $routeName = 'front.causes';
            } elseif ($type == 'events') {
                $action = [FrontendController::class, 'events'];
                $routeName = 'front.events';
            } elseif ($type == 'career') {
                $action = [FrontendController::class, 'career'];
                $routeName = 'front.career';
            } elseif ($type == 'event_calendar') {
                $action = [FrontendController::class, 'calendar'];
                $routeName = 'front.calendar';
            } elseif ($type == 'knowledgebase') {
                $action = [FrontendController::class, 'knowledgebase'];
                $routeName = 'front.knowledgebase';
            } elseif ($type == 'gallery') {
                $action = [FrontendController::class, 'gallery'];
                $routeName = 'front.gallery';
            } elseif ($type == 'faq') {
                $action = [FrontendController::class, 'faq'];
                $routeName = 'front.faq';
            } elseif ($type == 'ourstory') {
                $action = [FrontendController::class, 'ourstory'];
                $routeName = 'front.ourstory';
            } elseif ($type == 'rss') {
                $action = [FrontendController::class, 'rss'];
                $routeName = 'front.rss';
            } elseif ($type == 'contact') {
                $action = [FrontendController::class, 'contact'];
                $routeName = 'front.contact';
            } elseif ($type == 'quote') {
                $action = [FrontendController::class, 'quote'];
                $routeName = 'front.quote';
            } elseif ($type == 'login') {
                $action = [LoginController::class, 'showLoginForm'];
                $routeName = 'user.login';
            } elseif ($type == 'register') {
                $action = [RegisterController::class, 'registerPage'];
                $routeName = 'user-register';
            } elseif ($type == 'forget_password') {
                $action = [ForgotController::class, 'showforgotform'];
                $routeName = 'user-forgot';
            } elseif ($type == 'admin_login') {
                $action = [\App\Http\Controllers\Admin\LoginController::class,'login'];
                $routeName = 'admin.login';
                Route::get("$permalink", $action)->name("$routeName")->middleware('guest:admin');
                continue;
            }

            Route::get("$permalink", $action)->name("$routeName");
        }
    });
}
// Tenant Routes - Routes that work with tenant prefix /tenant/{tenant_id}/
Route::group(['prefix' => 'tenant/{tenant_id}', 'where' => ['tenant_id' => '[^\/]+'], 'middleware' => [InitializeTenancyByPath::class]], function () {
    // Include all the existing routes here, but they'll be prefixed with /tenant/{tenant_id}
    Route::group(['middleware' => 'setlang'], function () {
        Route::get('/', [FrontendController::class, 'index'])->name('tenant.front.index');
        Route::get('/landingpage1', [FrontendController::class, 'landingpage1'])->name('tenant.front.landingpage1');
        Route::get('/landingpage2', [FrontendController::class, 'landingpage2'])->name('tenant.front.landingpage2');
        Route::get('/landingpage3', [FrontendController::class, 'landingpage3'])->name('tenant.front.landingpage3');

        Route::group(['prefix' => 'donation'], function () {
            Route::get('/paystack/success', [Payment\causes\PaystackController::class, 'successPayment'])->name('tenant.donation.paystack.success');
        });

        //causes donation payment
        Route::post('/cause/payment', [CausesController::class, 'makePayment'])->name('tenant.front.causes.payment');
        //event tickets payment
        Route::post('/event/payment', [EventController::class, 'makePayment'])->name('tenant.front.event.payment');
        //causes donation payment via Paypal
        Route::get('/cause/paypal/payment/success', [Payment\causes\PaypalController::class, 'successPayment'])->name('tenant.donation.paypal.success');
        Route::get('/cause/paypal/payment/cancel', [Payment\causes\PaypalController::class, 'cancelPayment'])->name('tenant.donation.paypal.cancel');

        //causes donation payment via Paytm
        Route::post('/cause/paytm/payment/success', [Payment\causes\PaytmController::class, 'paymentStatus'])->name('tenant.donation.paytm.paymentStatus');

        //causes donation payment via Razorpay
        Route::post('/cause/razorpay/payment/success', [Payment\causes\RazorpayController::class, 'successPayment'])->name('tenant.donation.razorpay.success');
        Route::post('/cause/razorpay/payment/cancel', [Payment\causes\RazorpayController::class, 'cancelPayment'])->name('tenant.donation.razorpay.cancel');

        //causes donation payment via Payumoney
        Route::post('/cause/payumoney/payment', [Payment\causes\PayumoneyController::class, 'payment'])->name('tenant.donation.payumoney.payment');

        //causes donation payment via Flutterwave
        Route::post('/cause/flutterwave/success', [Payment\causes\FlutterWaveController::class, 'successPayment'])->name('tenant.donation.flutterwave.success');
        Route::post('/cause/flutterwave/cancel', [Payment\causes\FlutterWaveController::class, 'cancelPayment'])->name('tenant.donation.flutterwave.cancel');
        Route::get('/cause/flutterwave/success', [Payment\causes\FlutterWaveController::class, 'successPage'])->name('tenant.donation.flutterwave.successPage');

        //causes donation payment via Instamojo
        Route::get('/cause/instamojo/success', [Payment\causes\InstamojoController::class, 'successPayment'])->name('tenant.donation.instamojo.success');
        Route::post('/cause/instamojo/cancel', [Payment\causes\InstamojoController::class, 'cancelPayment'])->name('tenant.donation.instamojo.cancel');

        //causes donation payment via Mollie
        Route::get('/cause/mollie/success', [Payment\causes\MollieController::class, 'successPayment'])->name('tenant.donation.mollie.success');
        Route::post('/cause/mollie/cancel', [Payment\causes\MollieController::class, 'cancelPayment'])->name('tenant.donation.mollie.cancel');
        // Mercado Pago
        Route::post('/cause/mercadopago/cancel', [Payment\causes\MercadopagoController::class, 'cancelPayment'])->name('tenant.donation.mercadopago.cancel');
        Route::post('/cause/mercadopago/success', [Payment\causes\MercadopagoController::class, 'successPayment'])->name('tenant.donation.mercadopago.success');
        Route::post('/payment/instructions', [FrontendController::class, 'paymentInstruction'])->name('tenant.front.payment.instructions');

        Route::post('/sendmail', [FrontendController::class, 'sendmail'])->name('tenant.front.sendmail');
        Route::post('/subscribe', [FrontendController::class, 'subscribe'])->name('tenant.front.subscribe');
        Route::post('/blog-comment/store', [FrontendController::class, 'storeBlogComment'])->name('tenant.front.blogcomment.store');
        Route::get('/quote', [FrontendController::class, 'quote'])->name('tenant.front.quote');
        Route::post('/sendquote', [FrontendController::class, 'sendquote'])->name('tenant.front.sendquote');
        Route::get('/quote/success', [FrontendController::class, 'quoteSuccess'])->name('tenant.front.quote.success');

        Route::get('/checkout/payment/{slug1}/{slug2}', [FrontendController::class, 'loadpayment'])->name('tenant.front.load.payment');

        // Package Order Routes
        Route::post('/package-order', [FrontendController::class, 'submitorder'])->name('tenant.front.packageorder.submit');
        // Lightweight subscription request (modal) -> creates pending subscription
        Route::post('/subscription-request', [FrontendController::class, 'subscriptionRequest'])->name('tenant.front.subscription.request');
        // Load dynamic package custom inputs for modal
        Route::get('/package-inputs', [FrontendController::class, 'packageInputs'])->name('tenant.front.package.inputs');
        
        // Load dynamic quote custom inputs for modal
        Route::get('/quote-inputs', [FrontendController::class, 'quoteInputs'])->name('tenant.front.quote.inputs');
        Route::get('/order-confirmation/{packageid}/{packageOrderId}', [FrontendController::class, 'orderConfirmation'])->name('tenant.front.packageorder.confirmation');
        Route::get('/payment/{packageid}/cancle', 'Payment\PaymentController@paycancle')->name('tenant.front.payment.cancle');
        //Paypal Routes
        Route::post('/paypal/submit', 'Payment\PaypalController@store')->name('tenant.front.paypal.submit');
        Route::get('/paypal/{packageid}/notify', 'Payment\PaypalController@notify')->name('tenant.front.paypal.notify');
        //Stripe Routes
        Route::post('/stripe/submit', 'Payment\StripeController@store')->name('tenant.front.stripe.submit');
        //Paystack Routes
        Route::post('/paystack/submit', 'Payment\PaystackController@store')->name('tenant.front.paystack.submit');
        //PayTM Routes
        Route::post('/paytm/submit', 'Payment\PaytmController@store')->name('tenant.front.paytm.submit');
        Route::post('/paytm/notify', 'Payment\PaytmController@notify')->name('tenant.front.paytm.notify');
        //Flutterwave Routes
        Route::post('/flutterwave/submit', 'Payment\FlutterWaveController@store')->name('tenant.front.flutterwave.submit'); 
        Route::post('/flutterwave/notify', 'Payment\FlutterWaveController@notify')->name('tenant.front.flutterwave.notify');
        //Instamojo Routes
        Route::post('/instamojo/submit', 'Payment\InstamojoController@store')->name('tenant.front.instamojo.submit');
        Route::get('/instamojo/notify', 'Payment\InstamojoController@notify')->name('tenant.front.instamojo.notify');
        //Mollie Routes
        Route::post('/mollie/submit', 'Payment\MollieController@store')->name('tenant.front.mollie.submit');
        Route::get('/mollie/notify', 'Payment\MollieController@notify')->name('tenant.front.mollie.notify');
        // RazorPay
        Route::post('razorpay/submit', 'Payment\RazorpayController@store')->name('tenant.front.razorpay.submit');
        Route::post('razorpay/notify', 'Payment\RazorpayController@notify')->name('tenant.front.razorpay.notify');
        // Mercado Pago
        Route::post('mercadopago/submit', 'Payment\MercadopagoController@store')->name('tenant.front.mercadopago.submit');
        Route::post('mercadopago/notify', 'Payment\MercadopagoController@notify')->name('tenant.front.mercadopago.notify');
        // Payu
        Route::post('/payumoney/submit', 'Payment\PayumoneyController@store')->name('tenant.front.payumoney.submit');
        Route::post('/payumoney/notify', 'Payment\PayumoneyController@notify')->name('tenant.front.payumoney.notify');
        //Offline Routes
        Route::post('/offline/{oid}/submit', 'Payment\OfflineController@store')->name('tenant.front.offline.submit');

        Route::get('/team', [FrontendController::class, 'team'])->name('tenant.front.team');
        Route::get('/gallery', [FrontendController::class, 'gallery'])->name('tenant.front.gallery');
        Route::get('/faq', [FrontendController::class, 'faq'])->name('tenant.front.faq');

        // change language routes
        Route::get('/changelanguage/{lang}', [FrontendController::class, 'changeLanguage'])->name('tenant.changeLanguage');

        // Product
        Route::get('/cart', [ProductController::class, 'cart'])->name('tenant.front.cart');
        Route::post('/add-to-cart/{id}', [ProductController::class, 'addToCart'])->name('tenant.add.cart');
        Route::post('/cart/update', [ProductController::class, 'updatecart'])->name('tenant.cart.update');
        Route::get('/cart/item/remove/{id}', [ProductController::class, 'cartitemremove'])->name('tenant.cart.item.remove');
        Route::get('/checkout', [ProductController::class, 'checkout'])->name('tenant.front.checkout');
        Route::get('/checkout/{slug}', [ProductController::class, 'Prdouctcheckout'])->name('tenant.front.product.checkout');
        Route::post('/coupon', [ProductController::class, 'coupon'])->name('tenant.front.coupon');

        // review
        Route::post('product/review/submit', [ReviewController::class, 'reviewsubmit'])->name('tenant.product.review.submit');

        // CHECKOUT SECTION
        Route::get('/product/payment/return', [PaymentController::class, 'payreturn'])->name('tenant.product.payment.return');
        Route::get('/product/payment/cancle', [PaymentController::class, 'paycancle'])->name('tenant.product.payment.cancle');
        Route::get('/product/paypal/notify', [PaypalController::class, 'notify'])->name('tenant.product.paypal.notify');
        // paypal routes
        Route::post('/product/paypal/submit', [PaypalController::class, 'store'])->name('tenant.product.paypal.submit');
        // stripe routes
        Route::post('/product/stripe/submit', [StripeController::class, 'store'])->name('tenant.product.stripe.submit');
        Route::post('/product/offline/{gatewayid}/submit', [ProductOfflineController::class, 'store'])->name('tenant.product.offline.submit');
        //Flutterwave Routes
        Route::post('/product/flutterwave/submit', [FlutterWaveController::class, 'store'])->name('tenant.product.flutterwave.submit');
        Route::post('/product/flutterwave/notify', [FlutterWaveController::class, 'notify'])->name('tenant.product.flutterwave.notify');
        Route::get('/product/flutterwave/notify', [FlutterWaveController::class, 'success'])->name('tenant.product.flutterwave.success');
        //Paystack Routes
        Route::post('/product/paystack/submit', [PaystackController::class, 'store'])->name('tenant.product.paystack.submit');
        // RazorPay
        Route::post('/product/razorpay/submit', [RazorpayController::class, 'store'])->name('tenant.product.razorpay.submit');
        Route::post('/product/razorpay/notify', [RazorpayController::class, 'notify'])->name('tenant.product.razorpay.notify');
        //Instamojo Routes
        Route::post('/product/instamojo/submit', [InstamojoController::class, 'store'])->name('tenant.product.instamojo.submit');
        Route::get('/product/instamojo/notify', [InstamojoController::class, 'notify'])->name('tenant.product.instamojo.notify');
        //PayTM Routes
        Route::post('/product/paytm/submit', [PaytmController::class, 'store'])->name('tenant.product.paytm.submit');
        Route::post('/product/paytm/notify', [PaytmController::class, 'notify'])->name('tenant.product.paytm.notify');
        //Mollie Routes
        Route::post('/product/mollie/submit', [MollieController::class, 'store'])->name('tenant.product.mollie.submit');
        Route::get('/product/mollie/notify', [MollieController::class, 'notify'])->name('tenant.product.mollie.notify');
        // Mercado Pago
        Route::post('/product/mercadopago/submit', [MercadopagoController::class, 'store'])->name('tenant.product.mercadopago.submit');
        Route::post('/product/mercadopago/notify', [MercadopagoController::class, 'notify'])->name('tenant.product.mercadopago.notify');
        // PayUmoney
        Route::post('/product/payumoney/submit', [PayumoneyController::class, 'store'])->name('tenant.product.payumoney.submit');
        Route::post('/product/payumoney/notify', [PayumoneyController::class, 'notify'])->name('tenant.product.payumoney.notify');
        // CHECKOUT SECTION ENDS

        // client feedback route
        Route::get('/feedback', [FeedbackController::class, 'feedback'])->name('tenant.feedback');
        Route::post('/store_feedback', [FeedbackController::class, 'storeFeedback'])->name('tenant.store_feedback');
    });

    Route::group(['middleware' => ['web', 'setlang']], function () {
        Route::post('/login', [LoginController::class, 'login'])->name('tenant.user.login.submit');

        Route::get('/login/facebook', [LoginController::class, 'redirectToFacebook'])->name('tenant.front.facebook.login');
        Route::get('/login/facebook/callback', [LoginController::class, 'handleFacebookCallback'])->name('tenant.front.facebook.callback');

        Route::get('/login/google', [LoginController::class, 'redirectToGoogle'])->name('tenant.front.google.login');
        Route::get('/login/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('tenant.front.google.callback');

        Route::get('/register', [RegisterController::class, 'registerPage'])->name('tenant.user-register');
        Route::post('/register/submit', [RegisterController::class, 'register'])->name('tenant.user-register-submit');
        Route::get('/register/verify/{token}', [RegisterController::class, 'token'])->name('tenant.user-register-token');
        Route::get('/forgot', [ForgotController::class, 'showforgotform'])->name('tenant.user-forgot');
        Route::post('/forgot', [ForgotController::class, 'forgot'])->name('tenant.user-forgot-submit');

        // Course Route For Front-End
        Route::post('/course/review', [CourseController::class, 'giveReview'])->name('tenant.course.review');
    });

    /** Route For Enroll In Free Courses **/
    Route::post('/free_course/enroll', [FreeCourseEnrollController::class, 'enroll'])->name('tenant.free_course.enroll');

    Route::get('/free_course/enroll/complete', [FreeCourseEnrollController::class, 'complete'])->name('tenant.course.enroll.complete');
    /** End Of Route For Enroll In Free Courses **/

    /** Route For PayPal Payment To Sell The Courses **/
    Route::post('/course/payment/paypal', [PayPalGatewayController::class, 'redirectToPayPal'])->name('tenant.course.payment.paypal');

    Route::get('/course/payment/paypal/notify', [PayPalGatewayController::class, 'notify'])->name('tenant.course.paypal.notify');

    Route::get('/course/payment/paypal/complete', [PayPalGatewayController::class, 'complete'])->name('tenant.course.paypal.complete');

    Route::get('/course/payment/paypal/cancel', [PayPalGatewayController::class, 'cancel'])->name('tenant.course.paypal.cancel');
    /** End Of Route For PayPal Payment To Sell The Courses **/

    /** Route For Stripe Payment To Sell The Courses **/
    Route::post('/course/payment/stripe', [StripeGatewayController::class, 'redirectToStripe'])->name('tenant.course.payment.stripe');

    Route::get('/course/payment/stripe/complete', [StripeGatewayController::class, 'complete'])->name('tenant.course.stripe.complete');
    /** End Of Route For Stripe Payment To Sell The Courses **/

    /** Route For Paytm Payment To Sell The Courses **/
    Route::post('/course/payment/paytm', [PaytmGatewayController::class, 'redirectToPaytm'])->name('tenant.course.payment.paytm');

    Route::post('/course/payment/paytm/notify', [PaytmGatewayController::class, 'notify'])->name('tenant.course.paytm.notify');

    Route::get('/course/payment/paytm/complete', [PaytmGatewayController::class, 'complete'])->name('tenant.course.paytm.complete');

    Route::get('/course/payment/paytm/cancel', [PaytmGatewayController::class, 'cancel'])->name('tenant.course.paytm.cancel');
    /** End Of Route For Paytm Payment To Sell The Courses **/

    /** Route For Razorpay Payment To Sell The Courses **/
    Route::post('/course/payment/razorpay', [RazorpayGatewayController::class, 'redirectToRazorpay'])->name('tenant.course.payment.razorpay');

    Route::post('/course/payment/razorpay/notify', [RazorpayGatewayController::class, 'notify'])->name('tenant.course.razorpay.notify');

    Route::get('/course/payment/razorpay/complete', [RazorpayGatewayController::class, 'complete'])->name('tenant.course.razorpay.complete');

    Route::get('/course/payment/razorpay/cancel', [RazorpayGatewayController::class, 'cancel'])->name('tenant.course.razorpay.cancel');
    /** End Of Route For Razorpay Payment To Sell The Courses **/

    /** Route For Instamojo Payment To Sell The Courses **/
    Route::post('/course/payment/instamojo', [InstamojoGatewayController::class, 'redirectToInstamojo'])->name('tenant.course.payment.instamojo');

    Route::get('/course/payment/instamojo/notify', [InstamojoGatewayController::class, 'notify'])->name('tenant.course.instamojo.notify');

    Route::get('/course/payment/instamojo/complete', [InstamojoGatewayController::class, 'complete'])->name('tenant.course.instamojo.complete');

    Route::get('/course/payment/instamojo/cancel', [InstamojoGatewayController::class, 'cancel'])->name('tenant.course.instamojo.cancel');
    /** End Of Route For Instamojo Payment To Sell The Courses **/

    /** Route For Mollie Payment To Sell The Courses **/
    Route::post('/course/payment/mollie', [MollieGatewayController::class, 'redirectToMollie'])->name('tenant.course.payment.mollie');

    Route::get('/course/payment/mollie/notify', [MollieGatewayController::class, 'notify'])->name('tenant.course.mollie.notify');

    Route::get('/course/payment/mollie/complete', [MollieGatewayController::class, 'complete'])->name('tenant.course.mollie.complete');

    Route::get('/course/payment/mollie/cancel', [MollieGatewayController::class, 'cancel'])->name('tenant.course.mollie.cancel');
    /** End Of Route For Mollie Payment To Sell The Courses **/

    /** Route For Mollie Payment To Sell The Courses **/
    Route::post('/course/payment/payumoney', [PayuMoneyController::class, 'redirectToPayumoney'])->name('tenant.course.payment.payumoney');

    Route::post('/course/payment/payumoney/notify', [PayuMoneyController::class, 'notify'])->name('tenant.course.payumoney.notify');

    Route::get('/course/payment/payumoney/complete', [PayuMoneyController::class, 'complete'])->name('tenant.course.payumoney.complete');

    Route::get('/course/payment/payumoney/cancel', [PayuMoneyController::class, 'cancel'])->name('tenant.course.payumoney.cancel');
    /** End Of Route For Mollie Payment To Sell The Courses **/

    /** Route For Flutterwave Payment To Sell The Courses **/
    Route::post('/course/payment/flutterwave', [FlutterwaveGatewayController::class, 'redirectToFlutterwave'])->name('tenant.course.payment.flutterwave');

    Route::post('/course/payment/flutterwave/notify', [FlutterwaveGatewayController::class, 'notify'])->name('tenant.course.flutterwave.notify'); // this route have to be post method

    // in Flutterwave the complete url have to be same as the notify url, otherwise it will not work
    Route::get('/course/payment/flutterwave/notify', [FlutterwaveGatewayController::class, 'complete'])->name('tenant.course.flutterwave.complete');

    Route::get('/course/payment/flutterwave/notify_cancel', [FlutterwaveGatewayController::class, 'cancel'])->name('tenant.course.flutterwave.cancel');
    /** End Of Route For Flutterwave Payment To Sell The Courses **/

    /** Route For MercadoPago Payment To Sell The Courses **/
    Route::post('/course/payment/mercadopago', [MercadoPagoGatewayController::class, 'redirectToMercadoPago'])->name('tenant.course.payment.mercadopago');

    Route::post('/course/payment/mercadopago/notify', [MercadoPagoGatewayController::class, 'notify'])->name('tenant.course.mercadopago.notify');

    Route::get('/course/payment/mercadopago/complete', [MercadoPagoGatewayController::class, 'complete'])->name('tenant.course.mercadopago.complete');

    Route::get('/course/payment/mercadopago/cancel', [MercadoPagoGatewayController::class, 'cancel'])->name('tenant.course.mercadopago.cancel');
    /** End Of Route For MercadoPago Payment To Sell The Courses **/

    /** Route For Paystack Payment To Sell The Courses **/
    Route::post('/course/payment/paystack', [PaystackGatewayController::class, 'redirectToPaystack'])->name('tenant.course.payment.paystack');

    Route::get('/course/payment/paystack/notify', [PaystackGatewayController::class, 'notify'])->name('tenant.course.paystack.notify');

    Route::get('/course/payment/paystack/complete', [PaystackGatewayController::class, 'complete'])->name('tenant.course.paystack.complete');

    Route::get('/course/payment/paystack/cancel', [PaystackGatewayController::class, 'cancel'])->name('tenant.course.paystack.cancel');
    /** End Of Route For Paystack Payment To Sell The Courses **/

    /** Route For Offline Payment To Sell The Courses **/
    Route::post('/course/offline/{gatewayid}/submit', [OfflineController::class, 'store'])->name('tenant.course.offline.submit');
    /** End Of Route For Offline Payment To Sell The Courses **/

    Route::group(['middleware' => ['web', 'setlang']], function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('tenant.user.login');
        Route::post('/login', [LoginController::class, 'login'])->name('tenant.user.login.submit');
        Route::get('/register', [RegisterController::class, 'registerPage'])->name('tenant.user-register');
        Route::post('/register/submit', [RegisterController::class, 'register'])->name('tenant.user-register-submit');
        Route::get('/register/verify/{token}', [RegisterController::class, 'token'])->name('tenant.user-register-token');
        Route::get('/forgot', [ForgotController::class, 'showforgotform'])->name('tenant.user-forgot');
        Route::post('/forgot', [ForgotController::class, 'forgot'])->name('tenant.user-forgot-submit');
    });

    Route::group(['prefix' => 'user', 'middleware' => ['auth', 'userstatus', 'setlang']], function () {
        // Summernote image upload
        Route::post('/summernote/upload', [SummernoteController::class, 'upload'])->name('tenant.user.summernote.upload');

        Route::get('/dashboard', [UserController::class, 'index'])->name('tenant.user-dashboard');
        Route::get('/reset', [UserController::class, 'resetform'])->name('tenant.user-reset');
        Route::post('/reset', [UserController::class, 'reset'])->name('tenant.user-reset-submit');
        Route::get('/profile', [UserController::class, 'profile'])->name('tenant.user-profile');
        Route::post('/profile', [UserController::class, 'profileupdate'])->name('tenant.user-profile-update');
        Route::get('/logout', [LoginController::class, 'logout'])->name('tenant.user-logout');
        Route::get('/shipping/details', [UserController::class, 'shippingdetails'])->name('tenant.shpping-details');
        Route::post('/shipping/details/update', [UserController::class, 'shippingupdate'])->name('tenant.user-shipping-update');
        Route::get('/billing/details', [UserController::class, 'billingdetails'])->name('tenant.billing-details');
        Route::post('/billing/details/update', [UserController::class, 'billingupdate'])->name('tenant.billing-update');
        Route::get('/orders', [OrderController::class, 'index'])->name('tenant.user-orders');
        Route::get('/order/{id}', [OrderController::class, 'orderdetails'])->name('tenant.user-orders-details');
        Route::get('/events', [EventController::class, 'index'])->name('tenant.user-events');
        Route::get('/event/{id}', [EventController::class, 'eventdetails'])->name('tenant.user-event-details');
        Route::get('/donations', [DonationController::class, 'index'])->name('tenant.user-donations');
        Route::get('/course_orders', [CourseOrderController::class, 'index'])->name('tenant.user.course_orders');
        Route::get('/course/{id}/lessons', [CourseOrderController::class, 'courseLessons'])->name('tenant.user.course.lessons');
        Route::get('/tickets', [TicketController::class, 'index'])->name('tenant.user-tickets');
        Route::get('/ticket/create', [TicketController::class, 'create'])->name('tenant.user-ticket-create');
        Route::get('/ticket/messages/{id}', [TicketController::class, 'messages'])->name('tenant.user-ticket-messages');
        Route::post('/ticket/store/', [TicketController::class, 'ticketstore'])->name('tenant.user.ticket.store');
        Route::post('/ticket/reply/{id}', [TicketController::class, 'ticketreply'])->name('tenant.user.ticket.reply');
        Route::post('/zip-file/upload', [TicketController::class, 'zip_upload'])->name('tenant.zip.upload');
        Route::get('/packages', [UserController::class, 'packages'])->name('tenant.user-packages');
        Route::post('/digital/download', [OrderController::class, 'digitalDownload'])->name('tenant.user-digital-download');
        Route::get('/package/orders', [PackageController::class, 'index'])->name('tenant.user-package-orders');
        Route::get('/package/order/{id}', [PackageController::class, 'orderdetails'])->name('tenant.user-package-order-details');
    });

    Route::get('free_analysis', [FreeAnalysisController::class, 'index'])->name('tenant.free-analysis.index');
    Route::post('/analyze', [FreeAnalysisController::class, 'analyze'])->name('tenant.seo.analyze');

    // Dynamic Page Routes
    Route::group(['middleware' => 'setlang'], function () {
        Route::get('/{slug}', [FrontendController::class, 'dynamicPage'])->name('tenant.front.dynamicPage');
    });
});

Route::fallback(function () {
    return view('errors.404');
});


Route::get('/backup', [FrontendController::class, 'backup']);

// Test route for tenant URL detection
Route::get('/test-tenant/{tenant_id}', function ($tenantId) {
    $tenant = \App\Models\Tenant::find($tenantId);
    
    if (!$tenant) {
        return response()->json(['error' => 'Tenant not found'], 404);
    }
    
    // Initialize tenant context
    tenancy()->initialize($tenant);
    
    $userCount = \App\Models\User::count();
    $productCount = \App\Models\Product::count();
    
    // Get some sample data to see what's being returned
    $users = \App\Models\User::limit(3)->get(['id', 'fname', 'lname', 'email']);
    $products = \App\Models\Product::limit(3)->get(['id', 'title', 'current_price']);
    
    $response = [
        'message' => 'Tenant URL detection working!',
        'tenant_id' => $tenant->id,
        'tenant_initialized' => tenancy()->initialized,
        'user_count' => $userCount,
        'product_count' => $productCount,
        'user_table' => (new \App\Models\User)->getTable(),
        'product_table' => (new \App\Models\Product)->getTable(),
        'sample_users' => $users,
        'sample_products' => $products,
        'tenant_url' => \App\Helpers\TenantHelper::tenantUrl('front.index', [], $tenantId),
    ];
    
    // End tenant context
    tenancy()->end();
    
    return response()->json($response);
})->name('test.tenant');


/*=======================================================
******************** Front Routes **********************
=======================================================*/

Route::post('/push', [PushController::class, 'store']);

Route::group(['middleware' => ['setlang', 'forceLowercase']], function () {
    Route::get('/', [FrontendController::class, 'index'])->name('front.index');
    Route::get('/landingpage1', [FrontendController::class, 'landingpage1'])->name('front.landingpage1');
    Route::get('/landingpage2', [FrontendController::class, 'landingpage2'])->name('front.landingpage2');
    Route::get('/landingpage3', [FrontendController::class, 'landingpage3'])->name('front.landingpage3');
    Route::get('/our-profile', [FrontendController::class, 'ourProfile'])->name('front.our-profile');

    Route::group(['prefix' => 'donation'], function () {
        Route::get('/paystack/success', [Payment\causes\PaystackController::class, 'successPayment'])->name('donation.paystack.success');
    });

    //causes donation payment
    Route::post('/cause/payment', [CausesController::class, 'makePayment'])->name('front.causes.payment');
    //event tickets payment
    Route::post('/event/payment', [EventController::class, 'makePayment'])->name('front.event.payment');
    //causes donation payment via Paypal
    Route::get('/cause/paypal/payment/success', [Payment\causes\PaypalController::class, 'successPayment'])->name('donation.paypal.success');
    Route::get('/cause/paypal/payment/cancel', [Payment\causes\PaypalController::class, 'cancelPayment'])->name('donation.paypal.cancel');

    //causes donation payment via Paytm
    Route::post('/cause/paytm/payment/success', [Payment\causes\PaytmController::class, 'paymentStatus'])->name('donation.paytm.paymentStatus');

    //causes donation payment via Razorpay
    Route::post('/cause/razorpay/payment/success', [Payment\causes\RazorpayController::class, 'successPayment'])->name('donation.razorpay.success');
    Route::post('/cause/razorpay/payment/cancel', [Payment\causes\RazorpayController::class, 'cancelPayment'])->name('donation.razorpay.cancel');

    //causes donation payment via Payumoney
    Route::post('/cause/payumoney/payment', [Payment\causes\PayumoneyController::class, 'payment'])->name('donation.payumoney.payment');

    //causes donation payment via Flutterwave
    Route::post('/cause/flutterwave/success', [Payment\causes\FlutterWaveController::class, 'successPayment'])->name('donation.flutterwave.success');
    Route::post('/cause/flutterwave/cancel', [Payment\causes\FlutterWaveController::class, 'cancelPayment'])->name('donation.flutterwave.cancel');
    Route::get('/cause/flutterwave/success', [Payment\causes\FlutterWaveController::class, 'successPage'])->name('donation.flutterwave.successPage');

    //causes donation payment via Instamojo
    Route::get('/cause/instamojo/success', [Payment\causes\InstamojoController::class, 'successPayment'])->name('donation.instamojo.success');
    Route::post('/cause/instamojo/cancel', [Payment\causes\InstamojoController::class, 'cancelPayment'])->name('donation.instamojo.cancel');

    //causes donation payment via Mollie
    Route::get('/cause/mollie/success', [Payment\causes\MollieController::class, 'successPayment'])->name('donation.mollie.success');
    Route::post('/cause/mollie/cancel', [Payment\causes\MollieController::class, 'cancelPayment'])->name('donation.mollie.cancel');
    // Mercado Pago
    Route::post('/cause/mercadopago/cancel', [Payment\causes\MercadopagoController::class, 'cancelPayment'])->name('donation.mercadopago.cancel');
    Route::post('/cause/mercadopago/success', [Payment\causes\MercadopagoController::class, 'successPayment'])->name('donation.mercadopago.success');
    Route::post('/payment/instructions', [FrontendController::class, 'paymentInstruction'])->name('front.payment.instructions');


    Route::post('/sendmail', [FrontendController::class, 'sendmail'])->name('front.sendmail');
    Route::post('/subscribe', [FrontendController::class, 'subscribe'])->name('front.subscribe');
    Route::post('/blog-comment/store', [FrontendController::class, 'storeBlogComment'])->name('front.blogcomment.store');
    Route::get('/quote', [FrontendController::class, 'quote'])->name('front.quote');
    Route::post('/sendquote', [FrontendController::class, 'sendquote'])->name('front.sendquote');
    Route::get('/quote/success', [FrontendController::class, 'quoteSuccess'])->name('front.quote.success');


    Route::get('/checkout/payment/{slug1}/{slug2}', [FrontendController::class, 'loadpayment'])->name('front.load.payment');


    // Package Order Routes
    Route::post('/package-order', [FrontendController::class, 'submitorder'])->name('front.packageorder.submit');
    // Lightweight subscription request (modal) -> creates pending subscription
    Route::post('/subscription-request', [FrontendController::class, 'subscriptionRequest'])->name('front.subscription.request');
    // Load dynamic package custom inputs for modal
    Route::get('/package-inputs', [FrontendController::class, 'packageInputs'])->name('front.package.inputs');
    
    // Load dynamic quote custom inputs for modal
    Route::get('/quote-inputs', [FrontendController::class, 'quoteInputs'])->name('front.quote.inputs');
    Route::get('/order-confirmation/{packageid}/{packageOrderId}', [FrontendController::class, 'orderConfirmation'])->name('front.packageorder.confirmation');
    Route::get('/payment/{packageid}/cancle', 'Payment\PaymentController@paycancle')->name('front.payment.cancle');
    //Paypal Routes
    Route::post('/paypal/submit', 'Payment\PaypalController@store')->name('front.paypal.submit');
    Route::get('/paypal/{packageid}/notify', 'Payment\PaypalController@notify')->name('front.paypal.notify');
    //Stripe Routes
    Route::post('/stripe/submit', 'Payment\StripeController@store')->name('front.stripe.submit');
    //Paystack Routes
    Route::post('/paystack/submit', 'Payment\PaystackController@store')->name('front.paystack.submit');
    //PayTM Routes
    Route::post('/paytm/submit', 'Payment\PaytmController@store')->name('front.paytm.submit');
    Route::post('/paytm/notify', 'Payment\PaytmController@notify')->name('front.paytm.notify');
    //Flutterwave Routes
    Route::post('/flutterwave/submit', 'Payment\FlutterWaveController@store')->name('front.flutterwave.submit'); 
    Route::post('/flutterwave/notify', 'Payment\FlutterWaveController@notify')->name('front.flutterwave.notify');
    //   Route::get('/flutterwave/notify', 'Payment\FlutterWaveController@success')->name('front.flutterwave.success');
    //Instamojo Routes
    Route::post('/instamojo/submit', 'Payment\InstamojoController@store')->name('front.instamojo.submit');
    Route::get('/instamojo/notify', 'Payment\InstamojoController@notify')->name('front.instamojo.notify');
    //Mollie Routes
    Route::post('/mollie/submit', 'Payment\MollieController@store')->name('front.mollie.submit');
    Route::get('/mollie/notify', 'Payment\MollieController@notify')->name('front.mollie.notify');
    // RazorPay
    Route::post('razorpay/submit', 'Payment\RazorpayController@store')->name('front.razorpay.submit');
    Route::post('razorpay/notify', 'Payment\RazorpayController@notify')->name('front.razorpay.notify');
    // Mercado Pago
    Route::post('mercadopago/submit', 'Payment\MercadopagoController@store')->name('front.mercadopago.submit');
    Route::post('mercadopago/notify', 'Payment\MercadopagoController@notify')->name('front.mercadopago.notify');
    // Payu
    Route::post('/payumoney/submit', 'Payment\PayumoneyController@store')->name('front.payumoney.submit');
    Route::post('/payumoney/notify', 'Payment\PayumoneyController@notify')->name('front.payumoney.notify');
    //Offline Routes
    Route::post('/offline/{oid}/submit', 'Payment\OfflineController@store')->name('front.offline.submit');


    Route::get('/team', [FrontendController::class, 'team'])->name('front.team');
    Route::get('/gallery', [FrontendController::class, 'gallery'])->name('front.gallery');
    Route::get('/faq', [FrontendController::class, 'faq'])->name('front.faq');
    Route::get('/our-profile', [FrontendController::class, 'ourProfile'])->name('front.our-profile');

    // change language routes
    Route::get('/changelanguage/{lang}', [FrontendController::class, 'changeLanguage'])->name('changeLanguage');

    // Product
    Route::get('/cart', [ProductController::class, 'cart'])->name('front.cart');
    Route::post('/add-to-cart/{id}', [ProductController::class, 'addToCart'])->name('add.cart');
    Route::post('/cart/update', [ProductController::class, 'updatecart'])->name('cart.update');
    Route::get('/cart/item/remove/{id}', [ProductController::class, 'cartitemremove'])->name('cart.item.remove');
    Route::get('/checkout', [ProductController::class, 'checkout'])->name('front.checkout');
    Route::get('/checkout/{slug}', [ProductController::class, 'Prdouctcheckout'])->name('front.product.checkout');
    Route::post('/coupon', [ProductController::class, 'coupon'])->name('front.coupon');

    // review
    Route::post('product/review/submit', [ReviewController::class, 'reviewsubmit'])->name('product.review.submit');


    // CHECKOUT SECTION
    Route::get('/product/payment/return', [PaymentController::class, 'payreturn'])->name('product.payment.return');
    Route::get('/product/payment/cancle', [PaymentController::class, 'paycancle'])->name('product.payment.cancle');
    Route::get('/product/paypal/notify', [PaypalController::class, 'notify'])->name('product.paypal.notify');
    // paypal routes
    Route::post('/product/paypal/submit', [PaypalController::class, 'store'])->name('product.paypal.submit');
    // stripe routes
    Route::post('/product/stripe/submit', [StripeController::class, 'store'])->name('product.stripe.submit');
    Route::post('/product/offline/{gatewayid}/submit', [ProductOfflineController::class, 'store'])->name('product.offline.submit');
    //Flutterwave Routes
    Route::post('/product/flutterwave/submit', [FlutterWaveController::class, 'store'])->name('product.flutterwave.submit');
    Route::post('/product/flutterwave/notify', [FlutterWaveController::class, 'notify'])->name('product.flutterwave.notify');
    Route::get('/product/flutterwave/notify', [FlutterWaveController::class, 'success'])->name('product.flutterwave.success');
    //Paystack Routes
    Route::post('/product/paystack/submit', [PaystackController::class, 'store'])->name('product.paystack.submit');
    // RazorPay
    Route::post('/product/razorpay/submit', [RazorpayController::class, 'store'])->name('product.razorpay.submit');
    Route::post('/product/razorpay/notify', [RazorpayController::class, 'notify'])->name('product.razorpay.notify');
    //Instamojo Routes
    Route::post('/product/instamojo/submit', [InstamojoController::class, 'store'])->name('product.instamojo.submit');
    Route::get('/product/instamojo/notify', [InstamojoController::class, 'notify'])->name('product.instamojo.notify');
    //PayTM Routes
    Route::post('/product/paytm/submit', [PaytmController::class, 'store'])->name('product.paytm.submit');
    Route::post('/product/paytm/notify', [PaytmController::class, 'notify'])->name('product.paytm.notify');
    //Mollie Routes
    Route::post('/product/mollie/submit', [MollieController::class, 'store'])->name('product.mollie.submit');
    Route::get('/product/mollie/notify', [MollieController::class, 'notify'])->name('product.mollie.notify');
    // Mercado Pago
    Route::post('/product/mercadopago/submit', [MercadopagoController::class, 'store'])->name('product.mercadopago.submit');
    Route::post('/product/mercadopago/notify', [MercadopagoController::class, 'notify'])->name('product.mercadopago.notify');
    // PayUmoney
    Route::post('/product/payumoney/submit', [PayumoneyController::class, 'store'])->name('product.payumoney.submit');
    Route::post('/product/payumoney/notify', [PayumoneyController::class, 'notify'])->name('product.payumoney.notify');
    // CHECKOUT SECTION ENDS

    // client feedback route
    Route::get('/feedback', [FeedbackController::class, 'feedback'])->name('feedback');
    Route::post('/store_feedback', [FeedbackController::class, 'storeFeedback'])->name('store_feedback');
});

Route::group(['middleware' => ['web', 'setlang']], function () {
    Route::post('/login', [LoginController::class, 'login'])->name('user.login.submit');

    Route::get('/login/facebook', [LoginController::class, 'redirectToFacebook'])->name('front.facebook.login');
    Route::get('/login/facebook/callback', [LoginController::class, 'handleFacebookCallback'])->name('front.facebook.callback');

    Route::get('/login/google', [LoginController::class, 'redirectToGoogle'])->name('front.google.login');
    Route::get('/login/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('front.google.callback');

    Route::get('/register', [RegisterController::class, 'registerPage'])->name('user-register');
    Route::post('/register/submit', [RegisterController::class, 'register'])->name('user-register-submit');
    Route::get('/register/verify/{token}', [RegisterController::class, 'token'])->name('user-register-token');
    Route::get('/forgot', [ForgotController::class, 'showforgotform'])->name('user-forgot');
    Route::post('/forgot', [ForgotController::class, 'forgot'])->name('user-forgot-submit');

    // Course Route For Front-End
    Route::post('/course/review', [CourseController::class, 'giveReview'])->name('course.review');
});




/** Route For Enroll In Free Courses **/
Route::post('/free_course/enroll', [FreeCourseEnrollController::class, 'enroll'])->name('free_course.enroll');

Route::get('/free_course/enroll/complete', [FreeCourseEnrollController::class, 'complete'])->name('course.enroll.complete');
/** End Of Route For Enroll In Free Courses **/

/** Route For PayPal Payment To Sell The Courses **/
Route::post('/course/payment/paypal', [PayPalGatewayController::class, 'redirectToPayPal'])->name('course.payment.paypal');

Route::get('/course/payment/paypal/notify', [PayPalGatewayController::class, 'notify'])->name('course.paypal.notify');

Route::get('/course/payment/paypal/complete', [PayPalGatewayController::class, 'complete'])->name('course.paypal.complete');

Route::get('/course/payment/paypal/cancel', [PayPalGatewayController::class, 'cancel'])->name('course.paypal.cancel');
/** End Of Route For PayPal Payment To Sell The Courses **/

/** Route For Stripe Payment To Sell The Courses **/
Route::post('/course/payment/stripe', [StripeGatewayController::class, 'redirectToStripe'])->name('course.payment.stripe');

Route::get('/course/payment/stripe/complete', [StripeGatewayController::class, 'complete'])->name('course.stripe.complete');
/** End Of Route For Stripe Payment To Sell The Courses **/

/** Route For Paytm Payment To Sell The Courses **/
Route::post('/course/payment/paytm', [PaytmGatewayController::class, 'redirectToPaytm'])->name('course.payment.paytm');

Route::post('/course/payment/paytm/notify', [PaytmGatewayController::class, 'notify'])->name('course.paytm.notify');

Route::get('/course/payment/paytm/complete', [PaytmGatewayController::class, 'complete'])->name('course.paytm.complete');

Route::get('/course/payment/paytm/cancel', [PaytmGatewayController::class, 'cancel'])->name('course.paytm.cancel');
/** End Of Route For Paytm Payment To Sell The Courses **/

/** Route For Razorpay Payment To Sell The Courses **/
Route::post('/course/payment/razorpay', [RazorpayGatewayController::class, 'redirectToRazorpay'])->name('course.payment.razorpay');

Route::post('/course/payment/razorpay/notify', [RazorpayGatewayController::class, 'notify'])->name('course.razorpay.notify');

Route::get('/course/payment/razorpay/complete', [RazorpayGatewayController::class, 'complete'])->name('course.razorpay.complete');

Route::get('/course/payment/razorpay/cancel', [RazorpayGatewayController::class, 'cancel'])->name('course.razorpay.cancel');
/** End Of Route For Razorpay Payment To Sell The Courses **/

/** Route For Instamojo Payment To Sell The Courses **/
Route::post('/course/payment/instamojo', [InstamojoGatewayController::class, 'redirectToInstamojo'])->name('course.payment.instamojo');

Route::get('/course/payment/instamojo/notify', [InstamojoGatewayController::class, 'notify'])->name('course.instamojo.notify');

Route::get('/course/payment/instamojo/complete', [InstamojoGatewayController::class, 'complete'])->name('course.instamojo.complete');

Route::get('/course/payment/instamojo/cancel', [InstamojoGatewayController::class, 'cancel'])->name('course.instamojo.cancel');
/** End Of Route For Instamojo Payment To Sell The Courses **/

/** Route For Mollie Payment To Sell The Courses **/
Route::post('/course/payment/mollie', [MollieGatewayController::class, 'redirectToMollie'])->name('course.payment.mollie');

Route::get('/course/payment/mollie/notify', [MollieGatewayController::class, 'notify'])->name('course.mollie.notify');

Route::get('/course/payment/mollie/complete', [MollieGatewayController::class, 'complete'])->name('course.mollie.complete');


Route::get('/course/payment/mollie/cancel', [MollieGatewayController::class, 'cancel'])->name('course.mollie.cancel');
/** End Of Route For Mollie Payment To Sell The Courses **/


/** Route For Mollie Payment To Sell The Courses **/
Route::post('/course/payment/payumoney', [PayuMoneyController::class, 'redirectToPayumoney'])->name('course.payment.payumoney');

Route::post('/course/payment/payumoney/notify', [PayuMoneyController::class, 'notify'])->name('course.payumoney.notify');

Route::get('/course/payment/payumoney/complete', [PayuMoneyController::class, 'complete'])->name('course.payumoney.complete');


Route::get('/course/payment/payumoney/cancel', [PayuMoneyController::class, 'cancel'])->name('course.payumoney.cancel');
/** End Of Route For Mollie Payment To Sell The Courses **/


/** Route For Flutterwave Payment To Sell The Courses **/
Route::post('/course/payment/flutterwave', [FlutterwaveGatewayController::class, 'redirectToFlutterwave'])->name('course.payment.flutterwave');

Route::post('/course/payment/flutterwave/notify', [FlutterwaveGatewayController::class, 'notify'])->name('course.flutterwave.notify'); // this route have to be post method

// in Flutterwave the complete url have to be same as the notify url, otherwise it will not work
Route::get('/course/payment/flutterwave/notify', [FlutterwaveGatewayController::class, 'complete'])->name('course.flutterwave.complete');

Route::get('/course/payment/flutterwave/notify_cancel', [FlutterwaveGatewayController::class, 'cancel'])->name('course.flutterwave.cancel');
/** End Of Route For Flutterwave Payment To Sell The Courses **/

/** Route For MercadoPago Payment To Sell The Courses **/
Route::post('/course/payment/mercadopago', [MercadoPagoGatewayController::class, 'redirectToMercadoPago'])->name('course.payment.mercadopago');

Route::post('/course/payment/mercadopago/notify', [MercadoPagoGatewayController::class, 'notify'])->name('course.mercadopago.notify');

Route::get('/course/payment/mercadopago/complete', [MercadoPagoGatewayController::class, 'complete'])->name('course.mercadopago.complete');

Route::get('/course/payment/mercadopago/cancel', [MercadoPagoGatewayController::class, 'cancel'])->name('course.mercadopago.cancel');
/** End Of Route For MercadoPago Payment To Sell The Courses **/

/** Route For Paystack Payment To Sell The Courses **/
Route::post('/course/payment/paystack', [PaystackGatewayController::class, 'redirectToPaystack'])->name('course.payment.paystack');

Route::get('/course/payment/paystack/notify', [PaystackGatewayController::class, 'notify'])->name('course.paystack.notify');

Route::get('/course/payment/paystack/complete', [PaystackGatewayController::class, 'complete'])->name('course.paystack.complete');

Route::get('/course/payment/paystack/cancel', [PaystackGatewayController::class, 'cancel'])->name('course.paystack.cancel');
/** End Of Route For Paystack Payment To Sell The Courses **/

/** Route For Offline Payment To Sell The Courses **/
Route::post('/course/offline/{gatewayid}/submit', [OfflineController::class, 'store'])->name('course.offline.submit');
/** End Of Route For Offline Payment To Sell The Courses **/




Route::group(['middleware' => ['web', 'setlang']], function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('user.login');
    Route::post('/login', [LoginController::class, 'login'])->name('user.login.submit');
    Route::get('/register', [RegisterController::class, 'registerPage'])->name('user-register');
    Route::post('/register/submit', [RegisterController::class, 'register'])->name('user-register-submit');
    Route::get('/register/verify/{token}', [RegisterController::class, 'token'])->name('user-register-token');
    Route::get('/forgot', [ForgotController::class, 'showforgotform'])->name('user-forgot');
    Route::post('/forgot', [ForgotController::class, 'forgot'])->name('user-forgot-submit');
});


Route::group(['prefix' => 'user', 'middleware' => ['auth', 'userstatus', 'setlang']], function () {
    // Summernote image upload
    Route::post('/summernote/upload', [SummernoteController::class, 'upload'])->name('user.summernote.upload');

    Route::get('/dashboard', [UserController::class, 'index'])->name('user-dashboard');
    Route::get('/reset', [UserController::class, 'resetform'])->name('user-reset');
    Route::post('/reset', [UserController::class, 'reset'])->name('user-reset-submit');
    Route::get('/profile', [UserController::class, 'profile'])->name('user-profile');
    Route::post('/profile', [UserController::class, 'profileupdate'])->name('user-profile-update');
    Route::get('/logout', [LoginController::class, 'logout'])->name('user-logout');
    Route::get('/shipping/details', [UserController::class, 'shippingdetails'])->name('shpping-details');
    Route::post('/shipping/details/update', [UserController::class, 'shippingupdate'])->name('user-shipping-update');
    Route::get('/billing/details', [UserController::class, 'billingdetails'])->name('billing-details');
    Route::post('/billing/details/update', [UserController::class, 'billingupdate'])->name('billing-update');
    Route::get('/orders', [OrderController::class, 'index'])->name('user-orders');
    Route::get('/order/{id}', [OrderController::class, 'orderdetails'])->name('user-orders-details');
    Route::get('/events', [EventController::class, 'index'])->name('user-events');
    Route::get('/event/{id}', [EventController::class, 'eventdetails'])->name('user-event-details');
    Route::get('/donations', [DonationController::class, 'index'])->name('user-donations');
    Route::get('/course_orders', [CourseOrderController::class, 'index'])->name('user.course_orders');
    Route::get('/course/{id}/lessons', [CourseOrderController::class, 'courseLessons'])->name('user.course.lessons');
    Route::get('/tickets', [TicketController::class, 'index'])->name('user-tickets');
    Route::get('/ticket/create', [TicketController::class, 'create'])->name('user-ticket-create');
    Route::get('/ticket/messages/{id}', [TicketController::class, 'messages'])->name('user-ticket-messages');
    Route::post('/ticket/store/', [TicketController::class, 'ticketstore'])->name('user.ticket.store');
    Route::post('/ticket/reply/{id}', [TicketController::class, 'ticketreply'])->name('user.ticket.reply');
    Route::post('/zip-file/upload', [TicketController::class, 'zip_upload'])->name('zip.upload');
    Route::get('/packages', [UserController::class, 'packages'])->name('user-packages');
    Route::post('/digital/download', [OrderController::class, 'digitalDownload'])->name('user-digital-download');
    Route::get('/package/orders', [PackageController::class, 'index'])->name('user-package-orders');
    Route::get('/package/order/{id}', [PackageController::class, 'orderdetails'])->name('user-package-order-details');
});

Route::get('free_analysis', [FreeAnalysisController::class, 'index'])->name('free-analysis.index');
Route::post('/analyze', [FreeAnalysisController::class, 'analyze'])->name('seo.analyze');

// Dynamic Page Routes
Route::group(['middleware' => ['setlang', 'forceLowercase']], function () {
    Route::get('/{slug}', [FrontendController::class, 'dynamicPage'])->name('front.dynamicPage');
});

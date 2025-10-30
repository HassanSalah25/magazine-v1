<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\BasicExtended;
use App\Models\BasicExtended as BE;
use App\Models\BasicExtra;
use App\Models\BasicSetting;
use App\Models\BasicSetting as BS;
use App\Models\Bcategory;
use App\Models\Blog;
use App\Models\CalendarEvent;
use App\Models\Donation;
use App\Models\DonationDetail;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Faq;
use App\Models\FAQCategory;
use App\Models\Feature;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Models\Home;
use App\Models\Jcategory;
use App\Models\Job;
use App\Models\Language;
use App\Models\Member;
use App\Models\OfflineGateway;
use App\Models\Package;
use App\Models\PackageCategory;
use App\Models\PackageInput;
use App\Models\PackageOrder;
use App\Models\Page;
use App\Models\Partner;
use App\Models\PaymentGateway;
use App\Models\Pcategory;
use App\Models\Point;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\Quote;
use App\Models\QuoteInput;
use App\Models\RssFeed;
use App\Models\RssPost;
use App\Models\Scategory;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Statistic;
use App\Models\Subscriber;
use App\Models\Subscription;
use App\Models\Tag;
use App\Models\Testimonial;
use Auth;
use Illuminate\Http\Request;
use PDF;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Session;
use Validator;

class FrontendController extends Controller
{
    public function __construct()
    {
        $bs = BS::first();
        $be = BE::first();

    }

    public function index()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;

        $be = $currentLang->basic_extended;
        $bex = $currentLang->basic_extra;
        $lang_id = $currentLang->id;

        $data['sliders'] = Slider::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
        $data['features'] = Feature::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
        $version = $be->theme_version;

        // if home page page builder is disabled
        if ($bex->home_page_pagebuilder == 0) {
            $data['portfolios'] = Portfolio::where('language_id', $lang_id)->where('feature', 1)->orderBy('serial_number', 'ASC')->limit(10)->get();
            $data['points'] = Point::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
            $data['statistics'] = Statistic::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
            $data['testimonials'] = Testimonial::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
            $data['faqs'] = Faq::whereHas('faqCategory', function ($q) {
                $q->where('show_in', 1);
            })->orderBy('serial_number', 'ASC')->get();
            $data['members'] = Member::where('language_id', $lang_id)->where('feature', 1)->get();
            $data['carousel_blogs'] = Blog::where('language_id', $lang_id)->where('show_in_carousel', 1)->orderBy('carousel_order', 'ASC')->get();
            $data['featured_slider_blogs'] = Blog::where('language_id', $lang_id)->where('show_in_featured_slider', 1)->orderBy('featured_slider_order', 'ASC')->get();
            $data['hot_now_blogs'] = Blog::where('language_id', $lang_id)->where('show_in_hot_now', 1)->orderBy('hot_now_order', 'ASC')->get();
            $data['latest_blogs'] = Blog::where('language_id', $lang_id)->orderBy('id', 'DESC')->limit(10)->get();
            $data['featured_blogs'] = Blog::where('language_id', $lang_id)
                ->withCount('comments')
                ->orderBy('comments_count', 'DESC')
                ->limit(4)
                ->get();
            $data['partners'] = Partner::where('language_id', $lang_id)->active()->orderBy('serial_number', 'ASC')->get();
            $data['googleAdsPartners'] = Partner::where('language_id', $lang_id)->active()->googleAds()->orderBy('serial_number', 'ASC')->get();
            $data['packages'] = Package::where('language_id', $lang_id)->where('feature', 1)->orderBy('serial_number', 'ASC')->get();
            $data['homePackageCategories'] = PackageCategory::where('language_id', $lang_id)->where('status', 1)->where('show_in_home', 1)->orderBy('serial_number', 'ASC')->get();
            $data['bcategories'] = Bcategory::where('language_id', $lang_id)->where('status', 1)->orderBy('serial_number', 'ASC')->get();
            if (!serviceCategory()) {
                $data['services'] = Service::where('language_id', $lang_id)->where('feature', 1)->orderBy('serial_number', 'ASC')->get();
            }
        } // if home page page builder is disabled
        else {
            $data['home'] = Home::where('theme', $be->theme_version)->where('language_id', $currentLang->id)->first();
        }


        $data['fcategories'] = Pcategory::where('status', 1)->where('language_id', $currentLang->id)->where('is_feature', 1)->get();
        $data['hcategories'] = Pcategory::where('status', 1)->where('language_id', $currentLang->id)->where('products_in_home', 1)->get();
        $data['fproducts'] = Product::where('status', 1)->where('is_feature', 1)->where('language_id', $currentLang->id)->orderBy('id', 'DESC')->limit(10)->get();
        $data['products'] = Product::where('status', 1)->where('language_id', $currentLang->id)->orderBy('id', 'DESC')->limit(10)->get();
        
        // Add How We Do It section data
        $data['howWeDoItSection'] = \App\Models\HowWeDoItSection::where('language_id', $currentLang->id)->first();

        // Add dynamic sections data
        $data['dynamicSections'] = \App\Models\DynamicSection::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Add activeSub for package subscription logic
        if (Auth::check()) {
            $data['activeSub'] = Subscription::where('user_id', Auth::user()->id)->where('status', 1);
        } else {
            $data['activeSub'] = collect(); // Empty collection for non-authenticated users
        }

        if ($version == 'default' || $version == 'dark') {
            if ($bex->home_page_pagebuilder == 1) {
                return view('front.default.index', $data);
            } else {
                return view('front.default.index1', $data);
            }
        }
    }

    public function services(Request $request, $slug = null)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;


        $term = $request->term;

        if (!empty($slug)) {
            $data['category'] = Scategory::where('slug', $slug)->firstOrFail();
            $data['tags'] = Tag::where('language_id', $currentLang->id)
                ->whereHas('services', function ($query) use ($data) {
                    $serviceIds = Service::where('scategory_id', $data['category']->id)->pluck('id');
                    return $query->whereIn('service_id', $serviceIds);
                })
                ->get();

        }

        if (isset($data['category'])){
            // Load packages related to this category via morph relation
            $data['packages'] = Package::where('serviceable_type', 'App\Models\Scategory')
                ->where('serviceable_id', $data['category']->id)
                ->where('language_id', $currentLang->id)
                ->orderBy('serial_number', 'ASC')
                ->get();

            $data['services'] = Service::with('packages')->when($term, function ($query, $term) {
                return $query->where('title', 'like', '%' . $term . '%');
            })->when($currentLang, function ($query, $currentLang) {
                return $query->where('language_id', $currentLang->id);
            })->orderBy('serial_number', 'ASC');
            $data['services']->when($data, function ($query, $data) {
                return $query->where('scategory_id', $data['category']->id);
            });
            $data['services'] = $data['services']->paginate(6);
        }
        else{
            $data['scategories'] = Scategory::where('language_id', $currentLang->id)
                ->where('status', 1)
                ->orderBy('serial_number', 'ASC')
                ->get();
        }

        // Add activeSub for package subscription logic
        if (Auth::check()) {
            $data['activeSub'] = Subscription::where('user_id', Auth::user()->id)->where('status', 1);
        } else {
            $data['activeSub'] = collect(); // Empty collection for non-authenticated users
        }

        $version = $be->theme_version;

        if ($version == 'gym') {
            return view('front.gym.services', $data);
        } elseif ($version == 'car') {
            return view('front.car.services', $data);
        } elseif ($version == 'cleaning') {
            return view('front.cleaning.services', $data);
        } elseif ($version == 'construction') {
            return view('front.construction.services', $data);
        } elseif ($version == 'logistic') {
            return view('front.logistic.services', $data);
        } elseif ($version == 'lawyer') {
            return view('front.lawyer.services', $data);
        } elseif ($version == 'default' || $version == 'dark' || $version == 'ecommerce') {
            $data['version'] = $version == 'dark' ? 'default' : $version;
            return view('front.services', $data);
        }
    }

    public function tag(Request $request, $tag_slug)
    {
        $tag = Tag::where('slug', $tag_slug)->firstOrFail();
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;

        $term = $request->term;


        $data['services'] = Service::query()
            ->when($tag, function ($query) use ($tag) {
                $query->whereHas('tags', function ($q) use ($tag) {
                    $q->where('tags.id', $tag->id);
                });
            })
            ->when($term, function ($query, $term) {
                $query->where('title', 'like', '%' . $term . '%');
            })
            ->when($currentLang, function ($query) use ($currentLang) {
                $query->where('language_id', $currentLang->id);
            })
            ->orderBy('serial_number', 'ASC')
            ->paginate(6);

        $data['blogs'] = Blog::query()
            ->when($tag, function ($query) use ($tag) {
                $query->whereHas('tags', function ($q) use ($tag) {
                    $q->where('tags.id', $tag->id);
                });
            })
            ->when($term, function ($query, $term) {
                $query->where('title', 'like', '%' . $term . '%');
            })
            ->when($currentLang, function ($query) use ($currentLang) {
                $query->where('language_id', $currentLang->id);
            })
            ->orderBy('serial_number', 'ASC')
            ->paginate(6);

        $version = $be->theme_version;

        if ($version == 'gym') {
            return view('front.gym.services', $data);
        } elseif ($version == 'car') {
            return view('front.car.services', $data);
        } elseif ($version == 'cleaning') {
            return view('front.cleaning.services', $data);
        } elseif ($version == 'construction') {
            return view('front.construction.services', $data);
        } elseif ($version == 'logistic') {
            return view('front.logistic.services', $data);
        } elseif ($version == 'lawyer') {
            return view('front.lawyer.services', $data);
        } elseif ($version == 'default' || $version == 'dark' || $version == 'ecommerce') {
            $data['version'] = $version == 'dark' ? 'default' : $version;
            return view('front.tags', $data);
        }
    }

    public function scategories(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;


        $term = $request->term;


        $data['categories'] = Scategory::when($term, function ($query, $term) {
            return $query->where('title', 'like', '%' . $term . '%');
        })->when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->orderBy('serial_number', 'ASC')->paginate(6);


        $version = $be->theme_version;

        if ($version == 'gym') {
            return view('front.gym.scategories', $data);
        } elseif ($version == 'car') {
            return view('front.car.scategories', $data);
        } elseif ($version == 'cleaning') {
            return view('front.cleaning.scategories', $data);
        } elseif ($version == 'construction') {
            return view('front.construction.scategories', $data);
        } elseif ($version == 'logistic') {
            return view('front.logistic.scategories', $data);
        } elseif ($version == 'lawyer') {
            return view('front.lawyer.scategories', $data);
        } elseif ($version == 'default' || $version == 'dark' || $version == 'ecommerce') {
            $data['version'] = $version == 'dark' ? 'default' : $version;
            return view('front.scategories', $data);
        }
    }

    public function packages()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;

        $data['categories'] = PackageCategory::where('language_id', $currentLang->id)
            ->where('status', 1)
            ->where('show_in_home', 0)
            ->orderBy('serial_number', 'ASC')->get();

        // Get all packages for the current language
        $allPackages = Package::when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->orderBy('serial_number', 'ASC')->get();

        // Separate packages into three groups
        $data['homeOnlyPackages'] = collect();
        $data['scategoryPackages'] = collect();
        $data['servicePackages'] = collect();

        foreach ($allPackages as $package) {
            $packageCategory = $package->packageCategory;
            
            // Check if package has a category with show_in_home = 1
            if ($packageCategory && $packageCategory->show_in_home == 1) {
                $data['homeOnlyPackages']->push($package);
            }
            // Check if package has a serviceable relationship to Scategory
            elseif ($package->serviceable_type == 'App\Models\Scategory' && $package->serviceable_id) {
                $data['scategoryPackages']->push($package);
            }
            // Check if package has a serviceable relationship to Service
            elseif ($package->serviceable_type == 'App\Models\Service' && $package->serviceable_id) {
                $data['servicePackages']->push($package);
            }
        }

        // Keep all packages for backward compatibility
        $data['packages'] = $allPackages;

        if (Auth::check()) {
            $data['activeSub'] = Subscription::where('user_id', Auth::user()->id)->where('status', 1);
        } else {
            $data['activeSub'] = collect(); // Empty collection for non-authenticated users
        }

        $version = $be->theme_version;

        if ($version == 'gym') {
            return view('front.gym.packages', $data);
        } elseif ($version == 'car') {
            return view('front.car.packages', $data);
        } elseif ($version == 'cleaning') {
            return view('front.cleaning.packages', $data);
        } elseif ($version == 'construction') {
            return view('front.construction.packages', $data);
        } elseif ($version == 'logistic') {
            return view('front.logistic.packages', $data);
        } elseif ($version == 'lawyer') {
            return view('front.lawyer.packages', $data);
        } elseif ($version == 'default' || $version == 'dark' || $version == 'ecommerce') {
            $data['version'] = $version == 'dark' ? 'default' : $version;
            return view('front.packages', $data);
        }
    }

    public function causes(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;
        $data['bs'] = $currentLang->basic_setting;
        $bex = $currentLang->basic_extra;
        if ($bex->is_donation == 0) {
            return back();
        }
        $be = $currentLang->basic_extended;
        $causes = Donation::query()
            ->where('lang_id', $currentLang->id)
            ->orderByDesc('id')
            ->paginate(6);
        $causes->map(function ($cause) use ($bex) {
            $raised_amount = DonationDetail::query()
                ->where('donation_id', '=', $cause->id)
                ->where('status', '=', "Success")
                ->sum('amount');
            $goal_percentage = $raised_amount > 0 ? (($raised_amount / $cause->goal_amount) * 100) : 0;
            $cause['raised_amount'] = $raised_amount > 0 ? round($raised_amount, 2) : 0;
            $cause['goal_percentage'] = round($goal_percentage, 1);
        });
        $data['causes'] = $causes;
        $data['bex'] = $bex;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;
        return view('front.causes', $data);
    }

    public function causeDetails($slug)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;
        $data['bs'] = $currentLang->basic_setting;
        $bex = $currentLang->basic_extra;
        if ($bex->is_donation == 0) {
            return back();
        }
        $be = $currentLang->basic_extended;
        $version = $be->theme_version;
        $cause = Donation::where('slug', $slug)->firstOrFail();
        $raised_amount = DonationDetail::query()
            ->where('donation_id', '=', $cause->id)
            ->where('status', '=', "Success")
            ->sum('amount');
        $goal_percentage = $raised_amount > 0 ? (($raised_amount / $cause->goal_amount) * 100) : 0;
        $cause['raised_amount'] = $raised_amount > 0 ? round($raised_amount, 2) : 0;
        $cause['goal_percentage'] = round($goal_percentage, 1);
        $data['custom_amounts'] = explode(',', $cause->custom_amount);
        $online = PaymentGateway::where('status', 1)->get();
        $offline = OfflineGateway::where('donation_checkout_status', 1)->orderBy('serial_number', 'ASC')->get();
        $data['offline'] = $offline;
        $data['payment_gateways'] = $online->mergeRecursive($offline);
        $data['cause'] = $cause;
        $data['bex'] = $bex;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;
        $stripeData = PaymentGateway::whereKeyword('stripe')->first();
        $stripe = $stripeData->convertAutoData();
        $data['stripe_key'] = $stripe['key'];
        return view('front.cause-details', $data);
    }

    public function paymentInstruction(Request $request)
    {
        $offline = OfflineGateway::where('name', $request->name)->select('short_description', 'instructions', 'is_receipt')->first();
        return response()->json(['description' => $offline->short_description, 'instructions' => replaceBaseUrl($offline->instructions), 'is_receipt' => $offline->is_receipt]);
    }

    public function events(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['bex'] = $currentLang->basic_extra;
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;
        $data['bs'] = $currentLang->basic_setting;
        $data['event_categories'] = EventCategory::where('lang_id', $currentLang->id)->where('status', 1)->select('id', 'name')->get();
        $data['events'] = Event::with('eventCategories')
            ->when($request->title, function ($q) use ($request) {
                return $q->where('title', 'like', '%' . $request->title . '%');
            })->when($request->location, function ($q) use ($request) {
                return $q->where('venue_location', 'like', '%' . $request->location . '%');
            })->when($request->category, function ($q) use ($request) {
                return $q->where('cat_id', $request->category);
            })->when($request->date, function ($q) use ($request) {
                return $q->where('date', $request->date);
            })
            ->where('lang_id', $currentLang->id)
            ->orderBy('id', 'DESC')
            ->paginate(6);
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;
        return view('front.events', $data);
    }

    public function eventDetails($slug)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['bex'] = $currentLang->basic_extra;
        $data['bs'] = $currentLang->basic_setting;
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;
        $version = $be->theme_version;
        $event = Event::with('eventCategories')->where('slug', $slug)->firstOrFail();
        $data['event'] = $event;
        $online = PaymentGateway::where('status', 1)->get();
        $offline = OfflineGateway::where('event_checkout_status', 1)->orderBy('serial_number', 'ASC')->get();
        $data['offline'] = $offline;
        $data['payment_gateways'] = $online->mergeRecursive($offline);
        $data["moreEvents"] = Event::with('eventCategories')->where(function ($q) use ($event) {
            $q->where('id', '!=', $event->id)->where('cat_id', '=', $event->cat_id);
        })->where('lang_id', $currentLang->id)->take(5)->orderBy('id', 'DESC')->get();
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;
        $stripeData = PaymentGateway::whereKeyword('stripe')->first();
        $stripe = $stripeData->convertAutoData();
        $data['stripe_key'] = $stripe['key'];
        return view('front.event-details', $data);
    }

    public function portfolios(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;

        $category = $request->category;

        if (!empty($category)) {
            $data['category'] = Scategory::findOrFail($category);
        }

        $data['portfolios'] = Portfolio::when($category, function ($query, $category) {
            $serviceIdArr = [];
            $serviceids = Service::select('id')->where('scategory_id', $category)->get();
            foreach ($serviceids as $key => $serviceid) {
                $serviceIdArr[] = $serviceid->id;
            }
            return $query->whereIn('service_id', $serviceIdArr);
        })->when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->orderBy('serial_number', 'ASC');

        $version = $be->theme_version;

        if ($version == 'gym') {
            $data['portfolios'] = $data['portfolios']->paginate(9);
            return view('front.gym.portfolios', $data);
        } elseif ($version == 'car') {
            $data['portfolios'] = $data['portfolios']->paginate(9);
            return view('front.car.portfolios', $data);
        } elseif ($version == 'cleaning') {
            $data['portfolios'] = $data['portfolios']->paginate(9);
            return view('front.cleaning.portfolios', $data);
        } elseif ($version == 'construction') {
            $data['portfolios'] = $data['portfolios']->paginate(9);
            return view('front.construction.portfolios', $data);
        } elseif ($version == 'logistic') {
            $data['portfolios'] = $data['portfolios']->paginate(9);
            return view('front.logistic.portfolios', $data);
        } elseif ($version == 'lawyer') {
            $data['portfolios'] = $data['portfolios']->paginate(9);
            return view('front.lawyer.portfolios', $data);
        } elseif ($version == 'default' || $version == 'dark' || $version == 'ecommerce') {
            $data['version'] = $version == 'dark' ? 'default' : $version;
            $data['portfolios'] = $data['portfolios']->paginate(9);
            return view('front.portfolios', $data);
        }
    }

    public function portfoliodetails($slug)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['portfolio'] = Portfolio::where('slug', $slug)->firstOrFail();

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        $data['portfolio'] = Portfolio::where('slug', $slug)->firstOrFail();
        $data['navigation'] = $this->getPrevNextPortfolios($data['portfolio']);


        return view('front.portfolio-details', $data);
    }

    public function servicedetails($slug)
    {

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['service'] = Service::where('slug', $slug)->firstOrFail();

        if ($data['service']->details_page_status == 0) {
            return back();
        }

        $data['statistics'] = $data['service']->statistics()->orderBy('serial_number', 'ASC')->get();
        $data['faqs'] = $data['service']->faqs()->orderBy('serial_number', 'ASC')->get();

        $data['packages'] = Package::where('serviceable_type', 'App\Models\Service')
            ->where('serviceable_id', $data['service']->id)
            ->when($currentLang, function ($query, $currentLang) {
                return $query->where('language_id', $currentLang->id);
            })->orderBy('serial_number', 'ASC')->get();

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        $bs = $currentLang->basic_setting;

        if ($bs->is_quote == 0) {
            return view('errors.404');
        }

        $lang_id = $currentLang->id;

        $data['services'] = Service::all();
        $data['inputs'] = QuoteInput::where('language_id', $lang_id)->get();
        $data['ndaIn'] = QuoteInput::find(10);

        // Add activeSub for package subscription logic
        if (Auth::check()) {
            $data['activeSub'] = Subscription::where('user_id', Auth::user()->id)->where('status', 1);
        } else {
            $data['activeSub'] = collect(); // Empty collection for non-authenticated users
        }

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.service-details', $data);
    }

    public function careerdetails($slug)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['jcats'] = $currentLang->jcategories()->where('status', 1)->orderBy('serial_number', 'ASC')->get();

        $data['job'] = Job::where('slug', $slug)->firstOrFail();

        $data['jobscount'] = Job::when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->count();


        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;


        return view('front.career-details', $data);
    }

    public function blogs(Request $request, $category_slug = null)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;

        $lang_id = $currentLang->id;
        $be = $currentLang->basic_extended;

        $catid = null;
        if (!empty($category_slug)) {
            $data['category'] = Bcategory::where('slug', $category_slug)->firstOrFail();
            $catid = $data['category']->id;
        }
        $term = $request->term;
        $tag = $request->tag;
        $month = $request->month;
        $year = $request->year;
        $data['archives'] = Archive::orderBy('id', 'DESC')->get();
        $data['bcats'] = Bcategory::where('language_id', $lang_id)->where('status', 1)->orderBy('serial_number', 'ASC')->get();
        if (!empty($month) && !empty($year)) {
            $archive = true;
        } else {
            $archive = false;
        }

        $data['blogs'] = Blog::when($catid, function ($query, $catid) {
            return $query->where('bcategory_id', $catid);
        })
            ->when($term, function ($query, $term) {
                return $query->where('title', 'like', '%' . $term . '%');
            })
            ->when($tag, function ($query, $tag) {
                return $query->where('tags', 'like', '%' . $tag . '%');
            })
            ->when($archive, function ($query) use ($month, $year) {
                return $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
            })
            ->when($currentLang, function ($query, $currentLang) {
                return $query->where('language_id', $currentLang->id);
            })->orderBy('serial_number', 'ASC')->paginate(`6`);

        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;
        $data['recentBlogs'] = Blog::where('language_id', $lang_id)
            ->orderBy('created_at', 'DESC')
            ->take(3)
            ->get();

        $data['popularTags'] = \App\Models\Tag::select('tags.id', 'tags.title', 'tags.slug')
            ->join('blog_tags', 'tags.id', '=', 'blog_tags.tag_id')
            ->join('blogs', 'blogs.id', '=', 'blog_tags.blog_id')
            ->where('tags.language_id', $lang_id)
            ->where('tags.status', 1)
            ->where('blogs.language_id', $lang_id)
            ->groupBy('tags.id', 'tags.title', 'tags.slug')
            ->orderByRaw('COUNT(blog_tags.blog_id) DESC')
            ->limit(10)
            ->get();

        return view('front.blogs', $data);
    }

    public function blogdetails($slug)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;


        $data['blog'] = Blog::where('slug', $slug)->firstOrFail();

        if($data['blog']->redirect_url != null) {
            return redirect($data['blog']->redirect_url);
        }

        // if($data['blog']->is_indexed == 0) {
        //     return view('errors.404');
        // }

        $data['faqs'] = $data['blog']->faqs()->orderBy('serial_number', 'ASC')->get();

        $data['archives'] = Archive::orderBy('id', 'DESC')->get();
        $data['bcats'] = Bcategory::where('status', 1)->where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['recentBlogs'] = Blog::where('language_id', $lang_id)
            ->orderBy('created_at', 'DESC')
            ->take(3)
            ->get();

        $data['version'] = $version;

        return view('front.blog-details', $data);
    }

    public function storeBlogComment(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'blog_id' => 'required|exists:blogs,id',
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'comment' => 'required|string',
            'parent_id' => 'nullable|exists:blog_comments,id'
        ]);

        $blog = Blog::findOrFail($request->blog_id);

        $comment = new \App\Models\BlogComment();
        $comment->blog_id = $request->blog_id;
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->comment = $request->comment;
        $comment->parent_id = $request->parent_id ?? null;
        $comment->status = 'pending'; // Comments need approval
        $comment->save();

        session()->flash('success', __('Your comment has been submitted successfully and is pending approval.'));
        
        return redirect()->route('front.blogdetails', $blog->slug);
    }

    public function knowledgebase()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['bse'] = $currentLang->basic_extra;

        $data['article_categories'] = ArticleCategory::where('language_id', $currentLang->id)
            ->where('status', 1)
            ->orderBy('serial_number', 'ASC')
            ->get();

        $data['currentLang'] = $currentLang;

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.articles', $data);
    }

    public function knowledgebase_details($slug)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['bse'] = $currentLang->basic_extra;

        $data['article_categories'] = ArticleCategory::where('language_id', $currentLang->id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();

        $data['details'] = Article::where('language_id', $currentLang->id)
            ->where('slug', $slug)
            ->firstOrFail();

        $data['currentLang'] = $currentLang;

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.article_details', $data);
    }

    public function rss(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;
        $id = $request->id;
        $data['categories'] = RssFeed::where('language_id', $lang_id)->orderBy('id', 'desc')->get();
        $data['rss_posts'] = RssPost::where('language_id', $lang_id)
            ->when($id, function ($query, $id) {
                return $query->where('rss_feed_id', $id);
            })->orderBy('id', 'desc')->paginate(4);

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;
        if ($version == 'dark') {
            $version = 'default';
        }
        $data['version'] = $version;

        return view('front.rss', $data);
    }

    public function rssdetails($slug, $id)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;
        $data['categories'] = RssFeed::where('language_id', $lang_id)->orderBy('id', 'desc')->get();
        $data['post'] = RssPost::findOrFail($id);

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.rss-details', $data);
    }

    public function contact()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        $data['langg'] = Language::where('code', session('lang'))->first();

        return view('front.contact', $data);
    }

    public function sendmail(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $bs = $currentLang->basic_setting;

        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ];
        if ($bs->is_recaptcha == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $request->validate($rules, $messages);

        $request->validate($rules, $messages);

        $be = BE::firstOrFail();
        $from = $request->email;
        $to = $be->to_mail;
        $subject = $request->subject;
        $message = $request->message;

        try {

            $mail = new PHPMailer(true);
            $mail->setFrom($from, $request->name);
            $mail->addAddress($to);     // Add a recipient

            // Content
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
        } catch (\Exception $e) {
            // die($e->getMessage());
        }

        Session::flash('success', 'Email sent successfully!');
        return back();
    }

    public function subscribe(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:subscribers'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $subsc = new Subscriber;
        $subsc->email = $request->email;
        $subsc->save();

        return "success";
    }

    public function quote()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;

        if ($bs->is_quote == 0) {
            return view('errors.404');
        }

        $lang_id = $currentLang->id;

        $data['services'] = Service::all();
        $data['inputs'] = QuoteInput::where('language_id', $lang_id)->get();
        $data['ndaIn'] = QuoteInput::find(10);

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.quote', $data);
    }

    public function sendquote(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;
        $quote_inputs = $currentLang->quote_inputs;

        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];

        // Initialize validation rules array
        $rules = [];
        
        // Add basic validation for name and email if not authenticated
        if (!Auth::check()) {
            $rules['name'] = 'string|max:255';
            $rules['email'] = 'email|max:255';
        }
        
        $allowedExts = array('pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'zip', 'rar');
        
        // Build dynamic validation rules for form builder inputs
        foreach ($quote_inputs as $input) {

            $fieldRules = [];
            
            // Add required validation if field is marked as required
            if ($input->required == 1) {
                $fieldRules[] = 'required';
            } else {
                $fieldRules[] = 'nullable';
            }
            
            // Add type-specific validation based on input type
            switch ($input->type) {
                case 1: // Text input
                    $fieldRules[] = 'string';
                    $fieldRules[] = 'max:255';
                    break;
                    
                case 2: // Select dropdown
                    $fieldRules[] = 'string';
                    $fieldRules[] = 'max:255';
                    
                    // Add validation for select options
                    $options = $input->quote_input_options->pluck('name')->toArray();
                    if (!empty($options)) {
                        $fieldRules[] = 'in:' . implode(',', $options);
                    }
                    break;
                    
                case 3: // Checkbox
                    $fieldRules[] = 'array';
                    $fieldRules[] = 'max:10'; // Limit number of checkboxes
                    $fieldRules[] = function ($attribute, $value, $fail) use ($input) {
                        if (is_array($value)) {
                            $options = $input->quote_input_options->pluck('name')->toArray();
                            foreach ($value as $selectedValue) {
                                if (!in_array($selectedValue, $options)) {
                                    return $fail("Invalid option selected for {$input->label}");
                                }
                            }
                        }
                    };
                    break;
                    
                case 4: // Textarea
                    $fieldRules[] = 'string';
                    $fieldRules[] = 'max:2000'; // Longer limit for textarea
                    break;
                    
                case 5: // File upload
                    $fieldRules[] = 'file';
                    $fieldRules[] = 'max:10240'; // 10MB max file size
                    $fieldRules[] = 'mimes:pdf,doc,docx,jpg,jpeg,png,zip,rar';
                    break;
                    
                case 6: // Date picker
                    $fieldRules[] = 'date';
                    $fieldRules[] = 'after_or_equal:today'; // Prevent past dates
                    break;
                    
                case 7: // Time picker
                    $fieldRules[] = 'date_format:H:i'; // HH:MM format
                    break;
                    
                default:
                    $fieldRules[] = 'string';
                    $fieldRules[] = 'max:255';
                    break;
            }
            
            // Add custom validation messages
            $messages["{$input->name}.required"] = "The {$input->label} field is required.";
            $messages["{$input->name}.string"] = "The {$input->label} must be a string.";
            $messages["{$input->name}.max"] = "The {$input->name} may not be greater than :max characters.";
            $messages["{$input->name}.email"] = "The {$input->name} must be a valid email address.";
            $messages["{$input->name}.file"] = "The {$input->name} must be a file.";
            $messages["{$input->name}.mimes"] = "The {$input->name} must be a file of type: :values.";
            $messages["{$input->name}.date"] = "The {$input->name} must be a valid date.";
            $messages["{$input->name}.date_format"] = "The {$input->name} must match the format HH:MM.";
            $messages["{$input->name}.after_or_equal"] = "The {$input->name} must be today or a future date.";
            $messages["{$input->name}.array"] = "The {$input->name} must be an array.";
            $messages["{$input->name}.in"] = "The selected {$input->name} is invalid.";
            
            // Assign rules to the field
            $rules[$input->name] = $fieldRules;
        }

        if ($bs->is_recaptcha == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        \Log::info('Quote form submission', [
            'request_data' => $request->all(),
            'rules' => $rules,
            'quote_inputs_count' => $quote_inputs->count(),
            'user_authenticated' => Auth::check()
        ]);

        try {
            session(['quoteKey' => 'quote_' . uniqid() . '_' . time()]);
            $request->validate($rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Quote form validation failed', [
                'errors' => $e->errors(),
                'input_data' => $request->all()
            ]);
            
            // Handle AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            
            throw $e;
        }

        $fields = [];
        foreach ($quote_inputs as $key => $input) {
            $in_name = $input->name;
            
            // Handle different input types
            if ($input->type == 5) {
                // File input - move to 'files' folder
                if ($request->hasFile("$in_name")) {
                    $file = $request->file("$in_name");
                    $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $directory = 'assets/front/files/';
                    @mkdir($directory, 0775, true);
                    
                    // Get file properties before moving
                    $fileSize = $file->getSize();
                    $originalName = $file->getClientOriginalName();
                    
                    $file->move($directory, $fileName);

                    $fields["$in_name"]['value'] = $fileName;
                    $fields["$in_name"]['type'] = $input->type;
                    $fields["$in_name"]['original_name'] = $originalName;
                    $fields["$in_name"]['size'] = $fileSize;
                }
            } elseif ($input->type == 3) {
                // Checkbox input - handle array values
                if ($request->has("$in_name") && is_array($request["$in_name"])) {
                    $fields["$in_name"]['value'] = implode(', ', array_filter($request["$in_name"]));
                    $fields["$in_name"]['type'] = $input->type;
                }
            } else {
                // Text, select, textarea, date, time inputs
                if ($request->has("$in_name") && $request["$in_name"] != '') {
                    $value = $request["$in_name"];
                    
                    // Sanitize input based on type
                    if ($input->type == 1 || $input->type == 2) {
                        $value = strip_tags(trim($value));
                    } elseif ($input->type == 4) {
                        $value = strip_tags(trim($value));
                    } elseif ($input->type == 6) {
                        // Ensure date format is consistent
                        $value = date('Y-m-d', strtotime($value));
                    } elseif ($input->type == 7) {
                        // Ensure time format is consistent
                        $value = date('H:i', strtotime($value));
                    }
                    
                    $fields["$in_name"]['value'] = $value;
                    $fields["$in_name"]['type'] = $input->type;
                }
            }
        }
        $jsonfields = json_encode($fields);
        $jsonfields = str_replace("\/", "/", $jsonfields);


        $quote = new Quote;
        $quote->name = Auth::check() ? Auth::user()->name : $request->name ?? 'Guest';
        $quote->email = Auth::check() ? Auth::user()->email : $request->email ?? 'Guest';
        $quote->fields = $jsonfields;

        $quote->save();


        // send mail to Admin
        $from = $request->email;
        $to = $be->to_mail;
        $subject = "Quote Request Received";

        $fields = json_decode($quote->fields, true);

        try {
            $mail = new PHPMailer(true);
            $mail->setFrom($from, $request->name);
            $mail->addAddress($to);     // Add a recipient

            // Content
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = $subject;
            
            // Build email body
            $emailBody = '<h3>New Quote Request Received</h3>';
            $emailBody .= '<p><strong>Client Name:</strong> ' . $request->name . '</p>';
            $emailBody .= '<p><strong>Client Email:</strong> ' . $request->email . '</p>';
            
            if ($fields) {
                $emailBody .= '<h4>Additional Information:</h4>';
                foreach ($fields as $key => $field) {
                    if ($field['value']) {
                        // Get the label from QuoteInput model
                        $quoteInput = $quote_inputs->where('name', $key)->first();
                        $label = $quoteInput ? $quoteInput->label : ucwords(str_replace('_', ' ', $key));
                        
                        // Handle different field types in email
                        if ($field['type'] == 5 && isset($field['original_name'])) {
                            // File upload
                            $fileSize = isset($field['size']) ? round($field['size'] / 1024, 2) . ' KB' : 'Unknown size';
                            $emailBody .= '<p><strong>' . $label . ':</strong> ' . $field['original_name'] . ' (' . $fileSize . ')</p>';
                        } else {
                            // Regular field
                            $emailBody .= '<p><strong>' . $label . ':</strong> ' . htmlspecialchars($field['value']) . '</p>';
                        }
                    }
                }
            }
            
            $mail->Body = $emailBody;
            $mail->send();
        } catch (\Exception $e) {
            // die($e->getMessage());
        }

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Quote request sent successfully! We\'ll get back to you soon.'
            ]);
        }

        Session::flash('success', 'Quote request sent successfully');
        return redirect()->route('front.quote.success');
    }

    public function quoteSuccess()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        return view('front.quote.success', compact('version'));
    }

    public function team()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['members'] = Member::when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->get();

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'gym') {
            return view('front.gym.team', $data);
        } elseif ($version == 'car') {
            return view('front.car.team', $data);
        } elseif ($version == 'cleaning') {
            return view('front.cleaning.team', $data);
        } elseif ($version == 'construction') {
            return view('front.construction.team', $data);
        } elseif ($version == 'logistic') {
            return view('front.logistic.team', $data);
        } elseif ($version == 'lawyer') {
            return view('front.lawyer.team', $data);
        } elseif ($version == 'default' || $version == 'dark' || $version == 'ecommerce') {
            $data['version'] = $version == 'dark' ? 'default' : $version;
            return view('front.team', $data);
        }
    }

    public function career(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['jcats'] = $currentLang->jcategories()->where('status', 1)->orderBy('serial_number', 'ASC')->get();


        $category = $request->category;
        $term = $request->term;

        if (!empty($category)) {
            $data['category'] = Jcategory::findOrFail($category);
        }

        $data['jobs'] = Job::when($category, function ($query, $category) {
            return $query->where('jcategory_id', $category);
        })->when($term, function ($query, $term) {
            return $query->where('title', 'like', '%' . $term . '%');
        })->when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->orderBy('serial_number', 'ASC')->paginate(4);

        $data['jobscount'] = Job::when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->count();

        $data['benefits'] = Point::where('page_id', Point::CAREER)
            ->where('language_id', $currentLang->id)
            ->get();

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.career', $data);
    }

    public function calendar()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $events = CalendarEvent::where('language_id', $lang_id)->get();
        $formattedEvents = [];

        foreach ($events as $key => $event) {
            $formattedEvents["$key"]['title'] = $event->title;

            $startDate = strtotime($event->start_date);
            $formattedEvents["$key"]['start'] = date('Y-m-d H:i', $startDate);

            $endDate = strtotime($event->end_date);
            $formattedEvents["$key"]['end'] = date('Y-m-d H:i', $endDate);
        }

        $data["formattedEvents"] = $formattedEvents;

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.calendar', $data);
    }

    public function gallery()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $data['categories'] = GalleryCategory::where('language_id', $lang_id)->where('status', 1)
            ->orderBy('serial_number', 'ASC')->get();

        $data['galleries'] = Gallery::with('galleryImgCategory')->where('language_id', $lang_id)
            ->orderBy('serial_number', 'ASC')->get();

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.gallery', $data);
    }

    public function faq()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $data['categories'] = FAQCategory::where('language_id', $lang_id)->where('status', 1)
            ->orderBy('serial_number', 'ASC')->get();

        $data['faqs'] = Faq::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.faq', $data);
    }

    public function ourstory()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $data['faqs'] = Faq::whereHas('faqCategory', function ($q) {
            $q->where('show_in', 2);
        })->orderBy('serial_number', 'ASC')->get();

        $data['testimonials'] = Testimonial::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();


        $data['statistics'] = Statistic::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();

        $data['points'] = Point::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();

        $data['members'] = Member::where('language_id', $lang_id)->where('feature', 1)->get();

        $data['portfolios'] = Portfolio::where('language_id', $lang_id)->where('feature', 1)->orderBy('serial_number', 'ASC')->limit(10)->get();

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.ourstory', $data);
    }

    public function dynamicPage($slug)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['page'] = Page::where('slug', $slug)->firstOrFail();

        $be = $currentLang->basic_extended;
        $bex = $currentLang->basic_extra;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        if ($bex->custom_page_pagebuilder == 1) {
            return view('front.dynamic', $data);
        } else {
            return view('front.dynamic1', $data);
        }
    }

    public function changeLanguage($lang)
    {
        session()->put('lang', $lang);
        app()->setLocale($lang);

        $be = be::first();
        $version = $be->theme_version;

        return redirect()->route('front.index');
    }

    public function packageorder(Request $request, $id)
    {
        $bex = BasicExtra::first();

        if ($bex->package_guest_checkout == 1 && $request->type != 'guest' && !Auth::check()) {
            Session::put('link', route('front.packageorder.index', $id));
            return redirect(route('user.login', ['redirected' => 'package-checkout']));
        } elseif ($bex->package_guest_checkout == 0 && !Auth::check()) {
            Session::put('link', route('front.packageorder.index', $id));
            return redirect(route('user.login'));
        }
        if ($bex->recurring_billing == 1) {
            $sub = Subscription::select('next_package_id', 'pending_package_id')->where('user_id', Auth::user()->id)->first();

            if (!empty($sub->next_package_id)) {
                Session::flash('error', 'You already have a package to activate in stock.');
                return back();
            }
            if (!empty($sub->pending_package_id)) {
                Session::flash('error', 'You already have a pending subscription request.');
                return back();
            }
        }

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $data['package'] = Package::findOrFail($id);

        if ($data['package']->order_status == 0) {
            return view('errors.404');
        }

        $data['inputs'] = PackageInput::where('language_id', $lang_id)->get();
        $data['gateways'] = PaymentGateway::whereStatus(1)->whereType('automatic')->get();
        $data['ogateways'] = OfflineGateway::wherePackageOrderStatus(1)->orderBy('serial_number', 'ASC')->get();
        $paystackData = PaymentGateway::whereKeyword('paystack')->first();
        $data['paystack'] = $paystackData->convertAutoData();
        $stripeData = PaymentGateway::whereKeyword('stripe')->first();
        $stripe = $stripeData->convertAutoData();
        $data['stripe_key'] = $stripe['key'];

        $be = be::first();
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.package-order', $data);
    }

    public function submitorder(Request $request)
    {

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;
        $package_inputs = $currentLang->package_inputs;

        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'package_id' => 'required'
        ];

        $allowedExts = array('zip');
        foreach ($package_inputs as $input) {
            if ($input->required == 1) {
                $rules["$input->name"][] = 'required';
            }
            // check if input type is 5, then check for zip extension
            if ($input->type == 5) {
                $rules["$input->name"][] = function ($attribute, $value, $fail) use ($request, $input, $allowedExts) {
                    if ($request->hasFile("$input->name")) {
                        $ext = $request->file("$input->name")->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only zip file is allowed");
                        }
                    }
                };
            }
        }

        if ($bs->is_recaptcha == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $request->validate($rules, $messages);

        $fields = [];
        foreach ($package_inputs as $key => $input) {
            $in_name = $input->name;
            // if the input is file, then move it to 'files' folder
            if ($input->type == 5) {
                if ($request->hasFile("$in_name")) {
                    $fileName = uniqid() . '.' . $request->file("$in_name")->getClientOriginalExtension();
                    $directory = 'assets/front/files/';
                    @mkdir($directory, 0775, true);
                    $request->file("$in_name")->move($directory, $fileName);

                    $fields["$in_name"]['value'] = $fileName;
                    $fields["$in_name"]['type'] = $input->type;
                }
            } else {
                if ($request["$in_name"]) {
                    $fields["$in_name"]['value'] = $request["$in_name"];
                    $fields["$in_name"]['type'] = $input->type;
                }
            }
        }
        $jsonfields = json_encode($fields);
        $jsonfields = str_replace("\/", "/", $jsonfields);

        $package = Package::findOrFail($request->package_id);

        $in = $request->all();
        $in['name'] = $request->name;
        $in['email'] = $request->email;
        $in['fields'] = $jsonfields;

        $in['package_title'] = $package->title;
        $in['package_currency'] = $package->currency;
        $in['package_price'] = $package->price;
        $in['package_description'] = $package->description;
        $fileName = \Str::random(4) . time() . '.pdf';
        $in['invoice'] = $fileName;
        $po = PackageOrder::create($in);


        // saving order number
        $po->order_number = $po->id + 1000000000;
        $po->save();


        // sending datas to view to make invoice PDF
        $fields = json_decode($po->fields, true);
        $data['packageOrder'] = $po;
        $data['fields'] = $fields;


        // generate pdf from view using dynamic datas
        PDF::loadView('pdf.package', $data)->save('assets/front/invoices/' . $fileName);


        // Send Mail to Buyer
        $mail = new PHPMailer(true);

        if ($be->is_smtp == 1) {
            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host = $be->smtp_host;                    // Set the SMTP server to send through
                $mail->SMTPAuth = true;                                   // Enable SMTP authentication
                $mail->Username = $be->smtp_username;                     // SMTP username
                $mail->Password = $be->smtp_password;                               // SMTP password
                $mail->SMTPSecure = $be->encryption;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port = $be->smtp_port;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);
                $mail->addAddress($request->email, $request->name);     // Add a recipient

                // Attachments
                $mail->addAttachment('assets/front/invoices/' . $fileName);         // Add attachments

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = "Order placed for " . $package->title;
                $mail->Body = 'Hello <strong>' . $request->name . '</strong>,<br/>Your order has been placed successfully. We have attached an invoice in this mail.<br/>Thank you.';

                $mail->send();
            } catch (Exception $e) {
                // die($e->getMessage());
            }
        } else {
            try {

                //Recipients
                $mail->setFrom($be->from_mail, $be->from_name);
                $mail->addAddress($request->email, $request->name);     // Add a recipient

                // Attachments
                $mail->addAttachment('assets/front/invoices/' . $fileName);         // Add attachments

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = "Order placed for " . $package->title;
                $mail->Body = 'Hello <strong>' . $request->name . '</strong>,<br/>Your order has been placed successfully. We have attached an invoice in this mail.<br/>Thank you.';

                $mail->send();
            } catch (Exception $e) {
                // die($e->getMessage());
            }
        }

        // send mail to Admin
        try {

            $mail = new PHPMailer(true);
            $mail->setFrom($po->email, $po->name);
            $mail->addAddress($be->from_mail);     // Add a recipient

            // Attachments
            $mail->addAttachment('assets/front/invoices/' . $fileName);         // Add attachments

            // Content
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = "Order placed for " . $package->title;
            $mail->Body = 'A new order has been placed.<br/><strong>Order Number: </strong>' . $po->order_number;

            $mail->send();
        } catch (\Exception $e) {
            // die($e->getMessage());
        }

        Session::flash('success', 'Order placed successfully!');
        return redirect()->route('front.packageorder.confirmation', [$package->id, $po->id]);
    }


    public function orderConfirmation($packageid, $packageOrderId)
    {
        $data['package'] = Package::findOrFail($packageid);
        $bex = BasicExtra::first();
        if ($bex->recurring_billing == 1) {
            $packageOrder = Subscription::find($packageOrderId);
        } else {
            $packageOrder = PackageOrder::find($packageOrderId);
        }

        $data['packageOrder'] = $packageOrder;
        $data['fields'] = json_decode($packageOrder->fields, true);

        $be = be::first();
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        if ($bex->recurring_billing == 1) {
            return view('front.subscription-confirmation', $data);
        } else {
            return view('front.order-confirmation', $data);
        }
    }

    public function loadpayment($slug, $id)
    {
        $data['payment'] = $slug;
        $data['pay_id'] = $id;
        $gateway = '';
        if ($data['pay_id'] != 0 && $data['payment'] != "offline") {
            $gateway = PaymentGateway::findOrFail($data['pay_id']);
        } else {
            $gateway = OfflineGateway::findOrFail($data['pay_id']);
        }
        $data['gateway'] = $gateway;

        return view('front.load.payment', $data);
    }    // Redirect To Checkout Page If Payment is Cancelled


    // Redirect To Success Page If Payment is Comleted

    public function payreturn($packageid)
    {
        return redirect()->route('front.packageorder.index', $packageid)->with('success', __('Pament Compelted!'));
    }



    // Lightweight subscription request from global modal (creates pending request)
    public function subscriptionRequest(Request $request)
    {
        // Determine language for dynamic inputs
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $package_inputs = PackageInput::where('language_id', $currentLang->id)->get();

        // Build validation rules
        $rules = [
            'package_id' => 'required|integer|exists:packages,id',
        ];

        // Build custom validation messages
        $messages = [
            'package_id.required' => __('Package selection is required.'),
            'package_id.integer' => __('Invalid package selection.'),
            'package_id.exists' => __('Selected package does not exist.'),
        ];

        $allowedExts = array('zip');
        foreach ($package_inputs as $input) {
            $fieldRules = [];
            $fieldLabel = convertUtf8($input->label);
            
            if ($input->required == 1) {
                $fieldRules[] = 'required';
                $messages[$input->name . '.required'] = $fieldLabel . ' ' . __('is required.');
            }
            
            // Add specific validation rules based on input type
            switch ($input->type) {
                case 1: // Text input
                    $fieldRules[] = 'string|max:255';
                    $messages[$input->name . '.string'] = $fieldLabel . ' ' . __('must be a valid text.');
                    $messages[$input->name . '.max'] = $fieldLabel . ' ' . __('may not be greater than 255 characters.');
                    break;
                    
                case 2: // Select input
                    $fieldRules[] = 'string';
                    $messages[$input->name . '.string'] = $fieldLabel . ' ' . __('must be a valid selection.');
                    break;
                    
                case 3: // Checkbox input
                    $fieldRules[] = 'array';
                    $messages[$input->name . '.array'] = $fieldLabel . ' ' . __('must be a valid selection.');
                    break;
                    
                case 4: // Textarea input
                    $fieldRules[] = 'string|max:1000';
                    $messages[$input->name . '.string'] = $fieldLabel . ' ' . __('must be a valid text.');
                    $messages[$input->name . '.max'] = $fieldLabel . ' ' . __('may not be greater than 1000 characters.');
                    break;
                    
                case 5: // File input
                    $fieldRules[] = 'file';
                    $fieldRules[] = 'mimes:zip';
                    $fieldRules[] = 'max:10240'; // 10MB max
                    $messages[$input->name . '.file'] = $fieldLabel . ' ' . __('must be a file.');
                    $messages[$input->name . '.mimes'] = $fieldLabel . ' ' . __('must be a zip file.');
                    $messages[$input->name . '.max'] = $fieldLabel . ' ' . __('may not be greater than 10MB.');
                    break;
                    
                case 6: // Date input
                    $fieldRules[] = 'date';
                    $messages[$input->name . '.date'] = $fieldLabel . ' ' . __('must be a valid date.');
                    break;
                    
                case 7: // Time input
                    $fieldRules[] = 'string';
                    $messages[$input->name . '.string'] = $fieldLabel . ' ' . __('must be a valid time.');
                    break;
            }
            
            if (!empty($fieldRules)) {
                $rules[$input->name] = implode('|', $fieldRules);
            }
        }

        // Validate the request and handle errors
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            \Log::info('Validation failed', [
                'errors' => $validator->errors()->toArray(),
                'package_id' => $request->package_id,
                'rules' => $rules
            ]);
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('package_id', $request->package_id);
        }

        // Build fields JSON from dynamic inputs
        $fields = [];
        foreach ($package_inputs as $key => $input) {
            $in_name = $input->name;
            if ($input->type == 5) {
                if ($request->hasFile("$in_name")) {
                    $fileName = uniqid() . '.' . $request->file("$in_name")->getClientOriginalExtension();
                    $directory = 'assets/front/files/';
                    @mkdir($directory, 0775, true);
                    $request->file("$in_name")->move($directory, $fileName);

                    $fields["$in_name"]['value'] = $fileName;
                    $fields["$in_name"]['type'] = $input->type;
                }
            } else {
                if ($request["$in_name"]) {
                    $fields["$in_name"]['value'] = $request["$in_name"];
                    $fields["$in_name"]['type'] = $input->type;
                }
            }
        }
        if ($request->filled('notes')) {
            $fields['notes'] = ['value' => $request->input('notes'), 'type' => 4];
        }
        $jsonfields = json_encode($fields);
        $jsonfields = str_replace('\/', '/', $jsonfields);

        $package = Package::findOrFail($request->package_id);

        // Create or reuse user's subscription record
        $sub = Subscription::where('user_id', Auth::check() ? Auth::user()->id : null)->first();
        if (!$sub) {
            $sub = new Subscription();
        }

        $resolvedName = $request->input('name');
        $resolvedEmail = $request->input('email');
        if (Auth::check()) {
            $resolvedName = $resolvedName ?: trim((Auth::user()->fname ?? '') . ' ' . (Auth::user()->lname ?? ''));
            $resolvedEmail = $resolvedEmail ?: Auth::user()->email;
        }
        $sub->name = $resolvedName ?: 'Guest';
        $sub->email = $resolvedEmail;
        $sub->user_id = Auth::check() ? Auth::user()->id : NULL;
        $sub->fields = $jsonfields;
        $sub->gateway_type = 'offline';
        $sub->pending_payment_method = 'manual';
        $sub->pending_package_id = $package->id;
        $sub->save();

        Session::flash('success', __('Subscription request submitted successfully!'));
        return redirect()->route('front.packageorder.confirmation', [$package->id, $sub->id]);
    }

    // Return dynamic package inputs HTML for a given package & language
    public function packageInputs(Request $request)
    {
        $request->validate([
            'package_id' => 'required|integer|exists:packages,id'
        ]);

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $lang_id = $currentLang->id;

        $inputs = PackageInput::where('language_id', $lang_id)->get();

        \Log::info('Package inputs loaded', [
            'package_id' => $request->package_id,
            'lang_id' => $lang_id,
            'inputs_count' => $inputs->count()
        ]);

        return view('front.partials.package-inputs', [ 'inputs' => $inputs ])->render();
    }

    // Return dynamic quote inputs HTML for the current language
    public function quoteInputs(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $lang_id = $currentLang->id;

        $inputs = QuoteInput::where('language_id', $lang_id)->get();

        \Log::info('Quote inputs loaded', [
            'lang_id' => $lang_id,
            'inputs_count' => $inputs->count()
        ]);

        return view('front.partials.quote-inputs', [ 'inputs' => $inputs ])->render();
    }

    protected function getPrevNextPortfolios($currentPortfolio)
    {
        $prev = Portfolio::where('language_id', $currentPortfolio->language_id)
            ->where('serial_number', '<', $currentPortfolio->serial_number)
            ->orderBy('serial_number', 'DESC')
            ->first();

        $next = Portfolio::where('language_id', $currentPortfolio->language_id)
            ->where('serial_number', '>', $currentPortfolio->serial_number)
            ->orderBy('serial_number', 'ASC')
            ->first();

        return [
            'prev' => $prev,
            'next' => $next
        ];
    }

    public function ourProfile()
    {
        $filePath = public_path('assets/lfm/files/Company Profile SEO Wolves.pdf');
       
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }
        
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Company Profile SEO Wolves.pdf"',
            'Cache-Control' => 'public, max-age=3600'
        ]);
    }
}

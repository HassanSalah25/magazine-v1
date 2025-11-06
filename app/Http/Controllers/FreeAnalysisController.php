<?php

namespace App\Http\Controllers;

use Http;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\BasicExtended;

class FreeAnalysisController extends Controller
{
    public function index()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bex = $currentLang->basic_extended;
        
        return view('front.default.free_analysis', compact('bex'));
    }
    
    public function analyze(Request $request)
    {
        $request->validate([
            'website' => 'required|url'
        ]);

        try {
            $client = HttpClient::create(['timeout' => 30]);
            $response = $client->request('GET', $request->website);
            $html = $response->getContent();
            $crawler = new Crawler($html);
        } catch (\Exception $e) {
            return back()->withErrors(['website' => 'لا يمكن الوصول إلى الموقع. تأكد من صحة الرابط وأن الموقع متاح.']);
        }

        // Basic SEO Elements
        $title = $crawler->filter('title')->count() ? $crawler->filter('title')->text() : null;
        $titleLength = strlen($title ?? '');

        $metaDescription = $crawler->filterXPath('//meta[@name="description"]')->count()
            ? $crawler->filterXPath('//meta[@name="description"]')->attr('content')
            : null;
        $metaDescriptionLength = strlen($metaDescription ?? '');

        $metaKeywords = $crawler->filterXPath('//meta[@name="keywords"]')->count()
            ? $crawler->filterXPath('//meta[@name="keywords"]')->attr('content')
            : null;

        $robotsMeta = $crawler->filterXPath('//meta[@name="robots"]')->count()
            ? $crawler->filterXPath('//meta[@name="robots"]')->attr('content')
            : null;

        $canonical = $crawler->filterXPath('//link[@rel="canonical"]')->count()
            ? $crawler->filterXPath('//link[@rel="canonical"]')->attr('href')
            : null;

        $language = $crawler->filterXPath('//html')->count()
            ? $crawler->filterXPath('//html')->attr('lang')
            : null;

        // Headings Analysis
        $h1Tags = $crawler->filter('h1')->each(fn($node) => $node->text());
        $h2Tags = $crawler->filter('h2')->each(fn($node) => $node->text());
        $h3Tags = $crawler->filter('h3')->each(fn($node) => $node->text());
        $h4Tags = $crawler->filter('h4')->each(fn($node) => $node->text());
        $h5Tags = $crawler->filter('h5')->each(fn($node) => $node->text());
        $h6Tags = $crawler->filter('h6')->each(fn($node) => $node->text());

        // Enhanced Link Analysis
        $host = parse_url($request->website, PHP_URL_HOST);
        $baseUrl = parse_url($request->website, PHP_URL_SCHEME) . '://' . $host;

        $allLinks = $crawler->filter('a[href]')->each(function ($node) use ($host, $baseUrl) {
            $href = $node->attr('href');
            $text = trim($node->text());
            $rel = $node->attr('rel');
            $isDofollow = !str_contains($rel ?? '', 'nofollow');
            
            // Determine link type
            $linkType = 'external';
            $linkHost = null;
            
            if (str_starts_with($href, '/')) {
                $linkType = 'internal';
                $fullUrl = $baseUrl . $href;
            } elseif (str_starts_with($href, 'http')) {
                $linkHost = parse_url($href, PHP_URL_HOST);
                $linkType = ($linkHost === $host) ? 'internal' : 'external';
                $fullUrl = $href;
            } else {
                $linkType = 'internal';
                $fullUrl = $baseUrl . '/' . ltrim($href, '/');
            }

            return [
                'url' => $href,
                'full_url' => $fullUrl ?? $href,
                'text' => $text,
                'type' => $linkType,
                'dofollow' => $isDofollow,
                'rel' => $rel
            ];
        });

        $internalLinks = array_filter($allLinks, fn($link) => $link['type'] === 'internal');
        $externalLinks = array_filter($allLinks, fn($link) => $link['type'] === 'external');
        $dofollowLinks = array_filter($allLinks, fn($link) => $link['dofollow']);
        $nofollowLinks = array_filter($allLinks, fn($link) => !$link['dofollow']);

        // Broken Link Detection (sample check)
        $brokenLinks = [];
        $workingLinks = [];
        
        // Check first 10 external links for demonstration
        $sampleLinks = array_slice($externalLinks, 0, 10);
        foreach ($sampleLinks as $link) {
            try {
                $linkResponse = $client->request('HEAD', $link['full_url'], ['timeout' => 5]);
                if ($linkResponse->getStatusCode() >= 400) {
                    $brokenLinks[] = $link;
                } else {
                    $workingLinks[] = $link;
                }
            } catch (\Exception $e) {
                $brokenLinks[] = $link;
            }
        }

        // Enhanced Image Analysis
        $images = $crawler->filter('img')->each(function ($node) {
            $src = $node->attr('src');
            $alt = $node->attr('alt');
            $title = $node->attr('title');
            $width = $node->attr('width');
            $height = $node->attr('height');
            
            return [
                'src' => $src,
                'alt' => $alt,
                'title' => $title,
                'width' => $width,
                'height' => $height,
                'has_alt' => !empty($alt),
                'has_title' => !empty($title),
                'has_dimensions' => !empty($width) && !empty($height)
            ];
        });

        $imageCount = count($images);
        $imagesWithAlt = count(array_filter($images, fn($img) => $img['has_alt']));
        $imagesWithTitle = count(array_filter($images, fn($img) => $img['has_title']));
        $imagesWithDimensions = count(array_filter($images, fn($img) => $img['has_dimensions']));

        // Social Media Meta Tags
        $ogTitle = $crawler->filterXPath('//meta[@property="og:title"]')->count()
            ? $crawler->filterXPath('//meta[@property="og:title"]')->attr('content')
            : null;
        $ogDescription = $crawler->filterXPath('//meta[@property="og:description"]')->count()
            ? $crawler->filterXPath('//meta[@property="og:description"]')->attr('content')
            : null;
        $ogImage = $crawler->filterXPath('//meta[@property="og:image"]')->count()
            ? $crawler->filterXPath('//meta[@property="og:image"]')->attr('content')
            : null;
        $twitterCard = $crawler->filterXPath('//meta[@name="twitter:card"]')->count()
            ? $crawler->filterXPath('//meta[@name="twitter:card"]')->attr('content')
            : null;

        // Content Analysis
        $textContent = strip_tags($html);
        $wordCount = str_word_count($textContent);
        $characterCount = strlen($textContent);
        
        // Check for favicon
        $hasFavicon = $crawler->filterXPath('//link[contains(@rel, "icon")]')->count() > 0;

        // SEO Score Calculation
        $seoScore = $this->calculateSeoScore([
            'title' => $title,
            'titleLength' => $titleLength,
            'metaDescription' => $metaDescription,
            'metaDescriptionLength' => $metaDescriptionLength,
            'h1Count' => count($h1Tags),
            'imageCount' => $imageCount,
            'imagesWithAlt' => $imagesWithAlt,
            'wordCount' => $wordCount,
            'hasFavicon' => $hasFavicon,
            'canonical' => $canonical,
            'language' => $language
        ]);

        // PageSpeed Analysis
        $apiKey = config('services.google_pagespeed.key');
        $url = $request->website;

        if ($apiKey) {
            $apiUrl = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url={$url}&key={$apiKey}&strategy=mobile";

            try {
                $response = Http::timeout(30)->get($apiUrl);

                if ($response->successful()) {
                    $pageSpeed = $response->json();

                    $performanceScore = $pageSpeed['lighthouseResult']['categories']['performance']['score'] * 100;
                    $fcp = $pageSpeed['lighthouseResult']['audits']['first-contentful-paint']['displayValue'];
                    $lcp = $pageSpeed['lighthouseResult']['audits']['largest-contentful-paint']['displayValue'];
                    $cls = $pageSpeed['lighthouseResult']['audits']['cumulative-layout-shift']['displayValue'];
                    $blockingTime = $pageSpeed['lighthouseResult']['audits']['total-blocking-time']['displayValue'];
                } else {
                    $performanceScore = $fcp = $lcp = $cls = $blockingTime = 'Unavailable';
                }
            } catch (\Exception $e) {
                $performanceScore = $fcp = $lcp = $cls = $blockingTime = 'Unavailable';
            }
        } else {
            $performanceScore = $fcp = $lcp = $cls = $blockingTime = 'API Key Required';
        }

        // Get language and basic extended data for the view
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bex = $currentLang->basic_extended;

        return view('front.seo_report', compact(
            'title',
            'titleLength',
            'metaDescription',
            'metaDescriptionLength',
            'metaKeywords',
            'robotsMeta',
            'canonical',
            'language',
            'h1Tags',
            'h2Tags',
            'h3Tags',
            'h4Tags',
            'h5Tags',
            'h6Tags',
            'internalLinks',
            'externalLinks',
            'dofollowLinks',
            'nofollowLinks',
            'brokenLinks',
            'workingLinks',
            'images',
            'imageCount',
            'imagesWithAlt',
            'imagesWithTitle',
            'imagesWithDimensions',
            'ogTitle',
            'ogDescription',
            'ogImage',
            'twitterCard',
            'hasFavicon',
            'wordCount',
            'characterCount',
            'seoScore',
            'performanceScore',
            'fcp',
            'lcp',
            'cls',
            'blockingTime',
            'bex'
        ));
    }

    private function calculateSeoScore($data)
    {
        $score = 0;
        $maxScore = 100;

        // Title (15 points)
        if (!empty($data['title'])) {
            $score += 10;
            if ($data['titleLength'] >= 10 && $data['titleLength'] <= 70) {
                $score += 5;
            }
        }

        // Meta Description (15 points)
        if (!empty($data['metaDescription'])) {
            $score += 10;
            if ($data['metaDescriptionLength'] >= 100 && $data['metaDescriptionLength'] <= 300) {
                $score += 5;
            }
        }

        // H1 Tags (10 points)
        if ($data['h1Count'] == 1) {
            $score += 10;
        } elseif ($data['h1Count'] > 1) {
            $score += 5; // Multiple H1s are not ideal
        }

        // Images with Alt Text (10 points)
        if ($data['imageCount'] > 0) {
            $altPercentage = ($data['imagesWithAlt'] / $data['imageCount']) * 100;
            $score += ($altPercentage / 10);
        }

        // Content Length (10 points)
        if ($data['wordCount'] >= 300) {
            $score += 10;
        } elseif ($data['wordCount'] >= 150) {
            $score += 5;
        }

        // Favicon (5 points)
        if ($data['hasFavicon']) {
            $score += 5;
        }

        // Canonical URL (5 points)
        if (!empty($data['canonical'])) {
            $score += 5;
        }

        // Language Declaration (5 points)
        if (!empty($data['language'])) {
            $score += 5;
        }

        // Additional points for good practices
        if ($data['wordCount'] >= 500) $score += 5;
        if ($data['wordCount'] >= 1000) $score += 5;

        return min($score, $maxScore);
    }
}

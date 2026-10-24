{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">

    {{-- Homepage --}}
    <url>
        <loc>{{ url('/bn') }}</loc>
        <xhtml:link rel="alternate" hreflang="bn" href="{{ url('/bn') }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en') }}"/>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    {{-- Jobs --}}
    <url>
        <loc>{{ url('/bn/jobs') }}</loc>
        <xhtml:link rel="alternate" hreflang="bn" href="{{ url('/bn/jobs') }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en/jobs') }}"/>
        <changefreq>hourly</changefreq>
        <priority>0.9</priority>
    </url>

    @foreach($jobs as $job)
    <url>
        <loc>{{ url('/bn/jobs/' . $job->slug) }}</loc>
        <xhtml:link rel="alternate" hreflang="bn" href="{{ url('/bn/jobs/' . $job->slug) }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en/jobs/' . $job->slug) }}"/>
        <lastmod>{{ $job->updated_at->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    {{-- Articles --}}
    <url>
        <loc>{{ url('/bn/news') }}</loc>
        <xhtml:link rel="alternate" hreflang="bn" href="{{ url('/bn/news') }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en/news') }}"/>
        <changefreq>hourly</changefreq>
        <priority>0.9</priority>
    </url>

    @foreach($articles as $article)
    <url>
        <loc>{{ url('/bn/news/' . $article->slug) }}</loc>
        <xhtml:link rel="alternate" hreflang="bn" href="{{ url('/bn/news/' . $article->slug) }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en/news/' . $article->slug) }}"/>
        <lastmod>{{ $article->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach

    {{-- Categories --}}
    @foreach($categories as $category)
    <url>
        <loc>{{ url('/bn/news/category/' . $category->slug) }}</loc>
        <xhtml:link rel="alternate" hreflang="bn" href="{{ url('/bn/news/category/' . $category->slug) }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en/news/category/' . $category->slug) }}"/>
        @if($category->updated_at)
        <lastmod>{{ $category->updated_at->toAtomString() }}</lastmod>
        @endif
        <changefreq>daily</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    {{-- Tools Portal --}}
    <url>
        <loc>{{ url('/bn/tools') }}</loc>
        <xhtml:link rel="alternate" hreflang="bn" href="{{ url('/bn/tools') }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en/tools') }}"/>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    {{-- Individual Tools --}}
    @foreach($tools as $tool)
    <url>
        <loc>{{ url('/bn/tools/' . $tool) }}</loc>
        <xhtml:link rel="alternate" hreflang="bn" href="{{ url('/bn/tools/' . $tool) }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en/tools/' . $tool) }}"/>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    {{-- URL Shortener --}}
    <url>
        <loc>{{ url('/shorten') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>

    {{-- Citizen Services & Examination Results Hub --}}
    <url>
        <loc>{{ url('/bn/services') }}</loc>
        <xhtml:link rel="alternate" hreflang="bn" href="{{ url('/bn/services') }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en/services') }}"/>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url('/bn/services/passport-guide') }}</loc>
        <xhtml:link rel="alternate" hreflang="bn" href="{{ url('/bn/services/passport-guide') }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en/services/passport-guide') }}"/>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url('/bn/services/nid-guide') }}</loc>
        <xhtml:link rel="alternate" hreflang="bn" href="{{ url('/bn/services/nid-guide') }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en/services/nid-guide') }}"/>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url('/bn/services/exam-results') }}</loc>
        <xhtml:link rel="alternate" hreflang="bn" href="{{ url('/bn/services/exam-results') }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en/services/exam-results') }}"/>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url('/bn/services/applications-gd') }}</loc>
        <xhtml:link rel="alternate" hreflang="bn" href="{{ url('/bn/services/applications-gd') }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en/services/applications-gd') }}"/>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    {{-- Company & Legal Pages --}}
    <url>
        <loc>{{ url('/bn/about') }}</loc>
        <xhtml:link rel="alternate" hreflang="bn" href="{{ url('/bn/about') }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en/about') }}"/>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>{{ url('/bn/contact') }}</loc>
        <xhtml:link rel="alternate" hreflang="bn" href="{{ url('/bn/contact') }}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en/contact') }}"/>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>{{ url('/privacy-policy') }}</loc>
        <changefreq>yearly</changefreq>
        <priority>0.3</priority>
    </url>
    <url>
        <loc>{{ url('/terms-of-use') }}</loc>
        <changefreq>yearly</changefreq>
        <priority>0.3</priority>
    </url>

</urlset>

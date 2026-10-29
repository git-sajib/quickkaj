<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $jobs = Job::published()->select('slug', 'updated_at')->orderByDesc('updated_at')->get();
        $articles = Article::published()->select('slug', 'updated_at')->orderByDesc('updated_at')->get();
        $categories = Category::select('slug', 'updated_at')->orderBy('order')->get();

        $tools = [
            'word-counter',
            'case-converter',
            'json-formatter',
            'url-encoder',
            'qr-generator',
            'password-generator',
            'image-compressor',
            'image-resizer',
            'image-converter',
            'background-remover',
            'age-calculator',
            'bmi-calculator',
            'cgpa-calculator',
            'salary-calculator',
            'unit-converter',
            'cv-builder',
            'pdf-tools',
            'teletalk-sms',
        ];

        $xml = view('sitemap', compact('jobs', 'articles', 'categories', 'tools'))->render();

        return response($xml, 200)->header('Content-Type', 'text/xml; charset=utf-8');
    }

    public function robots(): Response
    {
        $content = view('robots')->render();

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}

<?php

namespace App\Http\Controllers;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ToolController extends Controller
{
    public function index(): View
    {
        return view('tools.index');
    }

    public function wordCounter(): View
    {
        return view('tools.word-counter');
    }

    public function caseConverter(): View
    {
        return view('tools.case-converter');
    }

    public function jsonFormatter(): View
    {
        return view('tools.json-formatter');
    }

    public function urlEncoder(): View
    {
        return view('tools.url-encoder');
    }

    public function qrGenerator(): View
    {
        return view('tools.qr-generator');
    }

    public function passwordGenerator(): View
    {
        return view('tools.password-generator');
    }

    // ── Image Tools (browser-side Canvas API — no server upload) ─────────

    public function imageCompressor(): View
    {
        return view('tools.image-compressor');
    }

    public function imageResizer(): View
    {
        return view('tools.image-resizer');
    }

    public function imageConverter(): View
    {
        return view('tools.image-converter');
    }

    public function backgroundRemover(): View
    {
        return view('tools.background-remover');
    }

    // ── Bangladesh Calculators (pure browser JS) ─────────────────────────

    public function ageCalculator(): View
    {
        return view('tools.age-calculator');
    }

    public function bmiCalculator(): View
    {
        return view('tools.bmi-calculator');
    }

    public function cgpaCalculator(): View
    {
        return view('tools.cgpa-calculator');
    }

    public function salaryCalculator(): View
    {
        return view('tools.salary-calculator');
    }

    public function unitConverter(): View
    {
        return view('tools.unit-converter');
    }

    // ── CV Builder (browser print-to-PDF) ────────────────────────────────

    public function cvBuilder(): View
    {
        return view('tools.cv-builder');
    }

    public function pdfTools(): View
    {
        return view('tools.pdf-tools');
    }

    public function teletalkSms(): View
    {
        return view('tools.teletalk-sms');
    }

    public function generateQr(Request $request): Response|JsonResponse
    {
        $validated = $request->validate([
            'text' => 'required|string|max:2000',
            'size' => 'nullable|integer|min:100|max:600',
        ]);

        $size = $validated['size'] ?? 300;

        $result = Builder::create()
            ->writer(new PngWriter)
            ->writerOptions([])
            ->data($validated['text'])
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size($size)
            ->margin(10)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->build();

        return response($result->getString(), 200)
            ->header('Content-Type', 'image/png')
            ->header('Cache-Control', 'public, max-age=600');
    }
}

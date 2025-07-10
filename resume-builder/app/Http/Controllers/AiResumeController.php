<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Smalot\PdfParser\Parser; // Import the Parser class
use App\Services\AiResumeAnalysisService; // Import the AI Service
use Illuminate\Support\Facades\Log; // For logging

class AiResumeController extends Controller
{
    protected $aiService;

    public function __construct(AiResumeAnalysisService $aiService)
    {
        $this->aiService = $aiService;
    }
    /**
     * Display the PDF upload form.
     */
    public function showUploadForm()
    {
        return view('ai.upload_resume_form');
    }

    /**
     * Handle the PDF upload, parse it, and then (for now) display extracted text.
     */
    public function parseResume(Request $request)
    {
        $request->validate([
            'resume_pdf' => 'required|file|mimes:pdf|max:5120', // Max 5MB PDF
        ]);

        if ($request->file('resume_pdf')->isValid()) {
            try {
                $pdfFile = $request->file('resume_pdf');

                // Initialize the PDF parser
                $parser = new Parser();
                $pdf = $parser->parseFile($pdfFile->getPathname());

                // Extract text from all pages
                $extractedText = $pdf->getText();

                // Get details of the PDF (optional)
                // $details = $pdf->getDetails();
                // Example: Title
                // $title = $details['Title'] ?? 'N/A';

                // Extract text from all pages
                $extractedText = $pdf->getText();

                // Now, use the AI service to get structured data (currently placeholder)
                $structuredData = $this->aiService->extractStructuredData($extractedText);

                if (isset($structuredData['error'])) {
                    Log::error('AI Data Extraction Error: ' . $structuredData['error'], ['details' => $structuredData['details'] ?? '']);
                    return back()->with('error', 'AI could not extract data: ' . $structuredData['error'])->withInput();
                }

                // Store structured data in session to pass to the resume form
                session(['ai_prefill_data' => $structuredData]);
                session(['original_extracted_text' => $extractedText]); // Keep original text for reference if needed

                return redirect()->route('ai.confirmPrefill');

            } catch (\Exception $e) {
                Log::error('PDF Parsing or AI Initial Processing Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
                return back()->with('error', 'Error processing PDF: ' . $e->getMessage())->withInput();
            }
        }

        return back()->with('error', 'Invalid PDF file.')->withInput();
    }

    /**
     * Show a confirmation page allowing user to see AI extracted data
     * and choose to use it to prefill the resume form.
     */
    public function showConfirmPrefill()
    {
        $structuredData = session('ai_prefill_data');
        $originalText = session('original_extracted_text');

        if (!$structuredData) {
            return redirect()->route('ai.uploadForm')->with('error', 'No AI processed data found. Please upload again.');
        }

        // For simplicity, we'll just pass the structured data to a view.
        // This view would ideally show a summary and allow user to proceed.
        return view('ai.confirm_prefill', compact('structuredData', 'originalText'));
    }

    /**
     * Provides AI suggestions for a professional summary.
     */
    public function suggestSummary(Request $request)
    {
        $request->validate([
            'current_summary' => 'nullable|string|max:5000',
            'work_experiences' => 'nullable|array', // Could pass existing work experiences as context
            // Potentially add other context fields: 'name', 'key_skills' from form
        ]);

        // Gather context for the AI
        $context = [
            'current_summary' => $request->input('current_summary'),
            'work_experiences' => $request->input('work_experiences', []), // Example: pass titles and companies
            // 'key_skills' => $request->input('key_skills', []),
        ];

        // Remove empty values from context to keep prompt clean
        $context = array_filter($context);


        // Call the AI service (currently placeholder)
        $suggestedSummary = $this->aiService->generateProfessionalSummary($context);

        if (isset($suggestedSummary['error'])) {
            return response()->json(['error' => $suggestedSummary['error']], 400);
        }

        return response()->json(['suggestion' => $suggestedSummary]);
    }

    /**
     * Provides AI suggestions for work experience bullet points.
     */
    public function suggestExperienceBullets(Request $request)
    {
        $request->validate([
            'job_title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'current_responsibilities' => 'nullable|string|max:5000',
        ]);

        // Gather context for the AI
        $jobDetails = [
            'job_title' => $request->input('job_title'),
            'company' => $request->input('company'),
            'current_responsibilities' => $request->input('current_responsibilities'),
        ];

        $jobDetails = array_filter($jobDetails);

        // Call the AI service (currently placeholder)
        $suggestedBullets = $this->aiService->generateBulletPoints($jobDetails);

        if (isset($suggestedBullets['error'])) {
            return response()->json(['error' => $suggestedBullets['error']], 400);
        }
        // The service returns an array of strings, join them for textarea
        return response()->json(['suggestion' => implode("\n- ", $suggestedBullets)]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CareerApplication;
use App\Models\JobOpening;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class JobController extends Controller
{
    /**
     * Get all active job openings
     */
    public function index(): JsonResponse
    {
        $jobOpenings = JobOpening::where('active', true)
            ->select(['id', 'designation', 'location', 'content', 'sequence'])
            ->orderBy('sequence')
            ->get();

        return response()->json($jobOpenings);
    }

    /**
     * Store a new career application
     */
    public function storeApplication(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'job_opening_id' => 'required|exists:job_openings,id',
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'location' => 'required|string|max:255',
                'experience' => 'required|string|max:255',
                'qualifications' => 'required|string|max:500',
                'message' => 'nullable|string|max:2000',
                'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // 5MB max
            ]);

            $careerApplication = CareerApplication::create($validated);

            // Handle resume upload
            if ($request->hasFile('resume')) {
                $careerApplication->addMediaFromRequest('resume')->toMediaCollection('resume');
            }

            // Load the job opening for response
            $jobOpening = JobOpening::find($validated['job_opening_id']);

            return response()->json([
                'message' => 'Career application submitted successfully',
                'application' => [
                    'name' => $careerApplication->name,
                    'email' => $careerApplication->email,
                    'phone' => $careerApplication->phone,
                    'location' => $careerApplication->location,
                    'experience' => $careerApplication->experience,
                    'qualifications' => $careerApplication->qualifications,
                    'message' => $careerApplication->message,
                    'job_opening_designation' => $jobOpening->designation,
                    'submitted_at' => $careerApplication->created_at
                ]
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while submitting the career application'
            ], 500);
        }
    }
}

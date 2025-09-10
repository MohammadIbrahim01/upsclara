<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PageController extends Controller
{
    /**
     * Get all active pages
     */
    public function index(Request $request): JsonResponse
    {
        $query = Page::where('active', true)
            ->orderBy('sequence', 'asc')
            ->orderBy('created_at', 'desc');

        // Filter by group if provided
        if ($request->has('group') && $request->group) {
            $query->where('group', $request->group);
        }

        $pages = $query->get()->makeHidden(['id']);

        return response()->json($pages);
    }

    /**
     * Get a specific page by slug
     */
    public function show(string $slug): JsonResponse
    {
        $page = Page::where('slug', $slug)
            ->where('active', true)
            ->first();

        if (!$page) {
            return response()->json([
                'message' => 'Page not found'
            ], 404);
        }

        // Transform page data
        $pageData = $page->makeHidden(['id', 'media']);

        // Add media URLs if the page has media
        if ($page->hasMedia()) {
            $pageData->media_urls = $page->getMedia()->map(function($media) {
                return [
                    'name' => $media->name,
                    'file_name' => $media->file_name,
                    'mime_type' => $media->mime_type,
                    'size' => $media->size,
                    'url' => $media->getUrl(),
                    'thumb_url' => $media->getUrl('thumb'),
                    'preview_url' => $media->getUrl('preview'),
                ];
            });
        }

        $page->unsetRelation('media');

        return response()->json($pageData);
    }

    /**
     * Get pages grouped by group
     */
    public function groups(): JsonResponse
    {
        $pages = Page::where('active', true)
            ->orderBy('sequence', 'asc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('group')
            ->map(function($groupPages) {
                return $groupPages->makeHidden(['id']);
            });

        return response()->json($pages);
    }

    /**
     * Get available page groups
     */
    public function availableGroups(): JsonResponse
    {
        $groups = Page::where('active', true)
            ->distinct()
            ->pluck('group')
            ->filter()
            ->values();

        return response()->json($groups);
    }
}

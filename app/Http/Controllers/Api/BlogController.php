<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\JsonResponse;

class BlogController extends Controller
{
    /**
     * Get all blog categories with blogs
     */
    public function categories(): JsonResponse
    {
        $blogCategories = BlogCategory::where('active', true)
            ->with([
                'blogs' => function ($query) {
                    $query->where('active', true)
                        ->orderBy('publish_date', 'desc')
                        ->select(['id', 'title', 'slug', 'heading', 'short_description', 'featured_image_caption', 'type', 'publish_date']);
                }
            ])
            ->orderBy('sequence')
            ->select(['id', 'name', 'slug', 'sequence'])
            ->get();

        // Transform categories and blogs
        $blogCategories->transform(function ($category) {
            $category->makeHidden(['id']);
            $category->blogs->transform(function ($blog) {
                $blog->makeHidden(['id', 'media', 'featured_image']);
                $blog->featured_image_url = $this->getBlogImageUrl($blog);
                $blog->unsetRelation('media');
                return $blog;
            });
            return $category;
        });

        return response()->json($blogCategories);
    }

    /**
     * Get single blog category by slug with blogs
     */
    public function categoryBySlug(string $slug): JsonResponse
    {
        $blogCategory = BlogCategory::where('slug', $slug)
            ->where('active', true)
            ->with([
                'blogs' => function ($query) {
                    $query->where('active', true)
                        ->orderBy('publish_date', 'desc')
                        ->select(['id', 'title', 'slug', 'heading', 'short_description', 'featured_image_caption', 'type', 'publish_date']);
                }
            ])
            ->select(['id', 'name', 'slug', 'sequence'])
            ->first();

        if (!$blogCategory) {
            return response()->json([
                'message' => 'Blog category not found'
            ], 404);
        }

        // Transform category and blogs
        $blogCategory->makeHidden(['id']);
        $blogCategory->blogs->transform(function ($blog) {
            $blog->makeHidden(['id', 'media', 'featured_image']);
            $blog->featured_image_url = $this->getBlogImageUrl($blog);
            $blog->unsetRelation('media');
            return $blog;
        });

        return response()->json($blogCategory);
    }

    /**
     * Get single blog by slug
     */
    public function show(string $slug): JsonResponse
    {
        $blog = Blog::where('slug', $slug)
            ->where('active', true)
            ->with([
                'blog_categories' => function ($query) {
                    $query->select(['id', 'name', 'slug']);
                }
            ])
            ->select(['id', 'title', 'slug', 'heading', 'short_description', 'content', 'featured_image_caption', 'type', 'publish_date'])
            ->first();

        if (!$blog) {
            return response()->json([
                'message' => 'Blog not found'
            ], 404);
        }

        // Get related blogs that share any of the same categories
        $categoryIds = $blog->blog_categories->pluck('id')->toArray();

        $relatedBlogs = collect();
        if (!empty($categoryIds)) {
            $relatedBlogs = Blog::where('active', true)
                ->where('id', '!=', $blog->id) // Exclude current blog
                ->whereHas('blog_categories', function ($query) use ($categoryIds) {
                    $query->whereIn('blog_categories.id', $categoryIds);
                })
                ->select(['id', 'title', 'slug', 'short_description', 'publish_date'])
                ->orderBy('publish_date', 'desc')
                ->limit(4)
                ->get();

            // Transform related blogs
            $relatedBlogs->transform(function ($relatedBlog) {
                $relatedBlog->makeHidden(['id', 'media', 'featured_image']);
                $relatedBlog->featured_image_url = $this->getBlogImageUrl($relatedBlog);
                $relatedBlog->unsetRelation('media');
                return $relatedBlog;
            });
        }

        // Transform main blog
        $blog->makeHidden(['id', 'media', 'featured_image']);
        $blog->featured_image_url = $this->getBlogImageUrl($blog);
        $blog->blog_categories->makeHidden(['id']);
        $blog->unsetRelation('media');

        // Add related blogs to response
        $blog->related_blogs = $relatedBlogs;

        return response()->json($blog);
    }

    /**
     * Get all blogs with pagination
     */
    public function index(): JsonResponse
    {
        $blogs = Blog::where('active', true)
            ->with([
                'blog_categories' => function ($query) {
                    $query->select(['id', 'name', 'slug']);
                }
            ])
            ->select(['id', 'title', 'slug', 'heading', 'short_description', 'featured_image_caption', 'type', 'publish_date'])
            ->orderBy('publish_date', 'desc')
            ->get();

        // Transform blogs
        $blogs->transform(function ($blog) {
            $blog->makeHidden(['id', 'media', 'featured_image']);
            $blog->featured_image_url = $this->getBlogImageUrl($blog);
            $blog->blog_categories->makeHidden(['id']);
            $blog->unsetRelation('media');
            return $blog;
        });

        return response()->json($blogs);
    }

    /**
     * Get featured image URL for blog
     */
    private function getBlogImageUrl($blog): ?string
    {
        $media = $blog->getFirstMedia('featured_image');
        return $media ? $media->getUrl() : null;
    }
}

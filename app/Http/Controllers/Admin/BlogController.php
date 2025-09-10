<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBlogRequest;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('blog_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Blog::with(['blog_categories'])->select(sprintf('%s.*', (new Blog)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'blog_show';
                $editGate      = 'blog_edit';
                $deleteGate    = 'blog_delete';
                $crudRoutePart = 'blogs';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('slug', function ($row) {
                return $row->slug ? $row->slug : '';
            });
            $table->editColumn('heading', function ($row) {
                return $row->heading ? $row->heading : '';
            });
            $table->editColumn('short_description', function ($row) {
                return $row->short_description ? $row->short_description : '';
            });
            $table->editColumn('featured_image', function ($row) {
                if ($photo = $row->featured_image) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('featured_image_caption', function ($row) {
                return $row->featured_image_caption ? $row->featured_image_caption : '';
            });
            $table->editColumn('type', function ($row) {
                return $row->type ? Blog::TYPE_RADIO[$row->type] : '';
            });

            $table->editColumn('blog_category', function ($row) {
                $labels = [];
                foreach ($row->blog_categories as $blog_category) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $blog_category->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('active', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->active ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'featured_image', 'blog_category', 'active']);

            return $table->make(true);
        }

        $blog_categories = BlogCategory::get();

        return view('admin.blogs.index', compact('blog_categories'));
    }

    public function create()
    {
        abort_if(Gate::denies('blog_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $blog_categories = BlogCategory::pluck('name', 'id');

        return view('admin.blogs.create', compact('blog_categories'));
    }

    public function store(StoreBlogRequest $request)
    {
        $blog = Blog::create($request->all());
        $blog->blog_categories()->sync($request->input('blog_categories', []));
        if ($request->input('featured_image', false)) {
            $blog->addMedia(storage_path('tmp/uploads/' . basename($request->input('featured_image'))))->toMediaCollection('featured_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $blog->id]);
        }

        return redirect()->route('admin.blogs.index');
    }

    public function edit(Blog $blog)
    {
        abort_if(Gate::denies('blog_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $blog_categories = BlogCategory::pluck('name', 'id');

        $blog->load('blog_categories');

        return view('admin.blogs.edit', compact('blog', 'blog_categories'));
    }

    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $blog->update($request->all());
        $blog->blog_categories()->sync($request->input('blog_categories', []));
        if ($request->input('featured_image', false)) {
            if (! $blog->featured_image || $request->input('featured_image') !== $blog->featured_image->file_name) {
                if ($blog->featured_image) {
                    $blog->featured_image->delete();
                }
                $blog->addMedia(storage_path('tmp/uploads/' . basename($request->input('featured_image'))))->toMediaCollection('featured_image');
            }
        } elseif ($blog->featured_image) {
            $blog->featured_image->delete();
        }

        return redirect()->route('admin.blogs.index');
    }

    public function show(Blog $blog)
    {
        abort_if(Gate::denies('blog_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $blog->load('blog_categories');

        return view('admin.blogs.show', compact('blog'));
    }

    public function destroy(Blog $blog)
    {
        abort_if(Gate::denies('blog_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $blog->delete();

        return back();
    }

    public function massDestroy(MassDestroyBlogRequest $request)
    {
        $blogs = Blog::find(request('ids'));

        foreach ($blogs as $blog) {
            $blog->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('blog_create') && Gate::denies('blog_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Blog();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index()
    {
        // Danh mục
        $categories = Category::where('status', 1)
            ->whereNull('parent_id')
            ->orderByDesc('id')
            ->get();

        // Bài viết tiêu điểm
        $featuredBlog = Blog::where('status', 1)
            ->latest()
            ->first();

        // 3 bài viết mới tiếp theo (sau bài tiêu điểm)
        $latestBlogs = Blog::where('status', 1)
            ->where('id', '!=', optional($featuredBlog)->id)
            ->latest()
            ->take(3)
            ->get();

        // Danh sách bài viết còn lại
        $blogs = Blog::where('status', 1)
            ->whereNotIn('id', collect([$featuredBlog?->id])
                ->merge($latestBlogs->pluck('id')))
            ->latest()
            ->paginate(6);

        // Notification
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->take(10)
            ->get();

        $unreadCount = Notification::where('user_id', Auth::id())
            ->where('status', 'unread')
            ->count();

        return view('users.blog.index', compact(
            'categories',
            'featuredBlog',
            'latestBlogs',
            'blogs',
            'notifications',
            'unreadCount'
        ));
    }

    public function show($id)
    {
        // 1. Danh mục blog (menu, header)
        $categories = Category::where('status', 1)
            ->whereNull('parent_id')
            ->orderByDesc('id')
            ->get();

        // 2. Chi tiết bài viết
        $blog = Blog::where('id', $id)
            ->where('status', 1)
            ->firstOrFail();

        // 3. Bài viết phổ biến
        $popularBlogs = Blog::where('status', 1)
            ->where('id', '!=', $blog->id)
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        // 4. Bài viết liên quan
        $relatedBlogs = Blog::where('status', 1)
            ->where('id', '!=', $blog->id)
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        $notifications = Notification::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $unreadCount = Notification::where('user_id', Auth::id())
            ->where('status', 'unread')
            ->count();

        return view('users.blog.detail',
            compact(
                'categories',
                'blog',
                'popularBlogs',
                'relatedBlogs',
                'notifications',
                'unreadCount'
            ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\InstagramPost;
use App\Models\Post;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Ana Sayfa
     */
    public function index(): View
    {
        $services = Service::active()->orderBy('sort_order')->take(6)->get();

        $latestPosts = Post::with('category')
            ->published()
            ->latest('published_at')
            ->take(3)
            ->get();

        $aboutText = Setting::get('about_text');
        $aboutImage = Setting::get('about_image');
        $heroTitle = Setting::get('home_hero_title', 'Hayatınıza Yeni Bir <br> <span class="text-primary">Pencere Açın</span>');
        $heroText = Setting::get('home_hero_text', 'Zorlukların üstesinden gelirken yanınızdayız. Bilimsel yöntemler ve şefkatli bir yaklaşımla, kendi içinizdeki gücü keşfetmenize yardımcı oluyoruz.');

        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->get();
        $instagramPosts = InstagramPost::where('is_active', true)->orderBy('sort_order')->get();

        return view('home', compact('services', 'latestPosts', 'aboutText', 'aboutImage', 'heroTitle', 'heroText', 'faqs', 'instagramPosts'));
    }

    /**
     * Hakkımda Sayfası
     */
    public function about(): View
    {
        $aboutText = Setting::get('about_text');
        $aboutHeroDesc = Setting::get('about_hero_description');
        $aboutImage = Setting::get('about_image');
        $approachTitle = Setting::get('about_approach_title', 'Terapötik Yaklaşım');
        $approachText = Setting::get('about_approach_text');
        $aboutValues = json_decode(Setting::get('about_values', '[]'), true) ?: [];

        return view('about', compact(
            'aboutText',
            'aboutHeroDesc',
            'aboutImage',
            'approachTitle',
            'approachText',
            'aboutValues',
        ));
    }

    /**
     * Hizmetler Sayfası
     */
    public function services(): View
    {
        $services = Service::active()->ordered()->get();

        return view('services', compact('services'));
    }

    /**
     * Hizmet Detay Sayfası
     */
    public function serviceDetail(string $slug): View
    {
        $service = Service::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $otherServices = Service::active()
            ->ordered()
            ->where('id', '!=', $service->id)
            ->take(6)
            ->get();

        return view('service-detail', compact('service', 'otherServices'));
    }

    /**
     * Sertifikalar Sayfası
     */
    public function certificates(): View
    {
        $certificates = Certificate::active()->ordered()->get();

        return view('certificates', compact('certificates'));
    }

    /**
     * Blog Listesi Sayfası
     */
    public function blog(): View
    {
        $posts = Post::with('category')
            ->published()
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('blog', compact('posts'));
    }

    /**
     * Blog Detay Sayfası
     */
    public function blogDetail(string $slug): View
    {
        $post = Post::with('category')
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        $relatedPosts = Post::with('category')
            ->published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->take(3)
            ->get();

        return view('blog-detail', compact('post', 'relatedPosts'));
    }

    /**
     * Galeri Sayfası
     */
    public function gallery(): View
    {
        $galleries = Gallery::active()->ordered()->get();
        return view('gallery', compact('galleries'));
    }

    /**
     * İletişim Sayfası
     */
    public function contact(): View
    {
        $contactTitle = Setting::get('contact_page_title', 'İletişime Geçin');
        $contactDescription = Setting::get('contact_page_description');
        $phone = Setting::get('phone');
        $email = Setting::get('email');
        $address = Setting::get('address');
        $whatsapp = Setting::get('whatsapp');
        $mapEmbed = Setting::get('map_embed');

        return view('contact', compact(
            'contactTitle',
            'contactDescription',
            'phone',
            'email',
            'address',
            'whatsapp',
            'mapEmbed',
        ));
    }

    /**
     * İletişim Formu Gönderimi
     */
    public function contactSubmit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'message' => ['required', 'string', 'max:5000'],
        ], [
            'name.required' => 'Lütfen adınızı girin.',
            'email.required' => 'Lütfen e-posta adresinizi girin.',
            'email.email' => 'Lütfen geçerli bir e-posta adresi girin.',
            'message.required' => 'Lütfen mesajınızı yazın.',
            'message.max' => 'Mesajınız en fazla 5000 karakter olabilir.',
        ]);

        ContactMessage::create($validated);

        return redirect()
            ->route('contact')
            ->with('success', 'Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağız.');
    }
}

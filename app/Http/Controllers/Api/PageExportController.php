<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PageExportController extends Controller
{
    /**
     * Export a page to static HTML and save to public views directory
     */
    public function exportPage(Request $request, $id): JsonResponse
    {
        $page = Page::findOrFail($id);

        // Create a view based on the page content and the selected theme
        $theme = $request->input('theme', 'default');
        $viewContent = $this->generatePageView($page, $theme);

        // Create the public views directory if it doesn't exist
        $publicViewsPath = public_path('views');
        if (!File::exists($publicViewsPath)) {
            File::makeDirectory($publicViewsPath, 0755, true);
        }

        // Create a blade file for the page
        $filename = $page->slug . '.blade.php';
        $filePath = $publicViewsPath . '/' . $filename;

        File::put($filePath, $viewContent);

        return response()->json([
            'message' => 'Page exported successfully',
            'file_path' => $filePath,
            'public_url' => url($page->slug)
        ]);
    }

    /**
     * Generate view content based on page content and theme
     */
    private function generatePageView($page, $theme): string
    {
        // Determine the theme to use
        $themePath = resource_path("src/themes/{$theme}/PublicTheme.vue");

        // Use the theme conversion approach if the theme exists
        if (File::exists($themePath)) {
            return $this->convertVueToBlade(File::get($themePath), $page);
        } else {
            // Fallback to the default theme generation
            return $this->getDefaultThemeBlade($page);
        }
    }

    /**
     * Convert Vue component structure to Blade template
     * This is a simplified conversion - in real implementation, you'd want more sophisticated parsing
     */
    private function convertVueToBlade($vueContent, $page): string
    {
        // Create a blade template that extends the public theme
        $bladeContent = "@extends('themes.public-theme')\n\n@section('title', '{$page->title}')\n\n";

        // Add meta description and keywords if available
        if (!empty($page->meta_description)) {
            $bladeContent .= "@section('meta_description')\n    <meta name=\"description\" content=\"{$page->meta_description}\">\n@endsection\n\n";
        }
        if (!empty($page->meta_keywords)) {
            $bladeContent .= "@section('meta_keywords')\n    <meta name=\"keywords\" content=\"{$page->meta_keywords}\">\n@endsection\n\n";
        }

        // Start content section 
        $bladeContent .= "@section('content')\n";
        
        // Add the dynamic page content sections
        $bladeContent .= "<div class=\"container mx-auto px-4 py-8\">\n";
        if (is_array($page->content)) {
            foreach ($page->content as $section) {
                $bladeContent .= $this->renderSection($section, $page) . "\n";
            }
        }
        $bladeContent .= "</div>\n";
        
        // End content section
        $bladeContent .= "@endsection\n\n";

        // Add custom CSS if available
        $bladeContent .= "@section('custom_css')\n";
        if (is_array($page->custom_css) && isset($page->custom_css['css']) && !empty($page->custom_css['css'])) {
            $bladeContent .= "<style>\n{$page->custom_css['css']}\n</style>\n";
        }
        $bladeContent .= "@endsection\n\n";

        // Add custom JS if available
        $bladeContent .= "@section('custom_js')\n";
        if (is_array($page->custom_js) && isset($page->custom_js['js']) && !empty($page->custom_js['js'])) {
            $bladeContent .= "<script>\n{$page->custom_js['js']}\n</script>\n";
        }
        $bladeContent .= "@endsection";

        return $bladeContent;
    }
    
    /**
     * Extract content between specific component tags
     */
    private function extractComponentContent($vueContent, $componentName): string
    {
        // This is a simple approach - in a real implementation, you'd want more sophisticated parsing
        $pattern = '/<' . preg_quote($componentName, '/') . '[^>]*>(.*?)<\/' . preg_quote($componentName, '/') . '>/is';
        if (preg_match($pattern, $vueContent, $matches)) {
            // Simply convert the Vue template to HTML, keeping the basic structure
            $extractedContent = $matches[1];
            
            // Replace Vue directives with standard HTML (simplified)
            $extractedContent = preg_replace('/v-if="([^"]*)"/', '', $extractedContent);
            $extractedContent = preg_replace('/v-for="([^"]*)"/', '', $extractedContent);
            $extractedContent = preg_replace('/{{\s*([^}]*)\s*}}/', '<?php echo $1; ?>', $extractedContent);
            
            return $extractedContent;
        }
        
        return '';
    }

    /**
     * Render a specific content section
     */
    private function renderSection($section, $page): string
    {
        $sectionType = $section['type'] ?? 'text_block';
        $sectionContent = $section['content'] ?? [];

        switch ($sectionType) {
            case 'hero':
                return $this->renderHeroSection($sectionContent);
            case 'content_with_image':
                return $this->renderContentWithImageSection($sectionContent);
            case 'carousel':
                return $this->renderCarouselSection($sectionContent);
            case 'text_block':
                return $this->renderTextBlockSection($sectionContent);
            case 'grid':
                return $this->renderGridSection($sectionContent);
            case 'testimonials':
                return $this->renderTestimonialsSection($sectionContent);
            case 'cta':
                return $this->renderCtaSection($sectionContent);
            case 'products':
                return $this->renderProductsSection($sectionContent);
            case 'navigation':
                return $this->renderNavigationSection($sectionContent);
            case 'footer':
                return $this->renderFooterSection($sectionContent);
            default:
                return $this->renderGenericSection($section, $sectionContent);
        }
    }

    private function renderHeroSection($content): string
    {
        $title = $content['title'] ?? '';
        $subtitle = $content['subtitle'] ?? '';
        $imageUrl = $content['image_url'] ?? '';
        $ctaText = $content['cta_text'] ?? '';
        $ctaLink = $content['cta_link'] ?? '#';

        return "
        <section class=\"hero-section bg-gradient-to-r from-blue-500 to-indigo-700 text-white py-20\">
            <div class=\"container mx-auto px-4 text-center\">
                <h1 class=\"text-4xl md:text-5xl font-bold mb-4\">{$title}</h1>
                <p class=\"text-xl mb-8\">{$subtitle}</p>
                " . ($ctaText ? "<a href=\"{$ctaLink}\" class=\"bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors\">{$ctaText}</a>" : "") . "
            </div>
        </section>";
    }

    private function renderContentWithImageSection($content): string
    {
        $title = $content['title'] ?? '';
        $text = $content['content'] ?? '';
        $imageUrl = $content['image_url'] ?? '';
        $imagePosition = $content['image_position'] ?? 'right';

        $imgTag = $imageUrl ? "<img src=\"{$imageUrl}\" alt=\"{$title}\" class=\"w-full object-cover\">" : "";

        if ($imagePosition === 'left') {
            return "
            <section class=\"content-with-image-section py-12\">
                <div class=\"container mx-auto px-4 flex flex-col md:flex-row items-center gap-8\">
                    <div class=\"md:w-1/2\">{$imgTag}</div>
                    <div class=\"md:w-1/2\">
                        <h2 class=\"text-2xl font-bold mb-4\">{$title}</h2>
                        <p>{$text}</p>
                    </div>
                </div>
            </section>";
        } else {
            return "
            <section class=\"content-with-image-section py-12\">
                <div class=\"container mx-auto px-4 flex flex-col md:flex-row items-center gap-8\">
                    <div class=\"md:w-1/2\">
                        <h2 class=\"text-2xl font-bold mb-4\">{$title}</h2>
                        <p>{$text}</p>
                    </div>
                    <div class=\"md:w-1/2\">{$imgTag}</div>
                </div>
            </section>";
        }
    }

    private function renderTextBlockSection($content): string
    {
        $title = $content['title'] ?? '';
        $contentText = $content['content'] ?? '';

        return "
        <section class=\"text-block-section py-12\">
            <div class=\"container mx-auto px-4\">
                " . ($title ? "<h2 class=\"text-2xl font-bold mb-4\">{$title}</h2>" : "") . "
                <div>{$contentText}</div>
            </div>
        </section>";
    }

    // Additional render methods for other section types would go here...
    // For brevity, I'll implement a generic section renderer for other types
    private function renderGenericSection($section, $content): string
    {
        $type = $section['type'] ?? 'section';
        $title = $section['content']['title'] ?? ucfirst(str_replace('_', ' ', $type));
        
        return "
        <section class=\"generic-section py-12\">
            <div class=\"container mx-auto px-4 text-center\">
                <h2 class=\"text-2xl font-bold mb-4\">{$title}</h2>
                <p>Content for {$type} section would appear here. This is a placeholder since the specific renderer is not implemented yet.</p>
            </div>
        </section>";
    }

    // Additional render methods would be added as needed...

    /**
     * Get a default theme blade template if the requested theme doesn't exist
     */
    private function getDefaultThemeBlade($page): string
    {
        // This is a simplified default theme
        $bladeContent = "
@extends('layouts.app')

@section('title', '{$page->title}')

@section('meta_description', '{$page->meta_description ?? ''}')
@section('meta_keywords', '{$page->meta_keywords ?? ''}')

@section('content')
<div class=\"max-w-4xl mx-auto px-4 py-8\">
";

        if (is_array($page->content)) {
            foreach ($page->content as $section) {
                $bladeContent .= $this->renderSection($section, $page) . "\n";
            }
        }

        $bladeContent .= "
</div>
@endsection";

        return $bladeContent;
    }

    /**
     * Remove a page from public views
     */
    public function removePage($id): JsonResponse
    {
        $page = Page::findOrFail($id);

        // Remove the blade file for the page
        $filePath = public_path('views') . '/' . $page->slug . '.blade.php';
        
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        return response()->json([
            'message' => 'Page removed from public views successfully',
            'file_path' => $filePath
        ]);
    }
}
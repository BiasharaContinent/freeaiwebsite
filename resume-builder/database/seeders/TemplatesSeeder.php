<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Template;

class TemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Template::firstOrCreate(
            ['name' => 'Classic Professional'],
            [
                'description' => 'A timeless, ATS-friendly design suitable for traditional roles.',
                'type' => 'ats',
                'preview_image_path' => 'images/templates/classic_professional_preview.png', // Placeholder
                'view_name' => 'resumes.templates.classic_professional', // Actual Blade view for rendering
                'font_specs' => json_encode(['body' => 'Times New Roman, serif', 'heading' => 'Georgia, serif']),
                'color_specs' => json_encode(['primary' => '#333333', 'accent' => '#000000', 'background' => '#FFFFFF']),
                'is_active' => true,
            ]
        );

        Template::firstOrCreate(
            ['name' => 'Modern Minimalist'],
            [
                'description' => 'A clean, stylish design with a modern touch, good for creative fields.',
                'type' => 'styled',
                'preview_image_path' => 'images/templates/modern_minimalist_preview.png', // Placeholder
                'view_name' => 'resumes.templates.modern_minimalist', // Actual Blade view for rendering
                'font_specs' => json_encode(['body' => 'Roboto, sans-serif', 'heading' => 'Montserrat, sans-serif']),
                'color_specs' => json_encode(['primary' => '#2c3e50', 'accent' => '#3498db', 'background' => '#FFFFFF']),
                'is_active' => true,
            ]
        );

        Template::firstOrCreate(
            ['name' => 'Simple ATS'],
            [
                'description' => 'A very basic, no-frills ATS template focused purely on content extraction.',
                'type' => 'ats',
                'preview_image_path' => 'images/templates/simple_ats_preview.png', // Placeholder
                'view_name' => 'resumes.templates.simple_ats', // Actual Blade view for rendering
                'font_specs' => json_encode(['body' => 'Arial, sans-serif', 'heading' => 'Arial, sans-serif']),
                'color_specs' => json_encode(['primary' => '#000000', 'accent' => '#000000', 'background' => '#FFFFFF']),
                'is_active' => true,
            ]
        );
         Template::firstOrCreate(
            ['name' => 'Creative Styled'],
            [
                'description' => 'A more visually engaging styled template for portfolios and design roles.',
                'type' => 'styled',
                'preview_image_path' => 'images/templates/creative_styled_preview.png', // Placeholder
                'view_name' => 'resumes.templates.creative_styled', // Actual Blade view for rendering
                'font_specs' => json_encode(['body' => 'Lato, sans-serif', 'heading' => 'Raleway, sans-serif']),
                'color_specs' => json_encode(['primary' => '#333', 'accent' => '#e74c3c', 'background' => '#f9f9f9']),
                'is_active' => true,
            ]
        );
    }
}

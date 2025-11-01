<?php

return [
    'title' => 'Settings',
    'success_message' => 'Settings updated successfully.',

    // Sections
    'general_section' => [
        'title' => 'General Information & Contact',
        'name' => 'Restaurant Name',
        'currency' => 'Currency',
        'contact_email' => 'Contact E-Mail',
        'contact_phone' => 'Phone Number',
        'subdomain' => 'Your Subdomain',
        'subdomain_help' => 'Only lowercase letters, numbers, and hyphens are allowed.',
        'subdomain_warning' => 'Warning: If you change the subdomain, existing QR codes and links will no longer work!',
        'address' => 'Address',
    ],

    'design_section' => [
        'title' => 'Design & Branding',
        'logo' => 'Upload Logo',
        'logo_help' => 'Accepted formats: PNG, JPG, WEBP. Max. 2MB.',
        'current_logo' => 'Current Logo:',
        'accent_color' => 'Menu Accent Color (Hex Code)',
    ],

    'social_section' => [
        'title' => 'Social Media & Links',
        'website' => 'Website (URL)',
        'google' => 'Google Maps/Business (URL)',
        'facebook' => 'Facebook Page (URL)',
        'instagram' => 'Instagram Profile (URL)',
        'tiktok' => 'TikTok Profile (URL)',
        'other' => 'Other Link (e.g., Reservation, Delivery)',
    ],

    'seo_section' => [
        'title' => 'SEO & Visibility',
        'seo_title' => 'SEO Title',
        'seo_title_help' => 'Appears in the browser tab and Google search results (max. 60 characters recommended).',
        'meta_description' => 'Meta Description',
        'meta_description_help' => 'Short summary for search engines (max. 160 characters recommended).',
        'og_image_url' => 'Social Media Image URL (Open Graph Image)',
        'og_image_url_help' => 'The image that appears when sharing on Facebook, WhatsApp, etc. (Optimal: 1200x630px).',
    ],
    
    'portal_profile' => [
        'title' => 'Public Profile (Discovery Platform)',
        'subtitle' => 'Manage how your restaurant appears on tagsmenu.app.',

        'visibility_title' => 'Visibility',
        'visibility_label' => 'List my restaurant publicly.',
        'visibility_helper' => 'If disabled, your menu is only accessible via the direct link, but not findable via search.',

        'about_us_title' => 'About Us Description',
        'about_us_placeholder' => 'Tell potential guests something about your restaurant...',

        'categories_title' => 'Categories (Cuisine Style)',
        'categories_helper' => 'Select the appropriate categories. This helps users find you.',

        'hashtags_title' => 'Hashtags (Features)',
        'hashtags_helper' => 'Add specific features (e.g., #Terrace, #VeganFriendly). Separate them with commas.',
        'hashtags_placeholder' => 'e.g., #Terrace, #Accessible',

        'media_title' => 'Media',
        'logo' => 'Logo',
        'cover_image' => 'Cover Image',
    ],

    'staff_access_section' => [
        'title' => 'Staff Access (Availability)',
        'description' => 'Use this secret link to allow your staff (e.g., in the kitchen) to quickly mark items as "sold out" without logging into the dashboard.',
        'copy' => 'Copy',
        'copied' => 'Copied!',
        'warning' => 'Important:',
        'warning_text' => 'Treat this link as confidential! Anyone who knows the link can change the availability.',
    ],

    'billing_section' => [
        'title' => 'Subscription & Billing',
        'description' => 'Here you can manage your subscription, view your invoices, or change your payment method. You will be securely redirected to the Stripe Billing Portal.',
        'manage_billing' => 'Manage Billing',
    ],
    
    'save_changes' => 'Save Changes',
];
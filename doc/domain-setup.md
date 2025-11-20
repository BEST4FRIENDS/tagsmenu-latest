# Domain Setup Guide

## Domain Structure

This application uses a multi-domain routing structure:

- **`tagsmenu.app`** → Public Portal (Home, Search, Blog, Restaurant Hubs)
- **`app.tagsmenu.app`** → Admin Dashboard (Login, Dashboard, Settings, Superadmin)
- **`{restaurant}.tagsmenu.app`** → Individual Restaurant Menus (via subdomain routing)

## Code Changes Made

### 1. `config/app.php`
Added new domain configuration:
```php
'domain_admin' => env('APP_DOMAIN_ADMIN', 'app.tagsmenu.app'),
```

### 2. `routes/web.php`
Restructured routes to use domain-based routing:
- Admin routes (auth, dashboard, settings, superadmin) are now wrapped in `Route::domain(config('app.domain_admin'))`
- Public routes remain on the main domain (`tagsmenu.app`)

## Deployment Steps

### 1. Update `.env` on Droplet

Add/update these environment variables in your `.env` file on the droplet:

```env
APP_URL=https://tagsmenu.app
APP_DOMAIN_PORTAL=tagsmenu.app
APP_DOMAIN_BASE=tagsmenu.app
APP_DOMAIN_ADMIN=app.tagsmenu.app
```

### 2. Configure Cloudflare DNS

Add a new A record for the admin subdomain:

- **Type:** `A`
- **Name:** `app`
- **Content:** `209.38.41.24` (your droplet IP)
- **Proxy status:** Proxied (orange cloud) ✅
- **TTL:** Auto

### 3. Clear and Rebuild Caches

SSH into your droplet and run:

```bash
cd /www/tagsmenu-latest
docker compose exec laravel.test php artisan config:clear
docker compose exec laravel.test php artisan route:clear
docker compose exec laravel.test php artisan config:cache
docker compose exec laravel.test php artisan route:cache
```

### 4. Verify Domain Routing

After DNS propagation (can take a few minutes to 24 hours):

- ✅ `https://tagsmenu.app` → Should show public portal (home page)
- ✅ `https://app.tagsmenu.app` → Should show login page
- ✅ `https://app.tagsmenu.app/login` → Should show login form
- ✅ `https://app.tagsmenu.app/dashboard` → Should redirect to login (if not authenticated)

## Testing

1. **Public Portal:** Visit `https://tagsmenu.app` - should show home page
2. **Admin Login:** Visit `https://app.tagsmenu.app/login` - should show login form
3. **After Login:** Should redirect to `https://app.tagsmenu.app/dashboard`

## Troubleshooting

### Issue: Routes not working on `app.tagsmenu.app`

**Solution:**
- Verify DNS record is created in Cloudflare
- Check that `APP_DOMAIN_ADMIN` is set correctly in `.env`
- Clear route cache: `php artisan route:clear && php artisan route:cache`
- Verify Cloudflare SSL mode is set to "Flexible" or "Full"

### Issue: Getting 404 on admin routes

**Solution:**
- Ensure routes are properly wrapped in `Route::domain()` group
- Check that `config('app.domain_admin')` returns correct value
- Verify route cache is cleared and rebuilt

### Issue: Session/cookie issues between domains

**Solution:**
- Ensure `SESSION_DOMAIN` in `.env` is set to `.tagsmenu.app` (with leading dot) to allow cookies across subdomains
- Or set separate session domains if needed

## Notes

- The admin dashboard is now completely separated on `app.tagsmenu.app`
- All authentication, dashboard, and admin features are accessible only via `app.tagsmenu.app`
- Public features (home, search, blog) remain on `tagsmenu.app`
- Restaurant subdomain menus continue to work as before


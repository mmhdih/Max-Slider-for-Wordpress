<h1 align="center">Tavoos Max Slider</h1>

<p align="center">
  <a href="https://github.com/mmhdih/Max-Slider-for-Wordpress/releases/latest"><img src="https://img.shields.io/github/v/release/mmhdih/Max-Slider-for-Wordpress?label=release" alt="Latest release"></a>
  <img src="https://img.shields.io/badge/WordPress-5.8%2B-21759b?logo=wordpress" alt="WordPress 5.8+">
  <img src="https://img.shields.io/badge/PHP-7.4%2B-777bb4?logo=php" alt="PHP 7.4+">
  <a href="LICENSE"><img src="https://img.shields.io/badge/license-GPL--2.0--or--later-blue" alt="GPL-2.0-or-later"></a>
</p>

<p align="center">
  <a href="https://github.com/mmhdih/Max-Slider-for-Wordpress/releases/latest/download/tavoos-max-slider.zip"><b>⬇️ دانلود افزونه — Download tavoos-max-slider.zip</b></a>
  <br>
  <a href="#فارسی">فارسی</a> · <a href="#english">English</a>
</p>

<p align="center">
  <img src="docs/images/05-frontend-desktop.png" alt="Tavoos Max Slider on the front end" width="760">
</p>

---

<div dir="rtl">

## فارسی

**مکس اسلایدر طاووس** (Tavoos Max Slider) یک افزونه‌ی اسلایدر تصویر سبک و بدون وابستگی (بدون jQuery، بدون کتابخانه‌ی جانبی) برای وردپرس است. هر تعداد اسلایدر که بخواهید برای جاهای مختلف سایت می‌سازید؛ هر اسلایدر ابعاد، سرعت و ظاهر مخصوص خودش را دارد و با یک شورت‌کد در هر برگه، نوشته یا ابزارک المنتور نمایش داده می‌شود.

### ✨ ویژگی‌ها

- **چند اسلایدر مستقل** — مثلاً یک اسلایدر برای صفحه‌ی اصلی، یکی برای فروشگاه و یکی برای بنر تبلیغاتی.
- **تصویر جداگانه برای موبایل** برای هر اسلاید (اختیاری) و **لینک** برای هر اسلاید.
- **نسبت ابعاد جدا برای دسکتاپ و موبایل** (۱۶۰۰×۵۶۰، ۱۹۲۰×۶۰۰، ۱۶:۹، مربع، عمودی و …).
- **سه چیدمان:** داخل کادر، عریض (۱۴۴۰ پیکسل) و تمام عرض صفحه.
- **دو افکت:** لغزش و محو شدن.
- تنظیم **مدت نمایش، پخش خودکار، گردی گوشه‌ها، فلش‌ها، نقطه‌ها، سایه، فاصله و رنگ اصلی**.
- پشتیبانی از **JPG، PNG، WEBP و GIF متحرک**.
- **کشیدن با انگشت (Swipe)** در موبایل، کنترل با کیبورد، توقف هنگام هاور و وقتی تب مرورگر باز نیست.
- **راست‌چین و چپ‌چین** به‌صورت خودکار (جهت حرکت و فلش‌ها درست کار می‌کنند).
- **سریع و سئو-دوست:** اولین تصویر با `fetchpriority="high"` لود می‌شود، اسکریپت فقط در صفحه‌هایی که اسلایدر دارند بارگذاری می‌شود و حجم کل CSS و JS کمتر از ۸ کیلوبایت است.
- **دسترس‌پذیر:** برچسب‌های ARIA برای اسلایدر، اسلایدها، فلش‌ها و نقطه‌ها.
- **ترجمه‌ی کامل فارسی**؛ روی سایت‌های فارسی، پنل افزونه خودکار فارسی می‌شود.

### 📦 نصب

1. فایل [**tavoos-max-slider.zip**](https://github.com/mmhdih/Max-Slider-for-Wordpress/releases/latest/download/tavoos-max-slider.zip) را از بخش [Releases](https://github.com/mmhdih/Max-Slider-for-Wordpress/releases/latest) دانلود کنید (فایل zip را باز نکنید).
2. در پیشخوان وردپرس به **افزونه‌ها ← افزودن ← بارگذاری افزونه** بروید.
3. فایل zip را انتخاب کنید، روی **هم‌اکنون نصب کن** و بعد **فعال‌سازی** بزنید.
4. منوی جدید **اسلایدرها** در پیشخوان اضافه می‌شود.

### 🚀 نحوه‌ی استفاده

#### مرحله ۱ — ساخت اسلایدر

به **اسلایدرها ← مدیریت اسلایدرها** بروید، یک نام وارد کنید (مثلاً «اسلایدر صفحه اصلی») و تنظیمات را انتخاب کنید. **نامک** (slug) همان شناسه‌ای است که در شورت‌کد استفاده می‌شود. در ستون **کد نمایش** شورت‌کد آماده‌ی هر اسلایدر را می‌بینید.

<p align="center"><img src="docs/images/01-create-slider.png" alt="ساخت اسلایدر" width="760"></p>

#### مرحله ۲ — تنظیمات اسلایدر

روی نام اسلایدر کلیک کنید تا صفحه‌ی تنظیمات باز شود. شورت‌کد اسلایدر هم بالای همین صفحه نوشته شده است.

<p align="center"><img src="docs/images/02-slider-settings.png" alt="تنظیمات اسلایدر" width="560"></p>

#### مرحله ۳ — افزودن اسلاید

به **اسلایدرها ← افزودن اسلاید** بروید:

- **عنوان:** فقط برای مدیریت است و به‌عنوان متن جایگزین (alt) تصویر استفاده می‌شود.
- **تصویر اسلاید (دسکتاپ):** از کادر سمت راست/چپ صفحه انتخاب کنید. **اسلاید بدون تصویر نمایش داده نمی‌شود.**
- **تصویر موبایل** (اختیاری): اگر خالی بماند، تصویر دسکتاپ در موبایل هم نمایش داده می‌شود.
- **لینک اسلاید** (اختیاری): با کلیک روی اسلاید باز می‌شود.
- **اسلایدرها (جایگاه‌ها):** تیک اسلایدری را بزنید که این اسلاید باید در آن نمایش داده شود (یک اسلاید می‌تواند در چند اسلایدر باشد).
- **ویژگی‌ها ← ترتیب:** عدد کمتر یعنی جلوتر.

<p align="center"><img src="docs/images/03-edit-slide.png" alt="ویرایش اسلاید" width="760"></p>

همه‌ی اسلایدها با پیش‌نمایش تصویر، اسلایدر و ترتیب در **اسلایدرها ← همه اسلایدها** دیده می‌شوند:

<p align="center"><img src="docs/images/04-slides-list.png" alt="فهرست اسلایدها" width="760"></p>

#### مرحله ۴ — نمایش در سایت

شورت‌کد اسلایدر را هر جا که می‌خواهید قرار دهید:

```text
[tavoos_slider id="home"]
```

- **المنتور:** ابزارک **کد کوتاه (Shortcode)** را بکشید و کد را داخلش بچسبانید.
- **ویرایشگر بلوک (گوتنبرگ):** بلوک **کد کوتاه** را اضافه کنید.
- **ابزارک‌ها:** ابزارک «کد کوتاه» یا «متن».
- **داخل قالب (PHP):** `<?php echo do_shortcode( '[tavoos_slider id="home"]' ); ?>`

<table>
<tr>
<td align="center"><b>دسکتاپ</b><br><img src="docs/images/05-frontend-desktop.png" alt="نمایش در دسکتاپ" width="520"></td>
<td align="center"><b>موبایل</b><br><img src="docs/images/06-frontend-mobile.png" alt="نمایش در موبایل" width="220"></td>
</tr>
</table>

### 🧩 شورت‌کدها

| شورت‌کد | توضیح |
|---|---|
| `[tavoos_slider id="نامک"]` | نمایش اسلایدر با نامک مشخص. |

سایت‌هایی که از نسخه‌ی قدیمی منتقل شده‌اند، شورت‌کدهای قدیمی `[sp_slider]`، `[sp_home_slider]` و `[max_slider]` را هم دارند تا صفحه‌های قبلی خراب نشوند.

### ⚙️ تنظیمات هر اسلایدر

| تنظیم | گزینه‌ها | پیش‌فرض |
|---|---|---|
| چیدمان | داخل کادر · عریض (۱۴۴۰px) · تمام عرض | داخل کادر |
| نسبت ابعاد دسکتاپ | ۱۶۰۰×۵۶۰ · ۱۹۲۰×۶۰۰ · ۱۶:۹ · ۱۲۰۰×۴۰۰ · ۱۲۰۰×۲۵۰ · ۴:۳ · مربع | ۱۶۰۰×۵۶۰ |
| نسبت ابعاد موبایل | مربع · عمودی ۴:۵ · ۱۶:۹ · مثل دسکتاپ | مربع |
| مدت نمایش هر اسلاید | ۱ تا ۳۰ ثانیه | ۵ |
| پخش خودکار | فعال · غیرفعال | فعال |
| افکت | لغزش · محو شدن | لغزش |
| گردی گوشه‌ها | ۰ تا ۶۰ پیکسل | ۲۸ |
| فلش‌ها / نقطه‌ها | نمایش · مخفی | نمایش |
| سایه | دارد · ندارد | دارد |
| فاصله از بالا و پایین | ۰ تا ۱۲۰ پیکسل | ۰ |
| رنگ اصلی | هر رنگی (نقطه‌ی فعال و هاور فلش‌ها) | `#f5b301` |

### 🖼️ ابعاد پیشنهادی تصاویر

| کاربرد | دسکتاپ | موبایل |
|---|---|---|
| بنر اصلی صفحه (داخل کادر) | ۱۶۰۰×۵۶۰ | ۸۰۰×۸۰۰ |
| اسلایدر تمام عرض | ۱۹۲۰×۶۰۰ | ۸۰۰×۱۰۰۰ |
| بنر باریک تبلیغاتی | ۱۲۰۰×۲۵۰ | ۸۰۰×۸۰۰ |

برای سرعت بهتر تصاویر را با فرمت **WEBP** و حجم کمتر از ۲۰۰ کیلوبایت آپلود کنید. تصویر به‌صورت `cover` در کادر قرار می‌گیرد، پس متن‌های مهم را از لبه‌ها دور نگه دارید.

### 🔄 مهاجرت از نسخه‌ی قبلی (مکس اسلایدر ۱.x / سپنتا اسلایدر / کد اسنیپت)

از نسخه‌ی ۲ نام افزونه «مکس اسلایدر طاووس» و نامک آن `tavoos-max-slider` است و همه‌ی نام‌های داخلی پیشوند یکتا دارند (قانون مخزن وردپرس). **همه‌ی اسلایدرها، اسلایدها و تنظیمات قبلی خودکار منتقل می‌شوند:**

1. مکس اسلایدر طاووس را نصب و فعال کنید.
2. افزونه‌ی قدیمی (مکس اسلایدر ۱.x یا «سپنتا پت – اسلایدرها») را **غیرفعال و حذف** کنید، یا کد اسلایدر را از `functions.php` / Code Snippets پاک کنید.
3. با اولین بارگذاری صفحه، اطلاعات منتقل می‌شود. شورت‌کدهای قدیمی `[sp_slider id="…"]` در صفحات همچنان کار می‌کنند؛ برای صفحه‌های جدید از `[tavoos_slider id="…"]` استفاده کنید.

تا وقتی نسخه‌ی قدیمی فعال است، انتقال انجام نمی‌شود و یک هشدار در پیشخوان نمایش داده می‌شود.

### ❓ سوالات متداول

<details>
<summary>اسلایدر نمایش داده نمی‌شود.</summary>

- نامک داخل شورت‌کد را با ستون «کد نمایش» مقایسه کنید.
- اسلایدها باید **منتشر شده** باشند و **تصویر اسلاید** داشته باشند.
- تیک اسلایدر در کادر «اسلایدرها (جایگاه‌ها)» هر اسلاید زده شده باشد.
- اگر افزونه‌ی کش دارید، کش را پاک کنید.
</details>

<details>
<summary>اسلایدر در حالت تمام عرض، اسکرول افقی ایجاد می‌کند.</summary>

در بعضی قالب‌ها که نوار اسکرول عرض دارد، این اتفاق می‌افتد. به والد اسلایدر (مثلاً بخش المنتور) `overflow-x: hidden` بدهید، یا از چیدمان «عریض» استفاده کنید.
</details>

<details>
<summary>حداکثر چند اسلاید در هر اسلایدر نمایش داده می‌شود؟</summary>

۳۰ اسلاید (به ترتیب فیلد «ترتیب»).
</details>

<details>
<summary>ظاهر را چطور با CSS تغییر بدهم؟</summary>

کلاس‌های اصلی: `.tavoos-slider`، `.tavoos-slide`، `.tavoos-slider__nav`، `.tavoos-slider__dots`. هر اسلایدر کلاس‌های `tavoos-slider--boxed|wide|full` و `tavoos-slider--slide|fade` دارد. متغیرهای CSS: `--tavoos-radius`، `--tavoos-gap`، `--tavoos-accent`، `--tavoos-rd` (نسبت دسکتاپ) و `--tavoos-rm` (نسبت موبایل).
</details>

<details>
<summary>بعد از اضافه شدن اسلایدر با AJAX (مثلاً پاپ‌آپ) کار نمی‌کند.</summary>

بعد از اضافه شدن محتوا این تابع را صدا بزنید: `window.tavoosSliderInit()`
</details>

### 👤 نویسنده

ساخته‌شده توسط [**mmhdih**](https://github.com/mmhdih) — طراحی شده توسط [**مهدی حبیبی | طاووس وب**](https://tavoosweb.ir/). اگر مشکلی دیدید یا پیشنهادی دارید، در بخش [Issues](https://github.com/mmhdih/Max-Slider-for-Wordpress/issues) مطرح کنید.

</div>

---

## English

**Tavoos Max Slider** is a lightweight, dependency-free (no jQuery, no libraries) image slider plugin for WordPress. Build as many independent sliders as you need — each with its own size, speed and style — and place them anywhere with a shortcode (Elementor, Gutenberg, widgets, theme files).

### Features

- **Multiple independent sliders** (home page, shop, promo banner, …).
- Optional **separate mobile image** and **link** for every slide.
- **Separate desktop and mobile aspect ratios.**
- **Layouts:** boxed, wide (1440 px) and full page width.
- **Effects:** slide and fade.
- Duration, autoplay, corner radius, arrows, dots, shadow, spacing and **accent color** per slider.
- **JPG, PNG, WEBP and animated GIF.**
- **Touch swipe**, keyboard control, pause on hover / focus / hidden tab.
- **RTL and LTR** detected automatically.
- **Fast:** first image gets `fetchpriority="high"`, the script only loads on pages that show a slider, CSS + JS < 8 KB.
- **Accessible** ARIA carousel markup.
- **Translation ready**, Persian (fa_IR) included.

### Installation

1. Download [**tavoos-max-slider.zip**](https://github.com/mmhdih/Max-Slider-for-Wordpress/releases/latest/download/tavoos-max-slider.zip) from [Releases](https://github.com/mmhdih/Max-Slider-for-Wordpress/releases/latest) (don't unzip it).
2. In WordPress go to **Plugins → Add New → Upload Plugin**, choose the zip, **Install Now**, then **Activate**.
3. A new **Sliders** menu appears in the dashboard.

### Usage

1. **Sliders → Manage sliders:** create a slider and pick its settings. The *slug* is the ID used in the shortcode, shown in the **Display code** column.
2. **Sliders → Add slide:** set a title, the **slide image (desktop)**, an optional **mobile image** and **link**, tick the slider(s) it belongs to in **Sliders (placements)**, and set the display order in **Page Attributes → Order** (lower = first). Slides without an image are skipped.
3. Put the shortcode where you want the slider:

```text
[tavoos_slider id="home"]
```

Use the Elementor **Shortcode** widget, the Gutenberg **Shortcode** block, a widget, or `<?php echo do_shortcode( '[tavoos_slider id="home"]' ); ?>` in a theme file.

| Screen | |
|---|---|
| Create slider | <img src="docs/images/01-create-slider.png" width="520" alt="Create slider"> |
| Slider settings | <img src="docs/images/02-slider-settings.png" width="380" alt="Slider settings"> |
| Edit slide | <img src="docs/images/03-edit-slide.png" width="520" alt="Edit slide"> |
| All slides | <img src="docs/images/04-slides-list.png" width="520" alt="All slides"> |
| Mobile | <img src="docs/images/06-frontend-mobile.png" width="200" alt="Mobile"> |

### Shortcodes

| Shortcode | Description |
|---|---|
| `[tavoos_slider id="slug"]` | Show the slider with that slug. |

Sites migrated from an older version also keep the old `[sp_slider]`, `[sp_home_slider]` and `[max_slider]` shortcodes, so existing pages don't break.

### Customizing with CSS

Main classes: `.tavoos-slider`, `.tavoos-slide`, `.tavoos-slider__nav`, `.tavoos-slider__dots`, plus modifiers `tavoos-slider--boxed|wide|full` and `tavoos-slider--slide|fade`. CSS variables: `--tavoos-radius`, `--tavoos-gap`, `--tavoos-accent`, `--tavoos-rd` (desktop ratio), `--tavoos-rm` (mobile ratio). If a slider is injected later via AJAX, call `window.tavoosSliderInit()`.

### Upgrading from Max Slider 1.x / Sepanta Slider

Since 2.0 the plugin is called Tavoos Max Slider (slug `tavoos-max-slider`) and every internal name uses a unique prefix, as the WordPress.org guidelines require. Install and activate it, then deactivate and delete the old plugin (or remove the snippet). On the next page load all sliders, slides and settings are moved over automatically, and old `[sp_slider]` shortcodes keep working. Nothing is migrated while the old code is still active; a notice tells you so.

### Development

```text
tavoos-max-slider/          ← the plugin (this folder is what gets zipped)
├── tavoos-max-slider.php   ← plugin header & bootstrap
├── readme.txt              ← WordPress.org readme
├── includes/
│   ├── settings.php        ← defaults, field definitions, sanitizing
│   ├── migrate.php         ← one-time upgrade of data from 1.x
│   ├── post-types.php      ← post type, taxonomy, meta registration
│   ├── admin.php           ← settings form, meta box, admin columns
│   └── render.php          ← front-end markup, shortcodes, assets
├── assets/css|js/
└── languages/              ← .pot + Persian translation (tools/build-translations.py)
```

Releases are built by GitHub Actions (`.github/workflows/release.yml`): push a tag such as `v1.0.1`, or run the **Release** workflow manually, and `tavoos-max-slider.zip` is attached to a new GitHub Release.

### Author & license

Made by [**mmhdih**](https://github.com/mmhdih) — designed by [**Mahdi Habibi | Tavoos Web**](https://tavoosweb.ir/). Licensed under [GPL-2.0-or-later](LICENSE).

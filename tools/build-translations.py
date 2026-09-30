#!/usr/bin/env python3
# Builds translations/tavoos-image-carousel-fa_IR.po (and .mo) from the table below,
# for importing into translate.wordpress.org. The plugin itself ships only the .pot
# (tavoos-image-carousel/languages/), generated with `wp i18n make-pot`.
# Usage: python3 tools/build-translations.py
import struct, os
L=os.path.join(os.path.dirname(os.path.abspath(__file__)), '..', 'translations') + '/'
os.makedirs(L, exist_ok=True)
T=[
(None,"Manage sliders","مدیریت اسلایدرها"),
(None,"Display code","کد نمایش"),
(None,'Put this code in the Elementor "Shortcode" widget, a Shortcode block or any page.',"این کد را در ابزارک «کد کوتاه» المنتور، بلوک «کد کوتاه» یا هر برگه‌ای قرار دهید."),
(None,"Slide settings","تنظیمات اسلاید"),
(None,"Slide link","لینک اسلاید"),
(None,"(optional)","(اختیاری)"),
(None,"Mobile image","تصویر موبایل"),
(None,"Choose mobile image","انتخاب تصویر موبایل"),
(None,"Remove","حذف"),
(None,'Formats: JPG, PNG, WEBP and animated GIF. Choose the slider(s) this slide is shown in from the "Sliders (placements)" box. Set the order in "Page Attributes → Order" (lower number = shown first).',"فرمت‌ها: JPG، PNG، WEBP و GIF متحرک. اسلایدری که این اسلاید در آن نمایش داده شود را از کادر «اسلایدرها (جایگاه‌ها)» انتخاب کنید. ترتیب از «ویژگی‌ها ← ترتیب» (عدد کمتر = جلوتر)."),
(None,"Image","تصویر"),
(None,"Title","عنوان"),
(None,"Slider","اسلایدر"),
(None,"Order","ترتیب"),
(None,"Tavoos Image Carousel: an older version of this slider (version 1.x of this plugin, the Sepanta Slider plugin or its code snippet) is still active. Deactivate or remove it — your slides are moved to Tavoos Image Carousel automatically once it is gone.","کاروسل تصویر طاووس: نسخه‌ی قدیمی این اسلایدر (نسخه‌ی ۱.x این افزونه، افزونه‌ی «سپنتا پت – اسلایدرها» یا کد آن) هنوز فعال است. آن را غیرفعال یا حذف کنید؛ بعد از آن اسلایدها خودکار به کاروسل تصویر طاووس منتقل می‌شوند."),
(None,"Accent color (active dot, arrow hover)","رنگ اصلی (نقطه‌ی فعال و فلش‌ها هنگام هاور)"),
(None,"Sliders","اسلایدرها"),
(None,"Slide","اسلاید"),
(None,"Add slide","افزودن اسلاید"),
(None,"Add new slide","افزودن اسلاید جدید"),
(None,"Edit slide","ویرایش اسلاید"),
(None,"All slides","همه اسلایدها"),
(None,"Slide image (desktop)","تصویر اسلاید (دسکتاپ)"),
(None,"Set slide image","انتخاب تصویر اسلاید"),
(None,"Remove image","حذف تصویر"),
(None,"Use as slide image","استفاده به عنوان تصویر اسلاید"),
(None,"Search slides","جستجوی اسلایدها"),
(None,"No slides found.","اسلایدی پیدا نشد."),
(None,"No slides found in Trash.","اسلایدی در زباله‌دان پیدا نشد."),
(None,"Sliders (placements)","اسلایدرها (جایگاه‌ها)"),
(None,"Create new slider","ساخت اسلایدر جدید"),
(None,"Slider settings","تنظیمات اسلایدر"),
(None,"All sliders","همه اسلایدرها"),
(None,"Search sliders","جستجوی اسلایدرها"),
(None,"No sliders found.","اسلایدری پیدا نشد."),
(None,"← Back to sliders","→ بازگشت به اسلایدرها"),
(None,"%1$d of %2$d","%1$d از %2$d"),
(None,"Previous slide","اسلاید قبلی"),
(None,"Next slide","اسلاید بعدی"),
(None,"Slide %d","اسلاید %d"),
(None,"Show","نمایش"),
(None,"Hide","مخفی"),
(None,"Layout","چیدمان"),
(None,"Boxed (same width as the content)","داخل کادر (هم‌عرض محتوا)"),
(None,"Full page width","تمام عرض صفحه"),
(None,"Wide (1440 px)","عریض (۱۴۴۰ پیکسل)"),
(None,"Desktop aspect ratio","نسبت ابعاد دسکتاپ"),
(None,"Wide 1600×560 (recommended for a main banner)","پهن ۱۶۰۰×۵۶۰ (پیشنهادی بنر اصلی)"),
(None,"Extra wide 1920×600 (full width)","خیلی پهن ۱۹۲۰×۶۰۰ (تمام عرض)"),
(None,"16:9 (1600×900)","۱۶:۹ (۱۶۰۰×۹۰۰)"),
(None,"Strip 1200×400","نواری ۱۲۰۰×۴۰۰"),
(None,"Thin banner 1200×250","بنر باریک ۱۲۰۰×۲۵۰"),
(None,"4:3","۴:۳"),
(None,"Square","مربع"),
(None,"Mobile aspect ratio","نسبت ابعاد موبایل"),
(None,"Square 800×800 (recommended)","مربع ۸۰۰×۸۰۰ (پیشنهادی)"),
(None,"Portrait 800×1000","عمودی ۸۰۰×۱۰۰۰"),
(None,"16:9","۱۶:۹"),
(None,"Same as desktop","مثل دسکتاپ"),
(None,"Duration of each slide (seconds)","مدت نمایش هر اسلاید (ثانیه)"),
(None,"Autoplay","پخش خودکار"),
(None,"On","فعال"),
(None,"Off","غیرفعال"),
(None,"Transition effect","افکت تغییر"),
("transition effect","Slide","لغزش"),
(None,"Fade","محو شدن"),
(None,"Corner radius (px)","گردی گوشه‌ها (پیکسل)"),
(None,"Arrows","فلش‌ها"),
(None,"Dots","نقطه‌ها"),
(None,"Shadow","سایه"),
(None,"Yes","دارد"),
(None,"No","ندارد"),
(None,"Top and bottom spacing (px)","فاصله از بالا و پایین (پیکسل)"),
# plugin header
(None,"Tavoos Image Carousel","کاروسل تصویر طاووس"),
(None,"https://tavoosweb.ir/free-wordpress-plugins/","https://tavoosweb.ir/free-wordpress-plugins/"),
(None,"Tavoos Image Carousel: another copy of this plugin is already active. Deactivate the older copy, then activate this one again.","کاروسل تصویر طاووس: نسخه‌ی دیگری از این افزونه از قبل فعال است. نسخه‌ی قدیمی را غیرفعال کنید و بعد این افزونه را دوباره فعال کنید."),
(None,"Lightweight, dependency-free image sliders. Build as many sliders as you need, give every slide a separate mobile image and a link, and place them anywhere with a shortcode (works with Elementor and every page builder). RTL ready.","اسلایدر تصویر سبک و بدون وابستگی. هر تعداد اسلایدر که بخواهید بسازید، برای هر اسلاید تصویر موبایل جدا و لینک بگذارید و با یک کد کوتاه هر جا نمایش دهید (سازگار با المنتور و همه صفحه‌سازها). پشتیبانی کامل از راست‌چین."),
(None,"mmhdih","mmhdih"),
(None,"https://github.com/mmhdih","https://github.com/mmhdih"),
(None,"Designed by Mahdi Habibi | Tavoos Web","طراحی شده توسط مهدی حبیبی | طاووس وب"),
]
def esc(s): return s.replace('\\','\\\\').replace('"','\\"')
head='''msgid ""
msgstr ""
"Project-Id-Version: Tavoos Image Carousel 2.1.0\\n"
"Report-Msgid-Bugs-To: https://github.com/mmhdih/Max-Slider-for-Wordpress/issues\\n"
"MIME-Version: 1.0\\n"
"Content-Type: text/plain; charset=UTF-8\\n"
"Content-Transfer-Encoding: 8bit\\n"
"X-Domain: tavoos-image-carousel\\n"
'''
def entries(tr):
    out=[]
    for c,m,t in T:
        e=''
        if '%' in m: e+='#, php-format\n'
        if c: e+='msgctxt "%s"\n'%esc(c)
        e+='msgid "%s"\nmsgstr "%s"\n'%(esc(m),esc(t if tr else ''))
        out.append(e)
    return '\n'.join(out)
open(L+'tavoos-image-carousel-fa_IR.po','w').write(head.replace('"MIME','"Language: fa_IR\\n"\n"Plural-Forms: nplurals=1; plural=0;\\n"\n"MIME')+'\n'+entries(True))
# mo
meta='Project-Id-Version: Tavoos Image Carousel 2.1.0\nLanguage: fa_IR\nMIME-Version: 1.0\nContent-Type: text/plain; charset=UTF-8\nContent-Transfer-Encoding: 8bit\nPlural-Forms: nplurals=1; plural=0;\n'
pairs={'':meta}
for c,m,t in T: pairs[(c+'\x04'+m) if c else m]=t
keys=sorted(pairs,key=lambda k:k.encode())
ids=b'';strs=b'';off=[]
for k in keys:
    kb=k.encode();vb=pairs[k].encode()
    off.append((len(ids),len(kb),len(strs),len(vb)));ids+=kb+b'\0';strs+=vb+b'\0'
n=len(keys);ko=28;vo=ko+n*8;ds=vo+n*8
out=struct.pack('<7I',0x950412de,0,n,ko,vo,0,0)
for a,l,_,_ in off: out+=struct.pack('<2I',l,ds+a)
for _,_,a,l in off: out+=struct.pack('<2I',l,ds+len(ids)+a)
open(L+'tavoos-image-carousel-fa_IR.mo','wb').write(out+ids+strs)
print(n,'entries')

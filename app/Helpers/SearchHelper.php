<?php
namespace App\Helpers;

use Config\Database;
use PDO;

class SearchHelper {
    /**
     * Dictionary of Islamic, Bengali, and English words for smart transliteration and synonym matching.
     */
    private static $dictionary = [
        'ramjan' => ['রমজান', 'রমযান', 'রামাদান', 'রমজানের'],
        'romjan' => ['রমজান', 'রমযান', 'রামাদান', 'রমজানের'],
        'ramadan' => ['রমজান', 'রমযান', 'রামাদান', 'রমজানের'],
        'ramzan' => ['রমজান', 'রমযান', 'রামাদান'],
        'roja' => ['রোজা', 'রোযা', 'সিয়াম', 'সিয়াম', 'রোজার'],
        'roza' => ['রোজা', 'রোযা', 'সিয়াম', 'সিয়াম', 'রোজার'],
        'siyam' => ['সিয়াম', 'সিয়াম', 'রোজা', 'রোযা'],
        'siam' => ['সিয়াম', 'সিয়াম', 'রোজা'],
        'fasting' => ['রোজা', 'সিয়াম', 'সিয়াম'],
        'namaj' => ['নামাজ', 'নামায', 'সালাত', 'নামাজের', 'নামাযের'],
        'namaz' => ['নামাজ', 'নামায', 'সালাত', 'নামাজের', 'নামাযের'],
        'salat' => ['সালাত', 'নামাজ', 'নামায', 'সালাতের'],
        'salah' => ['সালাত', 'নামাজ', 'নামায'],
        'prayer' => ['নামাজ', 'সালাত', 'দোয়া', 'প্রার্থনা'],
        'jakat' => ['যাকাত', 'জাকাত', 'যাকাতের', 'জাকাতের'],
        'zakat' => ['যাকাত', 'জাকাত', 'যাকাতের', 'জাকাতের'],
        'zakaat' => ['যাকাত', 'জাকাত'],
        'charity' => ['যাকাত', 'সদকা', 'দান'],
        'sadaqah' => ['সদকা', 'দান', 'সাদাকাহ'],
        'hadis' => ['হাদিস', 'হাদীস', 'হাদিসে', 'হাদীসে'],
        'hadith' => ['হাদিস', 'হাদীস', 'হাদিসে', 'হাদীসে'],
        'hadees' => ['হাদিস', 'হাদীস'],
        'quran' => ['কুরআন', 'কোরআন', 'কুরআনে', 'কোরআনে', 'কুরআনুল কারীম'],
        'koran' => ['কোরআন', 'কুরআন', 'কুরআনে'],
        'quranul' => ['কুরআনুল', 'কুরআন'],
        'dua' => ['দোয়া', 'দোয়া', 'দোআ', 'মুনাজাত', 'দোয়ার'],
        'dowa' => ['দোয়া', 'দোয়া', 'দোআ', 'মুনাজাত'],
        'duya' => ['দোয়া', 'দোয়া'],
        'supplication' => ['দোয়া', 'মুনাজাত'],
        'ojoo' => ['ওজু', 'ওযূ', 'অজু', 'ওজুর', 'অজুর'],
        'oju' => ['ওজু', 'ওযূ', 'অজু', 'ওজুর'],
        'wudu' => ['ওজু', 'ওযূ', 'অজু'],
        'wudhu' => ['ওজু', 'ওযূ', 'অজু'],
        'ablution' => ['ওজু', 'পবিত্রতা'],
        'gosol' => ['গোসল', 'গোসলের'],
        'gusal' => ['গোসল', 'গোসলের'],
        'ghusl' => ['গোসল', 'গোসলের'],
        'bath' => ['গোসল', 'পবিত্রতা'],
        'pobitro' => ['পবিত্র', 'পবিত্রতা', 'পাক'],
        'purity' => ['পবিত্রতা', 'পবিত্র'],
        'biye' => ['বিয়ে', 'বিবাহ', 'নিকাহ', 'বিয়ের', 'বিবাহের'],
        'beye' => ['বিয়ে', 'বিবাহ', 'নিকাহ'],
        'bibaho' => ['বিবাহ', 'বিয়ে', 'নিকাহ', 'বিবাহের'],
        'nikah' => ['নিকাহ', 'বিবাহ', 'বিয়ে'],
        'marriage' => ['বিয়ে', 'বিবাহ', 'নিকাহ'],
        'cousin' => ['কাজিন', 'বোন', 'ভাই'],
        'kajin' => ['কাজিন', 'বোন', 'ভাই'],
        'bon' => ['বোন'],
        'sister' => ['বোন'],
        'bhai' => ['ভাই'],
        'brother' => ['ভাই'],
        'talaq' => ['তালাক', 'তালাকের'],
        'talak' => ['তালাক', 'তালাকের'],
        'divorce' => ['তালাক', 'বিচ্ছেদ'],
        'porda' => ['পর্দা', 'হিজাব', 'পর্দার'],
        'purdah' => ['পর্দা', 'হিজাব'],
        'hijab' => ['হিজাব', 'পর্দা'],
        'veil' => ['পর্দা', 'হিজাব'],
        'jannat' => ['জান্নাত', 'বেহেশত', 'জান্নাতের', 'জান্নাতে'],
        'jannate' => ['জান্নাতে', 'জান্নাত', 'বেহেশত', 'বেহেশতে', 'জান্নাতের'],
        'jannater' => ['জান্নাতের', 'জান্নাতে', 'জান্নাত', 'বেহেশত', 'বেহেশতের'],
        'zannat' => ['জান্নাত', 'জান্নাতে', 'বেহেশত', 'জান্নাতের'],
        'zannate' => ['জান্নাতে', 'জান্নাত', 'বেহেশত'],
        'behesht' => ['বেহেশত', 'জান্নাত', 'বেহেশতে', 'জান্নাতে'],
        'beheshte' => ['বেহেশতে', 'বেহেশত', 'জান্নাত', 'জান্নাতে'],
        'behest' => ['বেহেশত', 'জান্নাত'],
        'beheste' => ['বেহেশতে', 'বেহেশত', 'জান্নাত'],
        'paradise' => ['জান্নাত', 'বেহেশত', 'জান্নাতে', 'জান্নাতের'],
        'heaven' => ['জান্নাত', 'বেহেশত'],
        'jahannam' => ['জাহান্নাম', 'দোযখ', 'জাহান্নামের', 'জাহান্নামে'],
        'jahanname' => ['জাহান্নামে', 'জাহান্নাম', 'দোযখ', 'দোযখে'],
        'jahannamer' => ['জাহান্নামের', 'জাহান্নামে', 'জাহান্নাম', 'দোযখের'],
        'hell' => ['জাহান্নাম', 'দোযখ'],
        'fojilot' => ['ফজিলত', 'ফযীলত', 'তাৎপর্য', 'মর্যাদা'],
        'fazilat' => ['ফজিলত', 'ফযীলত', 'তাৎপর্য'],
        'virtue' => ['ফজিলত', 'মর্যাদা'],
        'niyom' => ['নিয়ম', 'পদ্ধতি', 'আমল', 'নিয়মে'],
        'niom' => ['নিয়ম', 'পদ্ধতি'],
        'rule' => ['নিয়ম', 'বিধান'],
        'niyot' => ['নিয়ত', 'নিয়ত'],
        'niyat' => ['নিয়ত', 'নিয়ত'],
        'intention' => ['নিয়ত'],
        'shirk' => ['শিরক', 'শিরকের'],
        'polytheism' => ['শিরক'],
        'bidat' => ['বিদআত', 'বেদাত', 'বিদআতের'],
        'bidaat' => ['বিদআত', 'বেদাত'],
        'innovation' => ['বিদআত'],
        'tawba' => ['তাওবা', 'তওবা', 'ক্ষমা'],
        'towba' => ['তওবা', 'তাওবা'],
        'repentance' => ['তাওবা', 'তওবা', 'ক্ষমা'],
        'qurbani' => ['কুরবানি', 'কোরবানি', 'কুরবানির'],
        'korbani' => ['কোরবানি', 'কুরবানি'],
        'sacrifice' => ['কুরবানি', 'কোরবানি'],
        'tarabi' => ['তারাবীহ', 'তারাবি', 'তারাবির'],
        'tarawih' => ['তারাবীহ', 'তারাবি'],
        'tarabih' => ['তারাবীহ', 'তারাবি'],
        'tahajjud' => ['তাহাজ্জুদ', 'তাহাজ্জুদের'],
        'akida' => ['আকিদা', 'আকীদা', 'বিশ্বাস'],
        'aqeedah' => ['আকীদা', 'আকিদা', 'বিশ্বাস'],
        'aqidah' => ['আকিদা', 'আকীদা'],
        'kobor' => ['কবর', 'কবরের', 'সমাধি'],
        'qabr' => ['কবর', 'কবরের'],
        'grave' => ['কবর'],
        'azab' => ['আজাব', 'আযাব', 'শাস্তি'],
        'ajab' => ['আজাব', 'আযাব', 'শাস্তি'],
        'punishment' => ['আজাব', 'আযাব', 'শাস্তি'],
        'kiamat' => ['কিয়ামত', 'কিয়ামাত', 'হাশর'],
        'qiyamat' => ['কিয়ামাত', 'কিয়ামত', 'হাশর', 'মহাপ্রলয়'],
        'resurrection' => ['কিয়ামত', 'কিয়ামাত', 'হাশর', 'পুনরুত্থান'],
        'judgement' => ['কিয়ামত', 'হাশর', 'বিচার'],
        'sud' => ['সুদ', 'রিবা', 'সুদের'],
        'riba' => ['রিবা', 'সুদ'],
        'interest' => ['সুদ', 'রিবা'],
        'halal' => ['হালাল', 'বৈধ'],
        'permissible' => ['হালাল', 'বৈধ'],
        'haram' => ['হারাম', 'অবৈধ', 'নিষিদ্ধ'],
        'forbidden' => ['হারাম', 'নিষিদ্ধ'],
        'iman' => ['ঈমান', 'ইমান', 'বিশ্বাস', 'ঈমানের'],
        'eeman' => ['ঈমান', 'ইমান', 'বিশ্বাস'],
        'faith' => ['ঈমান', 'বিশ্বাস'],
        'belief' => ['বিশ্বাস', 'ঈমান'],
        'masla' => ['মাসআলা', 'মাসলা', 'বিধান'],
        'masala' => ['মাসআলা', 'মাসলা'],
        'fatwa' => ['ফতোয়া', 'ফতওয়া'],
        'sohih' => ['সহীহ', 'সহিহ'],
        'sahih' => ['সহীহ', 'সহিহ'],
        'authentic' => ['সহীহ', 'সহিহ'],
        'bukhari' => ['বুখারী', 'বুখারি'],
        'muslim' => ['মুসলিম'],
        'tirmizi' => ['তিরমিযী', 'তিরমিজি'],
        'allah' => ['আল্লাহ', 'রব', 'স্রষ্টা', 'আল্লাহর'],
        'god' => ['আল্লাহ', 'রব', 'স্রষ্টা'],
        'creator' => ['স্রষ্টা', 'আল্লাহ', 'সৃষ্টিকর্তা'],
        'sristikorta' => ['সৃষ্টিকর্তা', 'স্রষ্টা', 'আল্লাহ'],
        'muhammad' => ['মুহাম্মদ', 'মোহাম্মদ', 'রাসুলুল্লাহ', 'নবী'],
        'mohammad' => ['মুহাম্মদ', 'মোহাম্মদ'],
        'prophet' => ['নবী', 'রাসূল', 'রাসুল'],
        'nabi' => ['নবী', 'নবীর'],
        'rasul' => ['রাসুল', 'রাসূল', 'রাসুলুল্লাহ'],
        'roshul' => ['রাসুল', 'রাসূল'],
        'messenger' => ['রাসুল', 'রাসূল', 'নবী'],
        'miraj' => ['মিরাজ', 'মেরাজ'],
        'meraj' => ['মিরাজ', 'মেরাজ'],
        'biggan' => ['বিজ্ঞান', 'বৈজ্ঞানিক'],
        'science' => ['বিজ্ঞান', 'বৈজ্ঞানিক'],
        'scientific' => ['বৈজ্ঞানিক', 'বিজ্ঞান'],
        'universe' => ['মহাবিশ্ব', 'মহাজগত', 'সৃষ্টি'],
        'mohabiswo' => ['মহাবিশ্ব', 'মহাজগত'],
        'mohajogot' => ['মহাজগত', 'মহাবিশ্ব'],
        'sristi' => ['সৃষ্টি', 'মহাবিশ্ব'],
        'creation' => ['সৃষ্টি'],
        'shristi' => ['সৃষ্টি'],
        'fitra' => ['ফিতরা', 'সদকাতুল ফিতর'],
        'fitrah' => ['ফিতরা'],
        'eid' => ['ঈদ', 'ঈদের'],
        'hajj' => ['হজ', 'হজ্জ', 'হজের'],
        'haj' => ['হজ', 'হজ্জ'],
        'pilgrimage' => ['হজ', 'হজ্জ'],
        'umrah' => ['উমরাহ', 'উমরা'],
        'umra' => ['উমরাহ', 'উমরা'],
        'masjid' => ['মসজিদ', 'মসজিদে'],
        'mosque' => ['মসজিদ'],
        'azan' => ['আজান', 'আযান'],
        'adzan' => ['আজান', 'আযান'],
        'ajan' => ['আজান'],
        'sehri' => ['সেহরি', 'সাহরী', 'সেহরির'],
        'seheri' => ['সেহরি', 'সাহরী'],
        'iftar' => ['ইফতার', 'ইফতারি', 'ইফতারের'],
        'iftari' => ['ইফতার', 'ইফতারি'],
        'shob e qadr' => ['শবে কদর', 'লাইলাতুল কদর', 'কদর'],
        'laylatul qadr' => ['লাইলাতুল কদর', 'শবে কদর'],
        'shob e barat' => ['শবে বরাত', 'লাইলাতুল বরাত'],
        'dajjal' => ['দাজ্জাল'],
        'mahdi' => ['মাহদী', 'মাহদি'],
        'isa' => ['ঈসা', 'ইসা'],
        'musa' => ['মুসা', 'মূসা'],
        'ibrahim' => ['ইব্রাহিম', 'ইব্রাহীম'],
        'adam' => ['আদম'],
        'feresta' => ['ফেরেশতা', 'ফেরেশতারা'],
        'angel' => ['ফেরেশতা'],
        'jinn' => ['জিন', 'জ্বীন'],
        'zin' => ['জিন', 'জ্বীন'],
        'shoytan' => ['শয়তান', 'ইবলিস'],
        'shaitan' => ['শয়তান', 'ইবলিস'],
        'devil' => ['শয়তান'],
        'satun' => ['শয়তান'],
        'satan' => ['শয়তান'],
        'gunah' => ['গুনাহ', 'পাপ'],
        'sin' => ['গুনাহ', 'পাপ'],
        'pap' => ['পাপ', 'গুনাহ'],
        'sawab' => ['সওয়াব', 'নেকি'],
        'thawab' => ['সওয়াব', 'নেকি'],
        'reward' => ['সওয়াব', 'পুরস্কার'],
        'somoy' => ['সময়', 'সময়সূচী'],
        'shomoy' => ['সময়', 'সময়সূচী'],
        'time' => ['সময়', 'সময়সূচী'],
        'bipod' => ['বিপদ', 'মুসিবত'],
        'shanti' => ['শান্তি'],
        'peace' => ['শান্তি'],
        'chele' => ['ছেলে', 'পুত্র', 'সন্তান'],
        'meye' => ['মেয়ে', 'কন্যা', 'সন্তান'],
        'sontan' => ['সন্তান'],
        'child' => ['সন্তান', 'বাচ্চা'],
        'ma' => ['মা', 'মাতা'],
        'baba' => ['বাবা', 'পিতা'],
        'mother' => ['মা', 'মাতা'],
        'father' => ['বাবা', 'পিতা'],
        'shami' => ['স্বামী'],
        'stri' => ['স্ত্রী', 'বউ'],
        'husband' => ['স্বামী'],
        'wife' => ['স্ত্রী', 'বউ'],
        'mrityu' => ['মৃত্যু', 'মরণ'],
        'death' => ['মৃত্যু'],
        'moron' => ['মরণ', 'মৃত্যু'],
        'sobdo' => ['শব্দ'],
        'prosno' => ['প্রশ্ন', 'প্রশ্নোত্তর'],
        'question' => ['প্রশ্ন', 'প্রশ্নোত্তর'],
        'uttor' => ['উত্তর', 'সমাধান'],
        'answer' => ['উত্তর', 'সমাধান'],
        'hur' => ['হুর', 'হূর', 'হুরদের', 'হুরপরী'],
        'hoor' => ['হুর', 'হূর', 'হুরদের'],
        'nari' => ['নারী', 'নারীর', 'নারীদের', 'মহিলা', 'স্ত্রী'],
        'narir' => ['নারীর', 'নারী', 'নারীদের'],
        'narider' => ['নারীদের', 'নারীর', 'নারী'],
        'purush' => ['পুরুষ', 'পুরুষের', 'পুরুষদের'],
        'purusher' => ['পুরুষের', 'পুরুষ', 'পুরুষদের'],
        'dampotto' => ['দাম্পত্য', 'দাম্পত্যের', 'বিয়ে'],
        'amol' => ['আমল', 'আমলের', 'নেক আমল'],
        'amoler' => ['আমলের', 'আমল'],
        'irsha' => ['ঈর্ষা', 'হিংসা', 'ঈর্ষার'],
        'irshar' => ['ঈর্ষার', 'ঈর্ষা', 'হিংসা'],
        'duniya' => ['দুনিয়া', 'দুনিয়ায়', 'দুনিয়ার'],
        'dunia' => ['দুনিয়া', 'দুনিয়ায়', 'দুনিয়ার'],
        'duniar' => ['দুনিয়ার', 'দুনিয়া', 'দুনিয়ায়'],
        'duniay' => ['দুনিয়ায়', 'দুনিয়া', 'দুনিয়ার'],
        'akherat' => ['আখেরাত', 'আখিরাত', 'আখেরাতের', 'আখিরাতের'],
        'akhira' => ['আখিরাত', 'আখেরাত', 'আখিরাতের'],
        'akherate' => ['আখেরাতে', 'আখিরাতে', 'আখেরাত'],
        'islame' => ['ইসলামে', 'ইসলাম', 'ইসলামের'],
        'islamer' => ['ইসলামের', 'ইসলামে', 'ইসলাম'],
        'namaje' => ['নামাজে', 'নামাজ', 'নামায', 'সালাত', 'সালাতে'],
        'namajer' => ['নামাজের', 'নামাজে', 'নামাজ', 'নামায', 'সালাতের'],
        'hadise' => ['হাদিসে', 'হাদীসে', 'হাদিস', 'হাদীস'],
        'hadiser' => ['হাদিসের', 'হাদীসের', 'হাদিস', 'হাদীস'],
        'hadisgulo' => ['হাদিসগুলো', 'হাদিস', 'হাদীস'],
        'qurane' => ['কুরআনে', 'কোরআনে', 'কুরআন', 'কোরআন'],
        'quraner' => ['কুরআনের', 'কোরআনের', 'কুরআন', 'কোরআন'],
        'rojay' => ['রোজায়', 'রোজা', 'রোযায়', 'রোযা', 'সিয়ামে'],
        'rojar' => ['রোজার', 'রোজা', 'রোযার', 'রোযা', 'সিয়ামের'],
        'masjide' => ['মসজিদে', 'মসজিদ', 'মসজিদের'],
        'masjider' => ['মসজিদের', 'মসজিদে', 'মসজিদ'],
        'kobore' => ['কবরে', 'কবর', 'কবরের'],
        'koborer' => ['কবরের', 'কবরে', 'কবর'],
        'kiamate' => ['কিয়ামতে', 'কিয়ামাতে', 'কিয়ামত'],
        'kiamater' => ['কিয়ামতের', 'কিয়ামাতের', 'কিয়ামত'],
    ];

    /**
     * Phonetically transliterate Romanized/Banglish text to Bangla characters.
     */
    public static function banglishToBanglaPhonetic($word) {
        $w = strtolower(trim($word));
        if (empty($w)) return '';

        $vowelsInit = [
            'aa' => 'আ', 'a' => 'আ',
            'ee' => 'ঈ', 'i' => 'ই',
            'oo' => 'উ', 'u' => 'উ',
            'oi' => 'ঐ', 'ou' => 'ঔ',
            'e'  => 'এ', 'o' => 'ও',
        ];

        $consonants = [
            'shth' => 'ষ্ঠ', 'chch' => 'চ্ছ', 'kkh' => 'ক্ষ', 'cch' => 'চ্ছ', 'chh' => 'ছ', 'ch' => 'চ',
            'kh'  => 'খ', 'gh'  => 'ঘ', 'ng'  => 'ং', 'jh'  => 'ঝ',
            'th'  => 'থ', 'dh'  => 'ধ', 'ph'  => 'ফ', 'bh'  => 'ভ',
            'sh'  => 'শ',
            'nn'  => 'ন্ন', 'tt'  => 'ত্ত', 'dd'  => 'দ্দ', 'mm'  => 'ম্ম',
            'll'  => 'ল্ল', 'bb'  => 'ব্ব', 'kk'  => 'ক্ক', 'jj'  => 'জ্জ',
            'ss'  => 'স্স', 'pp'  => 'প্প', 'gg'  => 'গ্গ',
            'nt'  => 'ন্ত', 'nd'  => 'ন্দ', 'st'  => 'স্ত',
            'k'   => 'ক', 'g'   => 'গ', 'j'   => 'জ',
            'z'   => 'জ', 't'   => 'ত', 'd'   => 'দ', 'n'   => 'ন',
            'p'   => 'প', 'f'   => 'ফ', 'b'   => 'ব', 'v'   => 'ভ',
            'm'   => 'ম', 'r'   => 'র', 'l'   => 'ল', 's'   => 'স',
            'h'   => 'হ', 'y'   => 'য়', 'w'   => 'ওয়'
        ];

        $vowelsKar = [
            'aa' => 'া', 'ee' => 'ী', 'ii' => 'ী', 'oo' => 'ূ', 'uu' => 'ূ',
            'oi' => 'ৈ', 'ou' => 'ৌ', 'a' => 'া', 'i' => 'ি', 'u' => 'ু',
            'e'  => 'ে', 'o'  => 'ো'
        ];

        $out = '';
        $len = strlen($w);
        $i = 0;
        $prevWasConsonant = false;

        while ($i < $len) {
            $sub4 = substr($w, $i, 4);
            if (isset($consonants[$sub4])) {
                $out .= $consonants[$sub4];
                $i += 4;
                $prevWasConsonant = true;
                continue;
            }

            $sub3 = substr($w, $i, 3);
            if (isset($consonants[$sub3])) {
                $out .= $consonants[$sub3];
                $i += 3;
                $prevWasConsonant = true;
                continue;
            }

            $sub2 = substr($w, $i, 2);
            if ($prevWasConsonant && isset($vowelsKar[$sub2])) {
                $out .= $vowelsKar[$sub2];
                $i += 2;
                $prevWasConsonant = false;
                continue;
            } elseif (!$prevWasConsonant && isset($vowelsInit[$sub2])) {
                $out .= $vowelsInit[$sub2];
                $i += 2;
                $prevWasConsonant = false;
                continue;
            } elseif (isset($consonants[$sub2])) {
                $out .= $consonants[$sub2];
                $i += 2;
                $prevWasConsonant = true;
                continue;
            }

            $sub1 = substr($w, $i, 1);
            if ($prevWasConsonant && isset($vowelsKar[$sub1])) {
                if ($sub1 === 'a') {
                    $out .= 'া';
                } else {
                    $out .= $vowelsKar[$sub1];
                }
                $i += 1;
                $prevWasConsonant = false;
                continue;
            } elseif (!$prevWasConsonant && isset($vowelsInit[$sub1])) {
                $out .= $vowelsInit[$sub1];
                $i += 1;
                $prevWasConsonant = false;
                continue;
            } elseif (isset($consonants[$sub1])) {
                $out .= $consonants[$sub1];
                $i += 1;
                $prevWasConsonant = true;
                continue;
            } else {
                $out .= $sub1;
                $i += 1;
                $prevWasConsonant = false;
            }
        }

        return $out;
    }

    /**
     * Strip common Banglish case suffixes (e.g. jannate -> jannat, hadisgulo -> hadis).
     */
    public static function stripBanglishSuffixes($w) {
        $suffixes = [
            'shomuho', 'somuho', 'gulo', 'gula', 'guli', 'derke', 'der',
            'theke', 'hote', 'tay', 'tey', 'teu', 'te', 'er', 'ke', 'ta', 'ti', 'to',
            'e', 'r', 'y'
        ];
        $stems = [];
        $wLen = strlen($w);
        foreach ($suffixes as $suf) {
            $len = strlen($suf);
            if ($wLen > $len + 2 && substr($w, -$len) === $suf) {
                $stems[] = substr($w, 0, -$len);
            }
        }
        return array_unique($stems);
    }

    /**
     * Strip common Bengali grammatical suffixes (বিভক্তি ও প্রত্যয়).
     * e.g. জান্নাতে -> জান্নাত, হাদিসগুলো -> হাদিস, রোজার -> রোজা
     */
    public static function stripBanglaSuffixes($w) {
        $suffixes = [
            'সমূহ', 'গুলো', 'গুলি', 'দেরকে', 'দের',
            'থেকে', 'হতে', 'দ্বারা', 'তেই', 'তায়', 'তে',
            'ের', 'কে', 'টি', 'টা',
            'ে', 'র', 'য়'
        ];
        $stems = [];
        $wLen = mb_strlen($w, 'UTF-8');
        foreach ($suffixes as $suf) {
            $len = mb_strlen($suf, 'UTF-8');
            if ($wLen >= $len + 2) {
                if (mb_substr($w, -$len, null, 'UTF-8') === $suf) {
                    $stems[] = mb_substr($w, 0, -$len, 'UTF-8');
                }
            }
        }
        return array_unique($stems);
    }

    /**
     * Generate common Bengali grammatical inflections (বিভক্তি রূপান্তর).
     * e.g. জান্নাত -> জান্নাতে, জান্নাতের, জান্নাতকে
     *      রোজা -> রোজার, রোজায়, রোজাটি
     */
    public static function generateBanglaInflections($root) {
        $root = trim($root);
        $len = mb_strlen($root, 'UTF-8');
        if ($len < 2 || $len > 15) return [];

        if ($root === 'আল্লাহ') {
            return ['আল্লাহর', 'আল্লাহকে', 'আল্লাহ তায়ালা', 'আল্লাহ তাআলা'];
        }

        $inflections = [];
        $lastChar = mb_substr($root, -1, 1, 'UTF-8');
        $vowelKars = ['া', 'ি', 'ী', 'ু', 'ূ', 'ে', 'ো'];

        if (in_array($lastChar, $vowelKars, true)) {
            $inflections[] = $root . 'র';
            $inflections[] = $root . 'য়';
            $inflections[] = $root . 'তে';
        } else {
            $inflections[] = $root . 'ে';
            $inflections[] = $root . 'ের';
            $inflections[] = $root . 'কে';
        }

        return $inflections;
    }

    /**
     * Normalize Bengali text to handle homophones and spelling variations.
     */
    public static function normalizeBangla($text) {
        $search  = ['য়', 'ড়', 'ঢ়', 'ৎ', 'ী', 'ূ', 'য', 'ষ', 'ণ', '্'];
        $replace = ['য়', 'ড়', 'ঢ়', 'ত', 'ি', 'ু', 'জ', 'শ', 'ন', ''];
        return str_replace($search, $replace, $text);
    }

    /**
     * Expand query into multilingual tokens and synonyms.
     */
    public static function expandQuery($rawQuery) {
        $q = trim(mb_strtolower($rawQuery, 'UTF-8'));
        if (empty($q)) return [];

        $expanded = [$q];

        // Check full phrase in dictionary
        if (isset(self::$dictionary[$q])) {
            foreach (self::$dictionary[$q] as $var) {
                $expanded[] = $var;
            }
        }

        // Split tokens
        $tokens = preg_split('/[\s,\.\+\-_:\/!?()]+/u', $q, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($tokens as $token) {
            $token = trim($token);
            if (empty($token) || mb_strlen($token, 'UTF-8') < 2) continue;
            
            $expanded[] = $token;

            // 1. Direct dictionary lookup
            if (isset(self::$dictionary[$token])) {
                foreach (self::$dictionary[$token] as $var) {
                    $expanded[] = $var;
                }
            }

            // 2. Banglish tokens: strip suffixes & phonetics
            if (preg_match('/^[a-z]+$/i', $token)) {
                $bgStems = self::stripBanglishSuffixes($token);
                foreach ($bgStems as $bgStem) {
                    $expanded[] = $bgStem;
                    if (isset(self::$dictionary[$bgStem])) {
                        foreach (self::$dictionary[$bgStem] as $var) {
                            $expanded[] = $var;
                        }
                    }
                    $stemPhonetic = self::banglishToBanglaPhonetic($bgStem);
                    if (!empty($stemPhonetic) && mb_strlen($stemPhonetic, 'UTF-8') >= 2) {
                        $expanded[] = $stemPhonetic;
                    }
                }

                // Phonetic of the full token
                $phonetic = self::banglishToBanglaPhonetic($token);
                if (!empty($phonetic) && mb_strlen($phonetic, 'UTF-8') >= 2) {
                    $expanded[] = $phonetic;
                }
            }

            // 3. Bangla tokens: strip suffixes & add inflections
            if (preg_match('/[\x{0980}-\x{09FF}]/u', $token)) {
                $bStems = self::stripBanglaSuffixes($token);
                foreach ($bStems as $bStem) {
                    $expanded[] = $bStem;
                    foreach (self::generateBanglaInflections($bStem) as $inf) {
                        $expanded[] = $inf;
                    }
                }

                foreach (self::generateBanglaInflections($token) as $inf) {
                    $expanded[] = $inf;
                }

                // e.g. রমযান <-> রমজান, যাকাত <-> জাকাত
                if (mb_strpos($token, 'য') !== false) {
                    $expanded[] = str_replace('য', 'জ', $token);
                }
                if (mb_strpos($token, 'জ') !== false) {
                    $expanded[] = str_replace('জ', 'য', $token);
                }
                if (mb_strpos($token, 'হাদিস') !== false) {
                    $expanded[] = str_replace('হাদিস', 'হাদীস', $token);
                }
                if (mb_strpos($token, 'হাদীস') !== false) {
                    $expanded[] = str_replace('হাদীস', 'হাদিস', $token);
                }
                if (mb_strpos($token, 'কোরআন') !== false) {
                    $expanded[] = str_replace('কোরআন', 'কুরআন', $token);
                }
                if (mb_strpos($token, 'কুরআন') !== false) {
                    $expanded[] = str_replace('কুরআন', 'কোরআন', $token);
                }
            }

            // Reverse dictionary lookup (if Bangla matches values)
            foreach (self::$dictionary as $eng => $bngList) {
                if (in_array($token, $bngList, true)) {
                    $expanded[] = $eng;
                    foreach ($bngList as $b) {
                        $expanded[] = $b;
                    }
                }
            }
        }

        // For all root Bangla candidates collected, also generate inflections
        $rootsToInflect = [];
        foreach ($expanded as $item) {
            if (preg_match('/^[\x{0980}-\x{09FF}]+$/u', $item)) {
                $rootsToInflect[] = $item;
                $st = self::stripBanglaSuffixes($item);
                foreach ($st as $s) {
                    $rootsToInflect[] = $s;
                }
            }
        }
        foreach (array_unique($rootsToInflect) as $r) {
            foreach (self::generateBanglaInflections($r) as $inf) {
                $expanded[] = $inf;
            }
        }

        return array_values(array_unique(array_filter($expanded)));
    }

    /**
     * Search posts with smart ranking.
     * 
     * Ranking Priority:
     * 1. Exact match in Title (Score +1000)
     * 2. Title starts with query (Score +500)
     * 3. Multiple query tokens match in Title (Score +300 + 100/word)
     * 4. Keywords match (Score +250 full / +80 per word)
     * 5. Category name match (Score +60)
     * 6. Excerpt match (Score +40)
     * 7. Content match (Score +15 per word + frequency)
     */
    public static function searchPosts($rawQuery, $options = []) {
        $limit = isset($options['limit']) ? (int)$options['limit'] : 15;
        $offset = isset($options['offset']) ? (int)$options['offset'] : 0;
        $includeDrafts = !empty($options['include_drafts']);
        $categoryId = isset($options['category_id']) && $options['category_id'] !== '' ? (int)$options['category_id'] : null;

        $db = Database::pdoConnect();
        $q = trim($rawQuery);
        if (empty($q)) return [];

        $variants = self::expandQuery($q);
        if (empty($variants)) return [];

        // Build SQL query for candidate selection
        $likes = [];
        $params = [];
        foreach ($variants as $idx => $v) {
            $paramName = ":v$idx";
            $likes[] = "p.title LIKE $paramName OR p.excerpt LIKE $paramName OR p.seo_keywords LIKE $paramName OR p.content LIKE $paramName OR c.name LIKE $paramName OR c2.name LIKE $paramName";
            $params[$paramName] = '%' . $v . '%';
        }

        $statusClause = $includeDrafts ? "1=1" : "p.status = 'published'";
        $categoryClause = "";
        if ($categoryId !== null) {
            $categoryClause = "AND (p.category_id = :cat_id OR pc.category_id = :cat_id)";
            $params[':cat_id'] = $categoryId;
        }

        $sql = "SELECT p.id, p.category_id, p.title, p.slug, p.excerpt, p.content, p.featured_image, 
                       p.post_type, p.views, p.fake_views, p.status, p.created_at, p.seo_title, p.seo_keywords,
                       COALESCE(c2.name, c.name, 'ইসলাম') as main_category,
                       GROUP_CONCAT(DISTINCT c.name SEPARATOR ', ') as secondary_categories
                FROM posts p
                LEFT JOIN post_categories pc ON p.id = pc.post_id
                LEFT JOIN categories c ON pc.category_id = c.id
                LEFT JOIN categories c2 ON p.category_id = c2.id
                WHERE $statusClause $categoryClause AND (" . implode(" OR ", $likes) . ")
                GROUP BY p.id
                ORDER BY p.id DESC
                LIMIT 300";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $candidates = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($candidates)) return [];

        // Compute relevance scores
        $qLower = mb_strtolower($q, 'UTF-8');
        $qTokens = preg_split('/[\s,\.\+\-_:\/!?()]+/u', $qLower, -1, PREG_SPLIT_NO_EMPTY);
        $scored = [];

        foreach ($candidates as $post) {
            $score = 0;
            $titleLower = mb_strtolower($post['title'], 'UTF-8');
            $kwLower = mb_strtolower($post['seo_keywords'] ?? '', 'UTF-8');
            $catLower = mb_strtolower($post['main_category'] ?? '', 'UTF-8');
            $excerptLower = mb_strtolower($post['excerpt'] ?? '', 'UTF-8');

            // Deep clean and normalize HTML content so all text inside body is searchable
            $rawContent = $post['content'] ?? '';
            $decodedContent = html_entity_decode(strip_tags($rawContent), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $cleanContent = str_replace(["\xc2\xa0", "&nbsp;"], ' ', $decodedContent);
            $cleanContent = trim(preg_replace('/\s+/u', ' ', $cleanContent));
            $contentLower = mb_strtolower($cleanContent, 'UTF-8');

            $matchedInTitle = false;
            $matchedInKeywords = false;
            $matchedInContent = false;
            $contentTokensMatched = 0;

            // 1. Exact full query matching
            if (mb_strpos($titleLower, $qLower) !== false) {
                $score += 1000;
                $matchedInTitle = true;
                if (mb_strpos($titleLower, $qLower) === 0) {
                    $score += 500; // Starts with query!
                }
            }

            if (!empty($kwLower) && mb_strpos($kwLower, $qLower) !== false) {
                $score += 250;
                $matchedInKeywords = true;
            }

            if (!empty($catLower) && mb_strpos($catLower, $qLower) !== false) {
                $score += 150;
            }

            if (!empty($excerptLower) && mb_strpos($excerptLower, $qLower) !== false) {
                $score += 120;
                $matchedInContent = true;
            }

            // Exact full query match inside post content body
            if (!empty($contentLower) && mb_strpos($contentLower, $qLower) !== false) {
                $score += 250;
                $matchedInContent = true;
            }

            // 2. Variants and tokens matching
            foreach ($variants as $v) {
                $vLower = mb_strtolower($v, 'UTF-8');
                if (mb_strlen($vLower, 'UTF-8') < 2) continue;

                // Title score (+120 per matching variant in title)
                if (mb_strpos($titleLower, $vLower) !== false) {
                    $score += 120;
                    $matchedInTitle = true;
                }

                // Keyword score (+60 per matching variant in keywords)
                if (!empty($kwLower) && mb_strpos($kwLower, $vLower) !== false) {
                    $score += 60;
                    $matchedInKeywords = true;
                }

                // Category score (+40)
                if (!empty($catLower) && mb_strpos($catLower, $vLower) !== false) {
                    $score += 40;
                }

                // Excerpt score (+30)
                if (!empty($excerptLower) && mb_strpos($excerptLower, $vLower) !== false) {
                    $score += 30;
                    $matchedInContent = true;
                }

                // Content score (+15 per word occurrence, max +100)
                if (!empty($contentLower)) {
                    $occurrences = mb_substr_count($contentLower, $vLower);
                    if ($occurrences > 0) {
                        $score += min(100, $occurrences * 15);
                        $matchedInContent = true;
                        $contentTokensMatched++;
                    }
                }
            }

            // Bonus if multiple query words match anywhere inside the post content
            if ($contentTokensMatched >= 2) {
                $score += $contentTokensMatched * 50;
            }

            // Match type badge for display
            $matchBadge = 'Content Match';
            if ($matchedInTitle) {
                $matchBadge = 'Title Match';
            } elseif ($matchedInKeywords) {
                $matchBadge = 'Keyword Match';
            }

            // Determine best source for snippet: if match is in content, extract snippet around the matched content!
            $foundInExcerpt = false;
            if (!empty($post['excerpt'])) {
                $exLower = mb_strtolower($post['excerpt'], 'UTF-8');
                foreach ($variants as $v) {
                    $vLower = mb_strtolower($v, 'UTF-8');
                    if (mb_strlen($vLower, 'UTF-8') >= 2 && mb_strpos($exLower, $vLower) !== false) {
                        $foundInExcerpt = true;
                        break;
                    }
                }
            }

            // If the search term matched in content body, extract snippet from content!
            $snippetSource = ($foundInExcerpt || empty($cleanContent)) ? (!empty($post['excerpt']) ? $post['excerpt'] : $cleanContent) : $cleanContent;
            $snippet = self::extractSnippet($snippetSource, $variants, 220);
            $highlightedSnippet = self::highlightText($snippet, $variants);

            $post['score'] = $score;
            $post['match_badge'] = $matchBadge;
            $post['highlighted_title'] = self::highlightText($post['title'], $variants);
            $post['snippet'] = $snippet;
            $post['highlighted_snippet'] = $highlightedSnippet;
            $post['type'] = 'post';
            $post['url'] = URLROOT . '/' . rawurlencode($post['slug']);

            // Don't carry huge content to JSON
            unset($post['content']);

            $scored[] = $post;
        }

        // Sort by Score DESC, then ID DESC
        usort($scored, function($a, $b) {
            if ($a['score'] === $b['score']) {
                return $b['id'] <=> $a['id'];
            }
            return $b['score'] <=> $a['score'];
        });

        // Slice for pagination
        return array_slice($scored, $offset, $limit);
    }

    /**
     * Search user questions & answers with smart ranking.
     */
    public static function searchQuestions($rawQuery, $options = []) {
        $limit = isset($options['limit']) ? (int)$options['limit'] : 10;
        $offset = isset($options['offset']) ? (int)$options['offset'] : 0;
        $status = $options['status'] ?? 'answered';

        $db = Database::pdoConnect();
        $q = trim($rawQuery);
        if (empty($q)) return [];

        $variants = self::expandQuery($q);
        if (empty($variants)) return [];

        // Build SQL query
        $likes = [];
        $params = [];
        foreach ($variants as $idx => $v) {
            $paramName = ":qv$idx";
            $likes[] = "q.question LIKE $paramName OR q.answer LIKE $paramName OR c.name LIKE $paramName";
            $params[$paramName] = '%' . $v . '%';
        }

        $statusClause = $status !== null ? "q.status = :status" : "1=1";
        if ($status !== null) {
            $params[':status'] = $status;
        }

        $sql = "SELECT q.id, q.category_id, q.question, q.answer, q.status, q.created_at,
                       c.name as category_name, c.slug as category_slug
                FROM user_questions q
                LEFT JOIN question_categories c ON q.category_id = c.id
                WHERE $statusClause AND (" . implode(" OR ", $likes) . ")
                ORDER BY q.created_at DESC
                LIMIT 50";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $candidates = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($candidates)) return [];

        $qLower = mb_strtolower($q, 'UTF-8');
        $scored = [];

        foreach ($candidates as $row) {
            $score = 0;
            $questionLower = mb_strtolower($row['question'], 'UTF-8');
            $answerClean = strip_tags($row['answer'] ?? '');
            $answerLower = mb_strtolower($answerClean, 'UTF-8');
            $catLower = mb_strtolower($row['category_name'] ?? '', 'UTF-8');

            $matchedInTitle = false;

            // Full query match
            if (mb_strpos($questionLower, $qLower) !== false) {
                $score += 1000;
                $matchedInTitle = true;
                if (mb_strpos($questionLower, $qLower) === 0) {
                    $score += 500;
                }
            }

            if (!empty($answerLower) && mb_strpos($answerLower, $qLower) !== false) {
                $score += 80;
            }

            // Variants matching
            foreach ($variants as $v) {
                $vLower = mb_strtolower($v, 'UTF-8');
                if (mb_strlen($vLower, 'UTF-8') < 2) continue;

                if (mb_strpos($questionLower, $vLower) !== false) {
                    $score += 120;
                    $matchedInTitle = true;
                }

                if (!empty($answerLower) && mb_strpos($answerLower, $vLower) !== false) {
                    $score += 30;
                }

                if (!empty($catLower) && mb_strpos($catLower, $vLower) !== false) {
                    $score += 40;
                }
            }

            // Make slug for question URL
            $trimmed = mb_strimwidth($row['question'], 0, 100);
            $slug = trim(preg_replace('~[^\p{L}\p{N}\p{M}]+~u', '-', mb_strtolower($trimmed, 'UTF-8')), '-');

            $snippet = self::extractSnippet($answerClean, $variants, 180);

            $row['score'] = $score;
            $row['match_badge'] = $matchedInTitle ? 'Question Match' : 'Answer Match';
            $row['highlighted_question'] = self::highlightText($row['question'], $variants);
            $row['answer_snippet'] = $snippet;
            $row['highlighted_answer'] = self::highlightText($snippet, $variants);
            $row['type'] = 'question';
            $row['url'] = URLROOT . '/question/' . $row['id'] . '/' . rawurlencode($slug);

            $scored[] = $row;
        }

        // Sort by Score DESC
        usort($scored, function($a, $b) {
            if ($a['score'] === $b['score']) {
                return $b['id'] <=> $a['id'];
            }
            return $b['score'] <=> $a['score'];
        });

        return array_slice($scored, $offset, $limit);
    }

    /**
     * Unified search returning both posts and questions.
     */
    public static function searchUnified($rawQuery, $options = []) {
        $postsLimit = $options['posts_limit'] ?? 8;
        $questionsLimit = $options['questions_limit'] ?? 6;

        $posts = self::searchPosts($rawQuery, array_merge($options, ['limit' => $postsLimit]));
        $questions = self::searchQuestions($rawQuery, array_merge($options, ['limit' => $questionsLimit]));

        return [
            'status' => 'success',
            'query' => $rawQuery,
            'total' => count($posts) + count($questions),
            'posts_count' => count($posts),
            'questions_count' => count($questions),
            'posts' => $posts,
            'questions' => $questions
        ];
    }

    /**
     * Highlight matching words in text.
     */
    public static function highlightText($text, $terms) {
        if (empty($text) || empty($terms)) return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

        $cleanText = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
        $safeTerms = [];
        foreach ($terms as $term) {
            $trimmed = trim($term);
            if (mb_strlen($trimmed, 'UTF-8') >= 2) {
                $safeTerms[] = preg_quote($trimmed, '/');
            }
        }

        if (empty($safeTerms)) return $cleanText;

        // Sort terms by length descending so longer words match first
        usort($safeTerms, function($a, $b) {
            return mb_strlen($b, 'UTF-8') <=> mb_strlen($a, 'UTF-8');
        });

        $pattern = '/(' . implode('|', $safeTerms) . ')/iu';
        return preg_replace($pattern, '<mark class="search-highlight">$1</mark>', $cleanText);
    }

    /**
     * Extract a snippet of text surrounding matched keywords.
     */
    public static function extractSnippet($text, $terms, $maxLength = 220) {
        $decoded = html_entity_decode(strip_tags($text), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $clean = str_replace(["\xc2\xa0", "&nbsp;"], ' ', $decoded);
        $clean = trim(preg_replace('/\s+/u', ' ', $clean));
        if (mb_strlen($clean, 'UTF-8') <= $maxLength) {
            return $clean;
        }

        $cleanLower = mb_strtolower($clean, 'UTF-8');
        $bestPos = -1;

        // Sort terms by length DESCENDING so longer/specific words take priority for focal point
        $sortedTerms = $terms;
        usort($sortedTerms, function($a, $b) {
            return mb_strlen($b, 'UTF-8') <=> mb_strlen($a, 'UTF-8');
        });

        foreach ($sortedTerms as $term) {
            $t = trim(mb_strtolower($term, 'UTF-8'));
            if (mb_strlen($t, 'UTF-8') < 2) continue;
            $pos = mb_strpos($cleanLower, $t);
            if ($pos !== false) {
                $bestPos = $pos;
                break; // Found best focal point!
            }
        }

        if ($bestPos === -1) {
            return mb_substr($clean, 0, $maxLength, 'UTF-8') . '...';
        }

        $start = max(0, $bestPos - (int)($maxLength / 3));
        $snippet = mb_substr($clean, $start, $maxLength, 'UTF-8');

        // Clean boundary to avoid cutting words
        if ($start > 0) {
            $firstSpace = mb_strpos($snippet, ' ');
            if ($firstSpace !== false && $firstSpace < 30) {
                $snippet = mb_substr($snippet, $firstSpace + 1);
            }
            $snippet = '...' . $snippet;
        }

        if ($start + $maxLength < mb_strlen($clean, 'UTF-8')) {
            $lastSpace = mb_strrpos($snippet, ' ');
            if ($lastSpace !== false && $lastSpace > ($maxLength - 40)) {
                $snippet = mb_substr($snippet, 0, $lastSpace);
            }
            $snippet .= '...';
        }

        return $snippet;
    }
}

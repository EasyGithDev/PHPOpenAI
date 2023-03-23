<?php

namespace EasyGithDev\PHPOpenAI\Audios;

enum Language: string
{
    case ABKHAZ = "ab";
    case AFAR = "aa";
    case AFRIKAANS = "af";
    case AKAN = "ak";
    case ALBANIAN = "sq";
    case AMHARIC = "am";
    case ARABIC = "ar";
    case ARAGONESE = "an";
    case ARMENIAN = "hy";
    case ASSAMESE = "as";
    case AVARIC = "av";
    case AVESTAN = "ae";
    case AYMARA = "ay";
    case AZERBAIJANI = "az";
    case BAMBARA = "bm";
    case BASHKIR = "ba";
    case BASQUE = "eu";
    case BELARUSIAN = "be";
    case BENGALI_BANGLA = "bn";
    case BIHARI = "bh";
    case BISLAMA = "bi";
    case BOSNIAN = "bs";
    case BRETON = "br";
    case BULGARIAN = "bg";
    case BURMESE = "my";
    case CATALAN = "ca";
    case CHAMORRO = "ch";
    case CHECHEN = "ce";
    case CHICHEWA_CHEWA_NYANJA = "ny";
    case CHINESE = "zh";
    case CHUVASH = "cv";
    case CORNISH = "kw";
    case CORSICAN = "co";
    case CREE = "cr";
    case CROATIAN = "hr";
    case CZECH = "cs";
    case DANISH = "da";
    case DIVEHI_DHIVEHI_MALDIVIAN = "dv";
    case DUTCH = "nl";
    case DZONGKHA = "dz";
    case ENGLISH = "en";
    case ESPERANTO = "eo";
    case ESTONIAN = "et";
    case EWE = "ee";
    case FAROESE = "fo";
    case FIJIAN = "fj";
    case FINNISH = "fi";
    case FRENCH = "fr";
    case FULA_FULAH_PULAAR_PULAR = "ff";
    case GALICIAN = "gl";
    case GEORGIAN = "ka";
    case GERMAN = "de";
    case GREEK = "el";
    case GUARANÍ = "gn";
    case GUJARATI = "gu";
    case HAITIAN_HAITIAN = "ht";
    case HAUSA = "ha";
    case HEBREW = "he";
    case HERERO = "hz";
    case HINDI = "hi";
    case HIRI_MOTU = "ho";
    case HUNGARIAN = "hu";
    case INTERLINGUA = "ia";
    case INDONESIAN = "id";
    case INTERLINGUE = "ie";
    case IRISH = "ga";
    case IGBO = "ig";
    case INUPIAQ = "ik";
    case IDO = "io";
    case ICELANDIC = "is";
    case ITALIAN = "it";
    case INUKTITUT = "iu";
    case JAPANESE = "ja";
    case JAVANESE = "jv";
    case KALAALLISUT_GREENLANDIC = "kl";
    case KANNADA = "kn";
    case KANURI = "kr";
    case KASHMIRI = "ks";
    case KAZAKH = "kk";
    case KHMER = "km";
    case KIKUYU_GIKUYU = "ki";
    case KINYARWANDA = "rw";
    case KYRGYZ = "ky";
    case KOMI = "kv";
    case KONGO = "kg";
    case KOREAN = "ko";
    case KURDISH = "ku";
    case KWANYAMA_KUANYAMA = "kj";
    case LATIN = "la";
    case LUXEMBOURGISH_LETZEBURGESCH = "lb";
    case GANDA = "lg";
    case LIMBURGISH_LIMBURGAN_LIMBURGER = "li";
    case LINGALA = "ln";
    case LAO = "lo";
    case LITHUANIAN = "lt";
    case LUBA_KATANGA = "lu";
    case LATVIAN = "lv";
    case MANX = "gv";
    case MACEDONIAN = "mk";
    case MALAGASY = "mg";
    case MALAY = "ms";
    case MALAYALAM = "ml";
    case MALTESE = "mt";
    case MĀORI = "mi";
    case MARATHI = "mr";
    case MARSHALLESE = "mh";
    case MONGOLIAN = "mn";
    case NAURUAN = "na";
    case NAVAJO_NAVAHO = "nv";
    case NORTHERN_NDEBELE = "nd";
    case NEPALI = "ne";
    case NDONGA = "ng";
    case NORWEGIAN_BOKMÅL = "nb";
    case NORWEGIAN_NYNORSK = "nn";
    case NORWEGIAN = "no";
    case NUOSU = "ii";
    case SOUTHERN_NDEBELE = "nr";
    case OCCITAN = "oc";
    case OJIBWE_OJIBWA = "oj";
    // case OLD CHURCH SLAVONIC_CHURCH SLAVONIC_OLD BULGARIAN="cu";
    case OROMO = "om";
    case ORIYA = "or";
    case OSSETIAN_OSSETIC = "os";
    case PUNJABI = "pa";
    case PĀLI = "pi";
    case PERSIAN = "fa";
    case POLISH = "pl";
    case PASHTO_PUSHTO = "ps";
    case PORTUGUESE = "pt";
    case QUECHUA = "qu";
    case ROMANSH = "rm";
    case KIRUNDI = "rn";
    case ROMANIAN = "ro";
    case RUSSIAN = "ru";
    case SANSKRIT = "sa";
    case SARDINIAN = "sc";
    case SINDHI = "sd";
    case NORTHERN_SAMI = "se";
    case SAMOAN = "sm";
    case SANGO = "sg";
    case SERBIAN = "sr";
    case SCOTTISH = "gd";
    case SHONA = "sn";
    case SINHALESE_SINHALA = "si";
    case SLOVAK = "sk";
    case SLOVENE = "sl";
    case SOMALI = "so";
    case SOUTHERN_SOTHO = "st";
    case SPANISH = "es";
    case SUNDANESE = "su";
    case SWAHILI = "sw";
    case SWATI = "ss";
    case SWEDISH = "sv";
    case TAMIL = "ta";
    case TELUGU = "te";
    case TAJIK = "tg";
    case THAI = "th";
    case TIGRINYA = "ti";
    case TIBETAN = "bo";
    case TURKMEN = "tk";
    case TAGALOG = "tl";
    case TSWANA = "tn";
    case TONGA = "to";
    case TURKISH = "tr";
    case TSONGA = "ts";
    case TATAR = "tt";
    case TWI = "tw";
    case TAHITIAN = "ty";
    case UYGHUR = "ug";
    case UKRAINIAN = "uk";
    case URDU = "ur";
    case UZBEK = "uz";
    case VENDA = "ve";
    case VIETNAMESE = "vi";
    case VOLAPÜK = "vo";
    case WALLOON = "wa";
    case WELSH = "cy";
    case WOLOF = "wo";
    case WESTERN_FRISIAN = "fy";
    case XHOSA = "xh";
    case YIDDISH = "yi";
    case YORUBA = "yo";
    case ZHUANG_CHUANG = "za";
    case ZULU = "zu";
}
